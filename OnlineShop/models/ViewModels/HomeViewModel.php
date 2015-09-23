<?php

namespace  OnlineShop\models\viewModels;

use MVCFramework\BaseViewModel;

class HomeViewModel extends BaseViewModel
{

    public function __construct(){
    }

    public function render() {
        include_once("../views/home/home.php");
    }
}