<?php

namespace WebShop\models\binding_models;


use MVCFramework\BaseBindingModel;

class LoginBindingModel extends BaseBindingModel
{
    private $_username;
    private $_password;

    public function __construct($bindingData){
        $this->setUsername($bindingData['username']);
        $this->setPassword($bindingData['password']);
    }

    public function getUsername(){
        return $this->_username;
    }
    public function setUsername($value){
        if(is_null($value) || $value === ""){
            $this->addToModelState('Username cannot be null');
        }
        $this->_username = $value;
    }

    public function getPassword(){
        return $this->_password;
    }
    public function setPassword($value){
        if(is_null($value) || $value === ""){
            $this->addToModelState('Password cannot be null');
        }
        $this->_password = $value;
    }
}