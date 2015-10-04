<?php

namespace WebShop\models;

class Product
{
    private $_id = null;
    private $_name = null;
    private $_description = null;
    private $_price = null;
    private $_categoryId = null;
    private $_quantity = null;
    private $_dateListed = null;
    private $_isDeleted = null;

    public function __construct($id, $name, $price, $categoryId, $quantity, $dateListed, $isDeleted, $description = null){
        $this->setId($id);
        $this->setName($name);
        $this->setPrice($price);
        $this->setCategoryId($categoryId);
        $this->setQuantity($quantity);
        $this->setDateListed($dateListed);
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

    public function getPrice(){
        return $this->_price;
    }
    public function setPrice($value){
        $this->_price = $value;
    }

    public function getDescription(){
        return $this->_description;
    }
    public function setDescription($value){
        $this->_description = $value;
    }

    public function getCategoryId(){
        return $this->_categoryId;
    }
    public function setCategoryId($value){
        $this->_categoryId = $value;
    }

    public function getQuantity(){
        return $this->_quantity;
    }
    public function setQuantity($value){
        $this->_quantity = $value;
    }

    public function getDateListed(){
        return $this->_dateListed;
    }
    public function setDateListed($value){
        $this->_dateListed = $value;
    }

    public function getIsDeleted(){
        return $this->_isDeleted;
    }
    public function setIsDeleted($value){
        $this->_isDeleted = $value;
    }
}