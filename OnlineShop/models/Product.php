<?php

namespace Models;

class Product
{
    private $_name = null;
    private $_description = null;
    private $_price = null;

    public function __construct($name, $price, $description = null){
        $this->_name = $name;
        $this->_price = $price;
        $this->_description = $description;
    }

    public function __get($field){
        return $this->$field;
    }

    public function __set($field, $value){
        $this->$field = $value;
    }
}