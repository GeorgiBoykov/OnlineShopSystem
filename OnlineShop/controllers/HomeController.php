<?php

namespace Controllers;
use MVCFramework\Controllers\BaseController;
use Views\Home\HomeView;

class HomeController extends BaseController
{
    public function index() {
        $view = new HomeView();
        $view->render();
    }
}