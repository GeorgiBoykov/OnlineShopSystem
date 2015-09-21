<?php

namespace OnlineShop\Controllers;

use MVCFramework\Controllers\BaseController;
use OnlineShop\Views\Home\HomeView;

class HomeController extends BaseController
{
    public function index() {
        $view = new HomeView();
        $view->render();
    }
}