<?php

namespace MVCFramework;
include_once("Loader.php");

class App
{
    private static $instance;
    private $_config = null;

    protected function __construct(){
        Loader::registerNamespace('MVCFramework', dirname(__FILE__).DIRECTORY_SEPARATOR);
        Loader::registerAutoLoad();
        $this->_config = Config::getInstance();
        //if config folder is not set, use default one
        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }
    }

    public function getConfigFolder() {
        return $this->_config->getConfigFolder();
    }

    public function setConfigFolder($path) {
        $this->_config->setConfigFolder($path);
    }

    public function run(){
        //if config folder is not set, use default one
        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }
    }

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance =  new App();
        }

        return self::$instance;
    }

}