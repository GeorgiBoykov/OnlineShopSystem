<?php

namespace OnlineShop\models;


class Cart
{
    private $_id = null;
    private $_userId = null;
    private $_productId = null;

    public function __construct($id, $userId, $productId){
        $this->setId($id);
        $this->setUserId($userId);
        $this->setProductId($productId);
    }

    public function getId(){
        return $this->_id;
    }
    public function setId($value){
        $this->_id = $value;
    }

    public function getUserId(){
        return $this->_userId;
    }
    public function setUserId($value){
        $this->_userId = $value;
    }

    public function getProductId(){
        return $this->_productId;
    }
    public function setProductId($value){
        $this->_productId = $value;
    }

}