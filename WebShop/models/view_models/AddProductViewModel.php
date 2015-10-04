<?php

namespace WebShop\models\view_models;


use MVCFramework\BaseViewModel;
use MVCFramework\ViewHelpers\DropDown;

class AddProductViewModel extends BaseViewModel
{
    public $categories = null;

    public function __construct($categories){
        $this->categories = $categories;
    }

    public function render() {
        include_once("../views/products/add-product.php");
    }
}