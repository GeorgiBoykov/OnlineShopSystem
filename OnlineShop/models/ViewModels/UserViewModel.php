<?php
/**
 * Created by PhpStorm.
 * User: Georgi
 * Date: 22-Sep-15
 * Time: 11:43 PM
 */

namespace OnlineShop\models\ViewModels;


use MVCFramework\BaseViewModel;
use OnlineShop\models\User;

class UserViewModel extends BaseViewModel
{
    public $id = null;
    public $username = null;
    public $password = null;
    public $email = null;
    public $role = null;
    public $cash = null;

    public function __construct(User $user){
        $this->id = $user->getId();
        $this->username = $user-$this->getUsername();
        $this->password = $user->getPassword();
        $this->email = $user->getEmail();
        $this->role = $user->getRole();
        $this->cash = $user->getCash();
    }

    public function render(){

    }
}