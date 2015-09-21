<?php

namespace MVCFramework;

final class Loader
{
    private static $namespaces = array();

    protected function __construct(){

    }

    public static function registerAutoLoad(){
        spl_autoload_register(array("\\MVCFramework\\Loader", "autoload"));
    }
    public static function autoLoad($class){
        self::includeClass($class);
    }

    public static function includeClass($class){
        foreach(self::$namespaces as $k => $v){
            if(strpos($class, $k) === 0){
                $file = str_replace('\\', DIRECTORY_SEPARATOR, $class);
                $file = substr_replace($file, $v, 0, strlen($k)).'.php';
                $file = realpath($file);
                if($file && is_readable($file)){
                    include $file;
                } else {
                    throw new \Exception('File cannot be included: '. $file);
                }
            }
        }
    }

    public static function registerNamespace($namespace, $path){
        $namespace = trim($namespace);

        if(strlen($namespace) > 0){
            if(!$path){
                throw new \Exception('Invalid path');
            }
            $_path = realpath($path);

            if($_path && is_dir($_path) && is_readable($_path)){
                self::$namespaces[$namespace.'\\'] = $_path . DIRECTORY_SEPARATOR;
            } else {
                throw new \Exception('Namespace directory read error: '.$path);
            }
        } else {
            throw new \Exception('Invalid namespace: ' . $namespace);
        }
    }
}