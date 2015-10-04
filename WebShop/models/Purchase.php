<?php

namespace WebShop\models;


class Purchase
{
    private $_id = null;
    private $_username = null;
    private $_productName = null;
    private $_price = null;
    private $_date = null;

    public function __construct($id, $username, $productName, $price, $date){
        $this->setId($id);
        $this->setUsername($username);
        $this->setProductName($productName);
        $this->setPrice($price);
        $this->setDate($date);
    }

    public function getId(){
        return $this->_id;
    }
    public function setId($value){
        $this->_id = $value;
    }

    public function getUsername(){
        return $this->_username;
    }
    public function setUsername($value){
        $this->_username = $value;
    }

    public function getProductName(){
        return $this->_productName;
    }
    public function setProductName($value){
        $this->_productName = $value;
    }
    public function getPrice(){
        return $this->_price;
    }
    public function setPrice($value){
        $this->_price = $value;
    }
    public function getDate(){
        return $this->_date;
    }
    public function setDate($value){
        $this->_date = $value;
    }
}