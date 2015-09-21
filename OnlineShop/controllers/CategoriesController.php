<?php

namespace Controllers;
use Models\Category;
use Models\Product;
use MVCFramework\Controllers\BaseController;
use MVCFramework\DbAdapter;
use Views\Categories\CategoryView;

class CategoriesController extends BaseController
{
    private $_db = null;

    public function __construct($controllerName, $actionName){
        parent::__construct($controllerName, $actionName);
        $this->_db = new DbAdapter();
    }

    public function index() {
        $categoryData = $this->_db->getEntity('categories', array('id' => 1));
        $category = new Category($categoryData['name'], $categoryData['description']);
        $view = new CategoryView($category);
        $view->render();
    }

    public function create(){

    }
}