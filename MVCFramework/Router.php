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
        $controllerFullName = $controllerNamespace . '\controllers\\' . $controllerName;
        $controller = new $controllerFullName();

        // Check controller for authorization attribute (@Authorize)
        $controllerAuthorization = count($this->getClassAnnotations($controllerFullName)[1]) > 0;
        if($controllerAuthorization == true && !isset($_SESSION['is_logged'])){
            throw new \Exception("Authorization has been denied for this controller");
        }
        $actionName = strtolower($requestParts[2]);
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

        // Check controller for authorization attribute (@Authorize)
        $actionAuthorization = count($this->getActionAuthorization($controller, $actionName)) > 0;
        if($actionAuthorization == true && !isset($_SESSION['user_id'])){
            throw new \Exception("Authorization has been denied for this action");
        }
        $params = $requestParts[3];

        $this::callController($controller, $actionName, $params);
    }

    private function parseRequest(){
        $requestParts = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $areaName = null;
        $isInArea = in_array(strtolower($requestParts[1]), scandir('../areas'));
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
            //checking if function expects binding model
            $isInstanceOfBindingModel = false;
            $funcFirstParam = $this->getFuncFirstParam($controller, $actionName);
            if(!is_null($funcFirstParam)){
                $isInstanceOfBindingModel =
                    $funcFirstParam->isSubclassOf(new \ReflectionClass( 'MVCFramework\BaseBindingModel' ));
            }

            if($isInstanceOfBindingModel){
                $bindingModelClass = $funcFirstParam->name;
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

    private function getFuncFirstParam($class, $func) {
        $refFunc =  new \ReflectionMethod($class, $func);
        $funcParam = $refFunc->getParameters();
        if(!is_null($funcParam[0])){
            return $funcParam[0]->getClass();
        }

        return null;
    }

    private function getAllClassesCustomRoutes() {
        $classesRoutes = [];
        $declaredControllerFiles = scandir('../controllers');
        foreach($declaredControllerFiles as $fileName){
            if(strpos($fileName, '.php') != false){
                $controllerName = (substr($fileName,0,strlen($fileName)-4));
                $controllerFullName = $this->_config->app['namespaces']['ROOT_NAMESPACE']
                     . '\controllers\\' .$controllerName;
                $classCustomRoute = $this->getClassAnnotations($controllerFullName)[0];
                if(trim($classCustomRoute) != ""){
                    $classesRoutes[$classCustomRoute] = $controllerName;
                }
            }
        }

        return $classesRoutes;
    }

    private function getClassAnnotations($class) {
        $refClass = new \ReflectionClass($class);
        $doc = $refClass->getDocComment();
        preg_match_all("/@Route\([\"'](.+)[\"']\)/", $doc, $routes);
        preg_match_all("/@Authorize/", $doc, $authorizations);

        return array($routes[1][0], $authorizations[0]);
    }

    private function getAllActionsCustomRoutes($class)
    {
        $refClass = new \ReflectionClass($class);
        $refFuncs = $refClass->getMethods();
        $funcsRoutes = [];
        foreach($refFuncs as $refFunc){
            $doc = $refFunc->getDocComment();
            preg_match_all("/@Route\([\"'](.+)[\"']\)/", $doc, $routes);
            if(count($routes[1]) > 0){
                $customRoute = $routes[1][0];
                $funcsRoutes[$customRoute] =  $refFunc->getName();
            }
        }
        return $funcsRoutes;
    }

    private function getActionAuthorization($class, $action)
    {
        $refMethod = new \ReflectionMethod($class, $action);
        $doc = $refMethod->getDocComment();
        preg_match_all("/@Authorize/", $doc, $authorizations);

        return $authorizations[0];
    }
}