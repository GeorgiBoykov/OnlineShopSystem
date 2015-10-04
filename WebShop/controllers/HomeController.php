<?php

namespace WebShop\Controllers;

use MVCFramework\BaseController;
use MVCFramework\DbAdapter;
use WebShop\models\repositories\CategoriesRepository;
use WebShop\models\repositories\ProductsRepository;
use WebShop\models\view_models\AsideViewModel;
use WebShop\models\view_models\HomeViewModel;

/**
 * @Authorize
 */
class HomeController extends BaseController
{
    private $_categoriesRepo = null;
    private $_productsRepo = null;

    public function __construct(){
        parent::__construct();
        $this->_categoriesRepo = new CategoriesRepository(DbAdapter::getInstance());
        $this->_productsRepo = new ProductsRepository(DbAdapter::getInstance());
    }

    public function index() {
        $categories = $this->_categoriesRepo->getAllNotDeleted();
        $asideView = $this->escape(new AsideViewModel($categories));
        $asideView->render();

        $newestProducts = $this->_productsRepo->getNewestProducts(10);
        $homeView = $this->escape(new HomeViewModel($newestProducts));
        $homeView->render();
    }
}