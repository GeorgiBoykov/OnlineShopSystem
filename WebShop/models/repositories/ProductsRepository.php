<?php

namespace WebShop\models\repositories;


use MVCFramework\DbAdapter;
use WebShop\models\binding_models\ProductBindingModel;
use WebShop\models\Product;

class ProductsRepository
{
    protected $db;

    public function __construct(DbAdapter $db)
    {
        $this->db = $db;
    }


    public function find($id)
    {
        // Find a record with the id = $id
        // from the 'products' table
        // and return it as a Product object
        $productData = $this->db->getEntityById('products', $id);
        if($productData == null){
            return null;
        }

        $product = new Product(
            $productData['id'],
            $productData['name'],
            $productData['price'],
            $productData['category_id'],
            $productData['quantity'],
            $productData['date_listed'],
            $productData['is_deleted'],
            $productData['description']
        );
        return $product;
    }

    public function findByName($name){
        // Find a record with the name = $name
        // from the 'products' table
        // and return it as a Product object
        $data = $this->db->getEntitiesByCriteria('products', array('name'=> $name));
        $productData = $data[0];
        if($productData == null){
            return null;
        }

        $product = new Product(
            $productData['id'],
            $productData['name'],
            $productData['price'],
            $productData['category_id'],
            $productData['quantity'],
            $productData['date_listed'],
            $productData['is_deleted'],
            $productData['description']
        );


        return $product;
    }

    public function getProductProperty($id, $property){
        $property = $this->db->getEntityPropertyById('products', $id, $property);

        if(is_null($property)){
            throw new \Exception('No such property');
        }

        return $property;
    }

    public function getNewestProducts($limit){
        $products = array();
        $productsData = $this->db->getAllEntities('products', $limit, 'date_listed', 'desc');
        foreach($productsData as $productData){
            $product = new Product(
                $productData['id'],
                $productData['name'],
                $productData['price'],
                $productData['category_id'],
                $productData['quantity'],
                $productData['date_listed'],
                $productData['is_deleted'],
                $productData['description']
            );
            array_push($products, $product);
        }
        return $products;
    }

    public function getAllByCategory($categoryId){
        // Find All products
        $products = array();
        $sql = 'SELECT * FROM products WHERE category_id = ? AND is_deleted = 0';
        $productsData = $this->db->query($sql, array($categoryId));

        foreach($productsData as $productData){
            $product = new Product(
                $productData['id'],
                $productData['name'],
                $productData['price'],
                $productData['category_id'],
                $productData['quantity'],
                $productData['date_listed'],
                $productData['is_deleted'],
                $productData['description']
            );
            array_push($products, $product);
        }
        return $products;
    }

    public function searchProducts($searchTerm){
        // Find All products
        $products = array();
        $productsData = $this->db->getEntitiesByCriteria('products', array('name' => $searchTerm));

        foreach($productsData as $productData){
            $product = new Product(
                $productData['id'],
                $productData['name'],
                $productData['price'],
                $productData['category_id'],
                $productData['quantity'],
                $productData['date_listed'],
                $productData['is_deleted'],
                $productData['description']
            );
            array_push($products, $product);
        }
        return $products;
    }

    public function create(ProductBindingModel $product)
    {
        // Insert or update the $product
        // in the 'products' table
        $this->db->insertEntity('products', array(
            'name' => $product->getName(),
            'quantity' => $product->getQuantity(),
            'category_id' => $product->getCategoryId(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'date_listed' => $product->getDateListed(),
            'is_deleted' => $product->getIsDeleted(),
        ));
    }

    public function updateProduct($updateData, $whereProductKeyValue)
    {
        $this->db->updateEntity('products', $updateData, $whereProductKeyValue);
    }

    public function changeName($id, $newName)
    {
        $this->db->updateEntityProperty('products', array('name' => $newName), array('id' => $id));
    }

    public function changeQuantity($id, $newQuantity)
    {
        $this->db->updateEntityProperty('products', array('quantity' => $newQuantity), array('id' => $id));
    }
    public function decrementQuantitiesByOneForProductsInUserCart($userId)
    {
        $sql = "UPDATE products p
                JOIN users_products up ON up.product_id = p.id
                SET quantity = quantity - 1
                WHERE up.user_id = ?";

        $this->db->query($sql, array($userId));
    }

    public function changeDescription($name, $newDescription)
    {
        $this->db->updateEntityProperty('products', array('description' => $newDescription), array('name' => $name));
    }

    public function remove($id)
    {
        $this->db->updateEntityProperty('products',array('is_deleted' => true), array('id' => $id));
    }
}