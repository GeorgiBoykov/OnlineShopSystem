<?php

namespace WebShop\Controllers;

use MVCFramework\BaseController;
use MVCFramework\DbAdapter;
use WebShop\models\binding_models\ProductBindingModel;
use WebShop\models\repositories\CartsRepository;
use WebShop\models\repositories\CategoriesRepository;
use WebShop\models\repositories\ProductsRepository;
use WebShop\models\view_models\AddProductViewModel;
use WebShop\models\view_models\AsideViewModel;
use WebShop\models\view_models\ProductsViewModel;
use WebShop\models\view_models\ProductViewModel;

/**
 * @Authorize
 */
class ProductsController extends BaseController
{
    private $_productsRepo = null;
    private $_categoriesRepo = null;
    private $_cartsRepo = null;

    public function __construct(){
        parent::__construct();
        $this->_productsRepo = new ProductsRepository(DbAdapter::getInstance());
        $this->_categoriesRepo = new CategoriesRepository(DbAdapter::getInstance());
        $this->_cartsRepo = new CartsRepository(DbAdapter::getInstance());
    }

    public function index() {
        $newestProducts = $this->_productsRepo->getNewestProducts(10);
        $categories = $this->_categoriesRepo->getAllNotDeleted();
        $view = $this->escape(new ProductsViewModel($newestProducts, $categories, 'Newest products'));
        $view->render();
    }

    /**
     * @Route("add")
     */
    public function openNewProductForm(){
        $categories = $this->_categoriesRepo->getAllNotDeleted();
        $asideView = $this->escape(new AsideViewModel($categories));
        $asideView->render();

        $view = $this->escape(new AddProductViewModel($categories));
        $view->render();
    }

    /**
     * @param ProductBindingModel $product
     * @throws \Exception
     * @Route("list")
     */
    public function listNewProduct(ProductBindingModel $product){

        if($_POST['csrf'] !== $_SESSION["token"]){
            http_response_code(400);
            ob_end_clean();
            echo "CSRF not matching error";
            die;
        }

        if(!$product->modelState()->isValid()){
            http_response_code(400);
            ob_end_clean();
            var_dump($product->modelState()->get());
            die;
        }
        $this->_productsRepo->create($product);
    }

    /**
     * @param $categoryName
     * @Route("category")
     */
    public function getCategoryProducts($categoryName){
        $category = $this->_categoriesRepo->findByName($categoryName);
        if(is_null($category) || $category->getIsDeleted() === "1"){
            http_response_code(400);
            echo "<h2>Category $categoryName does not exist</h2>";
            die;
        }
        $categories = $this->_categoriesRepo->getAllNotDeleted();
        $asideView = $this->escape(new AsideViewModel($categories));
        $asideView->render();

        $products = $this->_productsRepo->getAllByCategory($category->getId());
        $productsView = $this->escape(new ProductsViewModel($products)) ;
        $productsView->render();
    }

    /**
     * @param $productId
     * @Route("buy")
     */
    public function addProductToCart($productId){
        $product = $this->_productsRepo->find($productId);

        if(is_null($product)){
            http_response_code(400);
            ob_end_clean();
            echo "Product with id $productId does not exist";
            die;
        }

        if($product->getQuantity() <= 0){
            http_response_code(400);
            ob_end_clean();
            echo "Product with id $productId has no quantities left.";
            die;
        }

        $this->_cartsRepo->addToCart($_SESSION['user_id'], $productId, date("Y-m-d H:i:s"));
    }

    /**
     * @param $purchaseId
     * @Route("unbuy")
     */
    public function removePurchaseFromCart($purchaseId){
        $purchase = $this->_cartsRepo->find($purchaseId);

        if($purchase == false){
            http_response_code(400);
            ob_end_clean();
            echo "Purchase with id $purchaseId does not exist";
            die;
        }

        $this->_cartsRepo->removeFromCart($purchaseId);
    }

    /**
     * @param $productId
     * @throws \Exception
     * @Route("view")
     */
    public function viewProduct($productId){
        $categories = $this->_categoriesRepo->getAllNotDeleted();
        $asideView = $this->escape(new AsideViewModel($categories));
        $asideView->render();

        $product = $this->_productsRepo->find($productId);
        if(is_null($product) || $product->getIsDeleted() === "1"){
            http_response_code(400);
            echo "<h2>Product with id $productId does not exist</h2>";
            die;
        }
        $productView = $this->escape(new ProductViewModel($product));
        $productView->render();
    }

    /**
     * @internal param $searchTerm
     * @internal param $categoryName
     * @Route("search")
     */
    public function searchProduct(){
        $categories = $this->_categoriesRepo->getAllNotDeleted();
        $asideView = $this->escape(new AsideViewModel($categories));
        $asideView->render();

        if(!is_null($_GET['term']) && $_GET['term'] != '' ){
            $searchTerm = '%'.$_GET['term'].'%';
            $products = $this->_productsRepo->searchProducts($searchTerm);
            $productsView = $this->escape(new ProductsViewModel($products));
            $productsView->render();
        }
    }

    /**
     * @Route("remove")
     * @param @params
     */
    public function removeProduct($id){
        $product = $this->_productsRepo->find($id);
        $name = $product->getName();

        if($_SESSION['role_id'] !== '3'){
            http_response_code(400);
            ob_end_clean();
            echo "You are not authenticated to delete this product";
            die;
        }

        if($product == false){
            http_response_code(400);
            ob_end_clean();
            echo "Product with name $name does not exist";
            die;
        }

        $this->_productsRepo->remove($id);
    }
}