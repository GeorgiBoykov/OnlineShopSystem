<?php

namespace Views\Categories;

use Models\Category;
use MVCFramework\Views\BaseView;

class CategoryView extends BaseView
{
    private $name;
    private $description;

    public function __construct($category){
        if($category instanceof Category){
            $this->name = $category->_name;
            $this->description = $category->_description;
        } else{
            throw new \Exception("Parameters giver are not of type 'Category'");
        }
    }

    public function render() {
        $view =
        '<div class="category">'.
            "<h1>$this->name</h1>".
            "<h2>$this->description</h2>
        </div>";

        echo $view;
    }
}