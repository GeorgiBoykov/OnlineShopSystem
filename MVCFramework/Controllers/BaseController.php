<?php

namespace MVCFramework\Controllers;

abstract class BaseController{
    private $_controllerFullName;
    private $_actionName;

    public function __construct($controllerName, $actionName) {
        $this->_controllerFullName = $controllerName;
        $this->_actionName = $actionName;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->isPost = true;
        }
    }

    abstract public function index();

    public function redirectToUrl($url) {
        header("Location: " . $url);
        die;
    }
}
