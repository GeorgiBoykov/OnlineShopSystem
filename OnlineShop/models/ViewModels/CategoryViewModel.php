<?php

namespace  OnlineShop\models\viewModels;

use OnlineShop\Models\Category;
use MVCFramework\BaseViewModel;

class CategoryViewModel extends BaseViewModel
{
    public $id;
    public $name;
    public $description;

    public function __construct(Category $category){
        $this->id = $category->getId();
        $this->name = $category->getName();
        $this->description = $category->getDescription();
    }

    public function render() {
        include("../views/categories/category.php");
    }
}