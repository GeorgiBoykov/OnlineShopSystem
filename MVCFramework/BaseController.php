<?php

namespace MVCFramework;

abstract class BaseController{
    public $isLogged = false;
    public $config = null;

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->isPost = true;
        }
        $this->config = Config::getInstance();
        $this->onInit();
    }

    public function onInit(){
    }

    abstract public function index();

    public function redirect(
        $controllerName, $actionName = null, $params = null) {
        $url = '/' . urlencode($controllerName);
        if ($actionName != null) {
            $url .= '/' . urlencode($actionName);
        }
        if ($params != null) {
            $encodedParams = array_map($params, 'urlencode');
            $url .= implode('/', $encodedParams);
        }
        $this->redirectToUrl($url);
    }

    public function redirectToUrl($url) {
        header("Location: " . $url);
        die;
    }
}
