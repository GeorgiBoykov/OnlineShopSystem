<?php

namespace OnlineShop\models\viewModels;

use MVCFramework\BaseViewModel;

class AuthenticationViewModel extends BaseViewModel
{
    public function render(){
        include_once("../views/authentication/authentication.php");
    }
}