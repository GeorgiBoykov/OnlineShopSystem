<?php

namespace MVCFramework;

abstract class BaseController {
    private $_config = null;
    private $_controllerFullName;
    private $_actionName;
    private $_isViewRendered = false;

    function __construct($controllerName, $actionName) {
        $this->_config = Config::getInstance();
        $this->_controllerFullName = $controllerName;
        $this->_actionName = $actionName;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->isPost = true;
        }
        $this->onInit();
    }

    public function onInit() {
        // Implement initializing logic in the subclasses
    }

    public function index() {
        // Implement the default action in the subclasses
    }

    public function renderView($viewName = null, $includeLayout = true) {
        if (!$this->_isViewRendered) {
            if ($viewName == null) {
                $viewName = $this->_actionName;
            }
            $controllerClassName = strtolower(str_replace('Controller','', $this->_controllerFullName ));
            $viewFileName = realpath('views'). "/" . $controllerClassName."/".$viewName.".php";
            include_once($viewFileName);
            $this->_isViewRendered = true;
        }
    }

    public function redirectToUrl($url) {
        header("Location: " . $url);
        die;
    }
}
