<?php

namespace OnlineShop\Controllers;

use MVCFramework\BaseController;
use MVCFramework\DbAdapter;
use OnlineShop\models\Repositories\CategoriesRepository;
use OnlineShop\models\viewModels\CategoryViewModel;
use OnlineShop\Models\ViewModels\HomeViewModel;

/**
 * @Authorize
 */
class HomeController extends BaseController
{
    private $_repo = null;

    public function __construct(){
        parent::__construct();
        $this->_repo = new CategoriesRepository(new DbAdapter());
    }

    public function onInit(){

    }

    public function index() {
        $homeView = new HomeViewModel();
        $homeView->render();
        $categories = $this->_repo->getAll();
        foreach($categories as $category){
            $view = new CategoryViewModel($category);
            $view->render();
        }
    }
}