<?php

namespace OnlineShop\models;


class User
{
    private $_id = null;
    private $_username = null;
    private $_password = null;
    private $_email = null;
    private $_role = null;
    private $_cash = null;

    public function __construct($id, $username, $password, $email, $role, $cash){
        $this->setId($id);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setEmail($email);
        $this->setRole($role);
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

    public function getRole(){
        return $this->_role;
    }
    public function setRole($value){
        $this->_role = $value;
    }

    public function getCash(){
        return $this->_cash;
    }
    public function setCash($value){
        $this->_cash = $value;
    }
}