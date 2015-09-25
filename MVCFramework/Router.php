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
        if($controllerAuthorization == true && !isset($_SESSION['user_id'])){
            throw new \Exception("Authorization has been denied for this controller");
        }
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
