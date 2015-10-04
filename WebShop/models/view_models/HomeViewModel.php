<?php

namespace  WebShop\models\view_models;

use MVCFramework\BaseViewModel;

class HomeViewModel extends BaseViewModel
{
    public $products = null;

    public function __construct($recentProducts){
        $this->products = $recentProducts;
    }

    public function render() {
        include_once("../views/home/recent-products.php");
    }
}