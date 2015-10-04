<?php

namespace WebShop\Controllers;

use MVCFramework\BaseController;
use MVCFramework\DbAdapter;
use WebShop\models\repositories\CartsRepository;
use WebShop\models\repositories\CategoriesRepository;
use WebShop\models\repositories\ProductsRepository;
use WebShop\models\repositories\UsersRepository;
use WebShop\models\view_models\AsideViewModel;
use WebShop\models\view_models\CartViewModel;
use WebShop\models\view_models\UserViewModel;

/**
 * @Authorize
 */
class UsersController extends BaseController
{
    private $_productsRepo = null;
    private $_cartsRepo = null;
    private $_usersRepo = null;
    private $_categoriesRepo = null;

    public function __construct(){
        parent::__construct();
        $this->_productsRepo = new ProductsRepository(DbAdapter::getInstance());
        $this->_cartsRepo = new CartsRepository(DbAdapter::getInstance());
        $this->_usersRepo = new UsersRepository(DbAdapter::getInstance());
        $this->_categoriesRepo = new CategoriesRepository(DbAdapter::getInstance());
    }

    public function index() {

    }

    public function profile(){
        $categories = $this->_categoriesRepo->getAllNotDeleted();
        $asideView = $this->escape(new AsideViewModel($categories));
        $asideView->render();

        $user = $this->_usersRepo->find($_SESSION['user_id']);
        $userView = $this->escape(new UserViewModel($user));
        $userView->render();
    }

    /**
     * @Route('cart-items')
     */
    public function getCartPreview(){
        $purchases = $this->_cartsRepo->getPurchases($_SESSION['user_id'], 5);
        ob_end_clean();
        echo json_encode($this->escape($purchases));
        die;
    }

    /**
     * @throws \Exception
     * @Route("cart")
     */
    public function getCart(){
        $purchases = $this->_cartsRepo->getPurchases($_SESSION['user_id']);
        $cartView = $this->escape(new CartViewModel($purchases));
        $cartView->render();
    }

    public function checkout(){
        $userCash = floatval($this->_usersRepo->getUserProperty($_SESSION['user_id'], 'cash' )[0]);
        $productsSum = floatval($this->_cartsRepo->getSumOfProductsInCart($_SESSION['user_id'])[0][0]);

        if($this->_cartsRepo->isAnyProductInCartWithNoQuantity($_SESSION['user_id'])){
            http_response_code(400);
            ob_end_clean();
            echo 'There are products with no quantities left in shopping cart';
            die;
        }

        if($userCash < $productsSum){
            http_response_code(400);
            ob_end_clean();
            echo 'User cash cannot be less then products sum';
            die;
        }

        $this->_productsRepo->decrementQuantitiesByOneForProductsInUserCart($_SESSION['user_id']);

        $this->_usersRepo->deductCashForPurchasedProducts($_SESSION['user_id']);

        $this->_cartsRepo->removeAllItemsFromCart($_SESSION['user_id']);
    }
}