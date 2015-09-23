<?php

namespace MVCFramework;
include_once("Loader.php");

class App
{
    private static $_instance = null;
    private $_config = null;
    private $_router = null;

    protected function __construct(){
        Loader::registerNamespace('MVCFramework', dirname(__FILE__).DIRECTORY_SEPARATOR);
        Loader::registerAutoLoad();

        $this->_config = Config::getInstance();
        //if config folder is not set, use default one
        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }

        $this->registerRootNamespace();
        $this->_router = Router::getInstance();
    }

    public static function getInstance(){
        if(self::$_instance == null){
            self::$_instance =  new App();
        }

        return self::$_instance;
    }

    public function getConfigFolder() {
        return $this->_config->getConfigFolder();
    }

    public function setConfigFolder($path) {
        $this->_config->setConfigFolder($path);
    }

    public function registerRootNamespace(){
        $ns = $this->_config->app['namespaces'];
        Loader::registerNamespace($ns['ROOT_NAMESPACE'], realpath('../../'.$ns['ROOT_NAMESPACE']));
    }

    public function run(){
        $this->_router->execRoute();
    }
}