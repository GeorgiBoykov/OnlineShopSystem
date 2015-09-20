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

        $this::callController($requestParts[0], $requestParts[1], $requestParts[2]);
    }

    private function parseRequest(){
        $requestParts = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $controllerName = $this->_config->app['controllers']['DEFAULT_CONTROLLER'];

        if (count($requestParts) >= 2 && $requestParts[1] != '') {
            $controllerName = $requestParts[1];
        }

        $action = $this->_config->app['actions']['DEFAULT_ACTION'];

        if (count($requestParts) >= 3 && $requestParts[2] != '') {
            $action = $requestParts[2];
        }

        $params = array_splice($requestParts, 3);

        return array($controllerName, $action, $params);
    }

    private function callController($controllerName, $action, $params){
        $controllerClassName = ucfirst(strtolower($controllerName)) . 'Controller';
        $controllerClass =
            'Controllers\\' .ucfirst(strtolower($controllerName)) . 'Controller';

        $controller = new $controllerClass($controllerClassName, $action);

        if (method_exists($controller, $action)) {

            //$controller->{$action}($params);
            call_user_func_array(array($controller, $action), $params);
            $controller->renderView();
        } else {
            die("Cannot find action '$action' in controller '$controllerClassName'");
        }
    }
}