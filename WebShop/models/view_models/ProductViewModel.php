<?php

namespace WebShop\models\view_models;


use MVCFramework\BaseViewModel;
use WebShop\Models\Product;

class ProductViewModel extends BaseViewModel
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $categoryId;
    public $quantity;
    public $dateListed;

    public function __construct(Product $product){
        $this->id = $product->getId();
        $this->name = $product->getName();
        $this->description = $product->getDescription();
        $this->price = $product->getPrice();
        $this->categoryId = $product->getCategoryId();
        $this->quantity = $product->getQuantity();
        $this->dateListed = $product->getDateListed();
    }

    public function render() {
        include("../views/products/product.php");
    }
}