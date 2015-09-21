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
            $this->setConfigFolder('config');
        }
        $this->registerNamespaces();
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

    public function registerNamespaces(){
        $ns = $this->_config->app['namespaces'];
        // IF NOT SET IN CONFIG, SET DEFAULT CONTROLLER AND MODELS PATH
        if(is_null($ns) || !array_key_exists("Controllers", $ns)){
            Loader::registerNamespace('Controllers', realpath('controllers'));
        }

        if(is_null($ns) || !array_key_exists("Models", $ns)){
            Loader::registerNamespace('Models', realpath('models'));
        }

        if(is_null($ns) || !array_key_exists("Views", $ns)){
            Loader::registerNamespace('Views', realpath('views'));
        }

        if (is_array($ns)) {
            Loader::registerNamespaces($ns);
        }
    }

    public function run(){
        $this->_router->execRoute();
    }
}