<?php

namespace WebShop\models\binding_models;


use MVCFramework\BaseBindingModel;

class ProductBindingModel extends BaseBindingModel
{
    private $_name = null;
    private $_description = null;
    private $_price = null;
    private $_categoryId = null;
    private $_quantity = null;
    private $_dateListed = null;
    private $_isDeleted = null;

    public function __construct($bindingData){
        $this->setName($bindingData['name']);
        $this->setPrice($bindingData['price']);
        $this->setQuantity($bindingData['quantity']);
        $this->setCategoryId($bindingData['category_id']);
        $this->setDescription($bindingData['description']);
        $this->setDateListed(date("Y-m-d H:i:s"));
        $this->setIsDeleted(false);
    }


    public function getName(){
        return $this->_name;
    }
    public function setName($value){
        if(is_null($value) || $value === ""){
            $this->addToModelState('Name cannot be null');
        }
        if(strlen($value)< 2){
            $this->addToModelState('Name must be at least 2 characters');
        }
        $this->_name = $value;
    }
    public function getPrice(){
        return $this->_price;
    }
    public function setPrice($value){
        if(is_null($value) || $value === ""){
            $this->addToModelState('Price cannot be null');
        }
        if(!is_numeric($value)){
            $this->addToModelState('Price must be numeric');
        }
        if(floatval($value)< 0){
            $this->addToModelState('Price must be more than zero');
        }
        $this->_price = $value;
    }

    public function getCategoryId(){
        return $this->_categoryId;
    }
    public function setCategoryId($value){
        if(is_null($value) || $value === ""){
            $this->addToModelState('Category cannot be null');
        }
        $this->_categoryId = $value;
    }

    public function getQuantity(){
        return $this->_quantity;
    }
    public function setQuantity($value){
        if(is_null($value) || $value === ""){
            $this->addToModelState('Quantity cannot be null');
        }
        if(!is_numeric($value)){
            $this->addToModelState('Quantity must be numeric');
        }
        if((float)$value < 0){
            $this->addToModelState('Quantity must be more than zero');
        }
        $this->_quantity = $value;
    }
    public function getDescription(){
        return $this->_description;
    }
    public function setDescription($value){
        $this->_description = $value;
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