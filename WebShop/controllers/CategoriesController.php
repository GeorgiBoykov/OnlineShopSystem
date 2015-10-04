<?php

namespace WebShop\Controllers;

use MVCFramework\BaseController;
use MVCFramework\DbAdapter;
use WebShop\models\binding_models\CategoryBindingModel;
use WebShop\models\repositories\CategoriesRepository;
use WebShop\models\repositories\ProductsRepository;
use WebShop\models\view_models\CategoryViewModel;

/**
 * @Authorize
 */
class CategoriesController extends BaseController
{
    private $_categoriesRepo = null;

    public function __construct(){
        parent::__construct();
        $this->_categoriesRepo = new CategoriesRepository(DbAdapter::getInstance());
     }

    public function index() {
        $categories = $this->_categoriesRepo->getAllNotDeleted();
        foreach($categories as $category){
            $view = new CategoryViewModel($category);
            $view->render();
        }
    }

    /**
     * @Route("create")
     * @param @params
     */
    public function createCategory(CategoryBindingModel $category){

        if($_SESSION['role_id'] !== '3'){
            http_response_code(400);
            ob_end_clean();
            echo "You are not authenticated to add this category";
            die;
        }

        if(!$category->modelState()->isValid()){
            http_response_code(400);
            ob_end_clean();
            var_dump($category->modelState()->get());
            die;
        }

        $name = $category->getName();
        $oldCategory = $this->_categoriesRepo->findByName($name);

        if(!is_null($oldCategory)){
            http_response_code(400);
            ob_end_clean();
            echo "Category: $name already exists";
            die;
        }

        $this->_categoriesRepo->create($category);
    }

    /**
     * @Route("remove")
     * @param @params
     */
    public function removeCategory($name){
        if($_SESSION['role_id'] !== '3'){
            http_response_code(400);
            ob_end_clean();
            echo "You are not authenticated to delete this category";
            die;
        }

        $category = $this->_categoriesRepo->findByName($name);

        if($category == false){
            http_response_code(400);
            ob_end_clean();
            echo "Category with name $name does not exist";
            die;
        }

        $this->_categoriesRepo->remove($name);
    }

}