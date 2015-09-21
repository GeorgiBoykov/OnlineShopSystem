<?php

namespace Models;
class Category
{
    private $_name = null;
    private $_description = null;

    public function __construct($name, $description = null){
        $this->_name = $name;
        $this->_description = $description;
    }

    public function __get($field){
        return $this->$field;
    }

    public function __set($field, $value){
        $this->$field = $value;
    }
}