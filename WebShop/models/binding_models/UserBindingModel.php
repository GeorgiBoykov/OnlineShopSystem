<?php

namespace WebShop\models\binding_models;

use MVCFramework\BaseBindingModel;

class UserBindingModel extends BaseBindingModel
{
    const INITIAL_CASH = 100;
    const INITIAL_ROLE_ID = 1;
    private $_username;
    private $_password;
    private $_email;
    private $_roleId = null;
    private $_cash = null;

    public function __construct($bindingData){
        $this->setUsername($bindingData['username']);
        $this->setPassword($bindingData['password']);
        $this->setEmail($bindingData['email']);
        $this->setCash(self::INITIAL_CASH);
        $this->setRoleId(self::INITIAL_ROLE_ID);
    }


    public function getUsername(){
        return $this->_username;
    }
    public function setUsername($value){
        if(is_null($value) || $value === ""){
            $this->addToModelState('Username cannot be null');
        }

        if(strlen($value)< 3){
            $this->addToModelState('Username must be at least 3 characters');
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
        if(strlen($value)< 3){
            $this->addToModelState('Password must be at least 3 characters');
        }

        $this->_password = $value;
    }

    public function getEmail(){
        return $this->_email;
    }
    public function setEmail($value){
        if(is_null($value) || $value === ""){
            $this->addToModelState('Email cannot be null');
        }
        if(strpos($value, '@') === false){
            $this->addToModelState('Email must contain at least @');
        }
        $this->_email = $value;
    }

    public function getRoleId(){
        return $this->_roleId;
    }
    public function setRoleId($value){
        $this->_roleId = $value;
    }

    public function getCash(){
        return $this->_cash;
    }
    public function setCash($value){
        $this->_cash = $value;
    }
}