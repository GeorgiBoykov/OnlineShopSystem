<?php

namespace WebShop\models\repositories;


use MVCFramework\DbAdapter;
use WebShop\models\Purchase;
use WebShop\models\view_models\PurchaseViewModel;

class CartsRepository
{
    protected $db;

    public function __construct(DbAdapter $db)
    {
        $this->db = $db;
    }

    public function find($id) {
        $purchase =  $this->db->getEntityById('users_products', $id);

        return $purchase;
    }

    public function addToCart($userId, $productId, $date){
        $this->db->insertEntity('users_products', array('user_id' => $userId, 'product_id' => $productId, 'date' => $date));
    }

    public function removeFromCart($itemId){
        $this->db->deleteEntity('users_products', array('id' => $itemId));
    }

    public function removeAllItemsFromCart($userId){
        $this->db->deleteEntity('users_products', array('user_id' => $userId));
    }

    public function getPurchases($userId, $limit = null){
        $sql = "SELECT c.id, u.username, p.name, p.price, c.date FROM users_products c
                JOIN products p ON p.Id = c.product_id
                JOIN users u ON u.id = c.user_id
                WHERE c.user_id = ?";

        if(!is_null($limit)){
            $sql .= " LIMIT $limit";
        }

        $cartItems = $this->db->query($sql, array($userId));
        $purchases = array();
        foreach($cartItems as $cartItem) {
            $purchase = new Purchase(
                $cartItem['id'],
                $cartItem['username'],
                $cartItem['name'],
                $cartItem['price'],
                $cartItem['date']
            );
            $purchaseView = new PurchaseViewModel($purchase);
            array_push($purchases, $purchaseView);
        }
        return $purchases;
    }

    public function getProductsInCart($userId, $limit = null){
        $products = array();
        $cartData = $this->db->getEntitiesByCriteria('users_products', array('user_id'=>$userId),null,'asc', $limit);

        if(is_null($cartData)){
            throw new \Exception('No such cart');
        }

        foreach($cartData as $data){
            array_push($products, $data['product_id']);
        }

        return $products;
    }

    public function getSumOfProductsInCart($userId){
        $sql = "SELECT
                     CASE WHEN SUM(p.price) is null THEN 0
                     ELSE SUM(p.price) END as sum
                FROM users_products up
                JOIN products p on p.id = up.product_id
                WHERE up.user_id = ?";

        $result = $this->db->query($sql, array($userId));

        return $result;
    }

    public function isAnyProductInCartWithNoQuantity($userId){
        $sql = "SELECT p.quantity FROM users_products up
                JOIN products p ON up.product_id = p.id
                WHERE up.user_id = ? AND p.quantity <= 0";

        $result = $this->db->query($sql, array($userId));
        return count($result) > 0;
    }
}