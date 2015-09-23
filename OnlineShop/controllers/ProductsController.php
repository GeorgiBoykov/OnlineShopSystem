<?php

namespace OnlineShop\Controllers;

use MVCFramework\BaseController;

class ProductsController extends BaseController
{
    public function index() {

    }

    /**
     * @param $param1
     * @param $param2
     * @Route("get")
     */
    public function getProducts($param1, $param2){
        var_dump($param1);
        var_dump($param2);
    }
}