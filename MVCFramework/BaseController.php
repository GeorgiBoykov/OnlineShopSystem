<?php

namespace MVCFramework;

abstract class BaseController{
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

    public function isLogged(){
        return isset($_SESSION['user_id']);
    }

    /**
     * @param $toEscape
     * @return BaseViewModel
     */
    public function escape(&$toEscape){
        if(is_array($toEscape)){
            foreach($toEscape as $key => &$value){
                if(is_object($value)){
                    $reflection = new \ReflectionClass($value);
                    $properties = $reflection->getProperties();

                    foreach($properties as &$property){
                        $property->setAccessible(true);
                        $property->setValue($value, $this->escape($property->getValue($value)));
                    }
                } else if(is_array($value)){
                    $this->escape($value);
                } else{
                    $value = htmlspecialchars($value);
                }
            }
        } else if(is_object($toEscape)){
            $reflection = new \ReflectionClass($toEscape);
            $properties = $reflection->getProperties();

            foreach($properties as &$property){
                $property->setAccessible(true);
                $property->setValue($toEscape, $this->escape($property->getValue($toEscape)));
            }
        } else{
            $toEscape = htmlspecialchars($toEscape);
        }

        return $toEscape;
    }
}
