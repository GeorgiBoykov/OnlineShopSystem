<?php

namespace MVCFramework;

class Router
{
    private static $_instance = null;
    private $_config = null;

    protected function __construct(){
        $this->_config = Config::getInstance();
    }

    public static function getInstance(){

        if(self::$_instance == null){
            self::$_instance = new Router();
        }

        return self::$_instance;
    }

    public function execRoute(){
        $requestParts = $this::parseRequest();
        $areaName = $requestParts[0];
        $controllerName = $requestParts[1];
        $customControllerRoutes = $this->getAllClassesCustomRoutes();

        // Check if user has declared custom route for this controller
        if(array_key_exists($controllerName, $customControllerRoutes)){
            $controllerName = $customControllerRoutes[$controllerName];
        }
        else{
            $controllerName = ucfirst(strtolower($controllerName)) . 'Controller';
            // throw Exception if user has declared custom route for this controller
            foreach($customControllerRoutes as $customControllerRoute){
                if(strtolower($customControllerRoute) == strtolower($controllerName)){
                    throw new \Exception("Route is predefined by user");
                }
            }
        }
        // Create controller
        $controllerNamespace = $this->_config->app['namespaces']['ROOT_NAMESPACE'];
        if($areaName !== null){
            $controllerNamespace.='\areas\\'.$areaName;
        }
        $controllerFullName = $controllerNamespace . '\Controllers\\' . $controllerName;
        $controller = new $controllerFullName();

        $actionName = $requestParts[2];
        $customActionRoutes = $this->getAllActionsCustomRoutes($controller);

        // Check if user has declared custom route for this action
        if(array_key_exists($actionName, $customActionRoutes)){
            $actionName = $customActionRoutes[$actionName];
        }
        else{
            // throw Exception if user has declared custom route for this action
            foreach($customActionRoutes as $customActionRoute){
                if(strtolower($customActionRoute) == strtolower($actionName)){
                    throw new \Exception("Route is predefined by user");
                }
            }
        }

        $params = $requestParts[3];

        $this::callController($controller, $actionName, $params);
    }

    private function parseRequest(){
        $requestParts = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $areaName = null;
        $isInArea = in_array($requestParts[1], scandir('../areas'));
        if($isInArea){
            $areaName = $requestParts[1];
        }

        $controllerName = $this->_config->app['controllers']['DEFAULT_CONTROLLER'];

        if (count($requestParts) >= 2 && $requestParts[1] != '' && $isInArea == false) {
            $controllerName = $requestParts[1];
        } elseif(count($requestParts) >= 3 && $requestParts[2] != '' && $isInArea == true){
            $controllerName = $requestParts[2];
        }

        $actionName = $this->_config->app['actions']['DEFAULT_ACTION'];

        if (count($requestParts) >= 3 && $requestParts[2] != '' && $isInArea == false) {
            $actionName = $requestParts[2];
        } elseif(count($requestParts) >= 4 && $requestParts[3] != '' && $isInArea == true){
            $actionName = $requestParts[3];
        }

        $params = null;

        if($isInArea == true){
            $params = array_splice($requestParts, 4);
        } else {
            $params = array_splice($requestParts, 3);
        }

        return array($areaName, $controllerName, $actionName, $params);
    }

    private function callController($controller, $actionName, $params){

        if (method_exists($controller, $actionName)) {
            $actionParamTypes = $this->getFuncParamsTypes($controller, $actionName);

            //checking if function expects binding model
            if(strpos(strtolower($actionParamTypes[0]), 'bindingmodel') !== false){
                $bindingModelClass = $actionParamTypes[0];
                $bindingModel = new $bindingModelClass($_POST);

                //$controller->{$action}($bindingModel);
                call_user_func(array($controller, $actionName), $bindingModel);
            } else{
                //$controller->{$action}($params);
                call_user_func_array(array($controller, $actionName), $params);
            }
        } else {
            die("Cannot find action '$actionName' in the selected controller");
        }
    }

    private function getFuncParamsTypes($class, $func) {
        $refFunc =  new \ReflectionMethod($class, $func);
        $params = [];
        foreach($refFunc->getParameters() as $param) {
            array_push($params, $param->getClass()->name);
        }

        return $params;
    }

    private function getClassCustomRoute($class) {
        $refClass = new \ReflectionClass($class);
        $doc = $refClass->getDocComment();
        preg_match_all("/@Route\(\"(.+)\"\)/", $doc, $annotations);

        return $annotations[1];
    }

    private function getAllClassesCustomRoutes() {
        $classesRoutes = [];
        $declaredControllerFiles = scandir('../controllers');
        foreach($declaredControllerFiles as $fileName){
            if(strpos($fileName, '.php') != false){
                $controllerClassName = (substr($fileName,0,strlen($fileName)-4));
                $controllerFullClassName =
                    $this->_config->app['namespaces']['ROOT_NAMESPACE'] . '\Controllers\\' .$controllerClassName;
                $controller = new $controllerFullClassName();
                $classCustomRoute = $this->getClassCustomRoute($controller)[0];
                if(trim($classCustomRoute) != ""){
                    $classesRoutes[$classCustomRoute] = $controllerClassName;
                }
            }
        }

        return $classesRoutes;
    }

    private function getAllActionsCustomRoutes($class)
    {
        $refClass = new \ReflectionClass($class);
        $refFuncs = $refClass->getMethods();
        $funcsRoutes = [];
        foreach($refFuncs as $refFunc){
            $doc = $refFunc->getDocComment();
            preg_match_all("/@Route\(\"(.+)\"\)/", $doc, $annotations);
            if(count($annotations[1]) > 0){
                $customRoute = $annotations[1][0];
                $funcsRoutes[$customRoute] =  $refFunc->getName();
            }
        }
        return $funcsRoutes;
    }
}