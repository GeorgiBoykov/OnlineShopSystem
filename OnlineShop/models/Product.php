<?php

namespace OnlineShop\Models;

class Product
{
    private $_id = null;
    private $_name = null;
    private $_description = null;
    private $_price = null;
    private $_category = null;
    private $_quantity = null;
    private $_isDeleted = null;

    public function __construct($id, $name, $price, $category, $quantity, $isDeleted, $description = null){
        $this->setId($id);
        $this->setName($name);
        $this->setPrice($price);
        $this->setCategory($category);
        $this->setQuantity($quantity);
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

    public function getCategory(){
        return $this->_category;
    }
    public function setCategory($value){
        $this->_category = $value;
    }

    public function getQuantity(){
        return $this->_quantity;
    }
    public function setQuantity($value){
        $this->_quantity = $value;
    }

    public function getIsDeleted(){
        return $this->_isDeleted;
    }
    public function setIsDeleted($value){
        $this->_isDeleted = $value;
    }
}