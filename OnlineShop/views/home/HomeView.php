<?php

namespace OnlineShop\Views\Home;

use MVCFramework\Views\BaseView;

class HomeView extends BaseView
{

    public function __construct(){

    }

    public function render() {
        $view = "<h1>Welcome to Online Shop System</h1>";

        echo $view;
    }
}