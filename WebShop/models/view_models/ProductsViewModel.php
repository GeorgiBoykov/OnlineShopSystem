<?php

namespace WebShop\models\view_models;


use MVCFramework\BaseViewModel;

class ProductsViewModel extends BaseViewModel
{
    public $products = null;

    public function __construct($products){
        $this->products = $products;
    }

    public function render() {
        include("../views/products/products.php");
    }
}