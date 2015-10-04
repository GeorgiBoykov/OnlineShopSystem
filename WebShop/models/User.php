<?php

namespace WebShop\models;


class User
{
    private $_id = null;
    private $_username = null;
    private $_password = null;
    private $_email = null;
    private $_roleId = null;
    private $_cash = null;

    public function __construct($id, $username, $password, $email, $roleId, $cash){
        $this->setId($id);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setEmail($email);
        $this->setRoleId($roleId);
        $this->setCash($cash);
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

    public function getPassword(){
        return $this->_password;
    }
    public function setPassword($value){
        $this->_password = $value;
    }

    public function getEmail(){
        return $this->_email;
    }
    public function setEmail($value){
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