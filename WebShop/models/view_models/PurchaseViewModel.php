<?php

namespace WebShop\models\view_models;


use WebShop\models\Purchase;

class PurchaseViewModel
{
    public $id = null;
    public $username = null;
    public $productName = null;
    public $price = null;
    public $date = null;

    public function __construct(Purchase $purchase){
        $this->id = $purchase->getId();
        $this->username = $purchase->getUsername();
        $this->productName = $purchase->getProductName();
        $this->price = $purchase->getPrice();
        $this->date = $purchase->getDate();
    }
}