<?php

namespace OnlineShop\Controllers;

use MVCFramework\BaseController;
use MVCFramework\DbAdapter;
use OnlineShop\models\Repositories\CategoriesRepository;
use OnlineShop\models\viewModels\CategoryViewModel;

/**
 * @Route("categories")
 */
class CategoriesController extends BaseController
{
    private $_repo = null;

    public function __construct(){
        parent::__construct();
        $this->_repo = new CategoriesRepository(new DbAdapter());
    }

    public function index() {
        $categories = $this->_repo->getAll();
        foreach($categories as $category){
            $view = new CategoryViewModel($category);
            $view->render();
        }
    }

    /**
     * @Route("create")
     */
    public function createCategory($params){
        var_dump($params);
    }
}