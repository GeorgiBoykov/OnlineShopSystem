<?php

namespace OnlineShop\Controllers;

use MVCFramework\BaseController;
use OnlineShop\Models\ViewModels\HomeViewModel;

class HomeController extends BaseController
{
    public function onInit(){
    }

    public function index() {
        session_start();
        $view = new HomeViewModel();
        $view->render();
    }
}