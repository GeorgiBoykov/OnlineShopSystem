<?php

namespace OnlineShop\models;


class Role
{
    private $_id = null;
    private $_name = null;

    public function __construct($id, $name){
        $this->setId($id);
        $this->setName($name);
    }

    public function getId(){
        return $this->_id;
    }
    public function setId($value){
        $this->_id = $value;
    }

    public function getName(){
        return $this->_name;
    }
    public function setName($value){
        $this->_name = $value;
    }

}