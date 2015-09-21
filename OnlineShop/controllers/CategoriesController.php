<?php

namespace Controllers;
use MVCFramework\BaseController;
use MVCFramework\DbAdapter;

class CategoriesController extends BaseController
{
    private $_db = null;

    public function __construct($controllerName, $actionName){
        parent::__construct($controllerName, $actionName);
        $this->_db = new DbAdapter();
    }

    public function index() {
        $this->categories = $this->_db->getAllEntities('training_centers');
    }

    public function create(){

    }
}