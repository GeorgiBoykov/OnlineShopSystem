<?php

namespace WebShop\Models;

class Category
{
    private $_id = null;
    private $_name = null;
    private $_description = null;
    private $_isDeleted;

    public function __construct($id, $name, $isDeleted, $description = null){
        $this->setId($id);
        $this->setName($name);
        $this->setIsDeleted($isDeleted);
        $this->setDescription($description);
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

    public function getDescription(){
        return $this->_description;
    }
    public function setDescription($value){
        $this->_description = $value;
    }

    public function getIsDeleted(){
        return $this->_isDeleted;
    }
    public function setIsDeleted($value){
        $this->_isDeleted = $value;
    }

}