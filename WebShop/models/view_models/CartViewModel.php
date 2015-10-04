<?php

namespace WebShop\models\view_models;


use MVCFramework\BaseViewModel;

class CartViewModel extends BaseViewModel
{
    public $purchases = null;

    public function __construct($purchases){
        $this->purchases = $purchases;
    }

    public function render(){
        include_once("../views/cart/cart.php");
    }
}