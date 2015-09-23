<?php

namespace  OnlineShop\models\viewModels;

use MVCFramework\BaseViewModel;

class HomeViewModel extends BaseViewModel
{

    public function __construct(){

    }

    public function render() {
        $view = "<h1>Welcome to Online Shop System</h1>";

        echo $view;
    }
}