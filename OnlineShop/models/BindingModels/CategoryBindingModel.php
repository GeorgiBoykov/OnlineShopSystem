<?php

namespace OnlineShop\models\BindingModels;


class CategoryBindingModel
{
    private $_name;
    private $_description;

    public function __construct($bindingData){
        $this->setName($bindingData['name']);
        $this->setDescription($bindingData['description']);
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
}