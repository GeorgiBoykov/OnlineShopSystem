<?php
namespace WebShop\models\view_models;

use MVCFramework\BaseViewModel;

class AsideViewModel extends BaseViewModel
{

    public $categories = null;

    public function __construct($categories){
        $this->categories = $categories;
    }

    public function render(){
        include_once("../views/layouts/left-aside.php");
    }
}