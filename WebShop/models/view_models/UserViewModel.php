<?php

namespace WebShop\models\view_models;


use MVCFramework\BaseViewModel;
use WebShop\models\User;

class UserViewModel extends BaseViewModel
{
    public $id = null;
    public $username = null;
    public $email = null;
    public $roleId = null;
    public $cash = null;

    public function __construct(User $user){
        $this->id = $user->getId();
        $this->username = $user->getUsername();
        $this->email = $user->getEmail();
        $this->role = $user->getRoleId();
        $this->cash = $user->getCash();
    }

    public function render(){
        include_once("../views/users/user.php");
    }
}