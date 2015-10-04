<?php

namespace WebShop\models\binding_models;


use MVCFramework\BaseBindingModel;

class CategoryBindingModel extends BaseBindingModel
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
        if(is_null($value) || $value === ""){
            $this->addToModelState('Name cannot be null');
        }
        if(strlen($value)< 2){
            $this->addToModelState('Name must be at least 2 characters');
        }
        $this->_name = $value;
    }

    public function getDescription(){
        return $this->_description;
    }
    public function setDescription($value){
        $this->_description = $value;
    }
}