<?php

namespace OnlineShop\areas\forum\controllers;


use MVCFramework\BaseController;

class TopicsController extends BaseController
{
    public function index(){
        echo "<h1>Forum TopicsController</h1>";
    }

    /**
     * @param $id
     * @Route("get")
     */
    public function getall(){
        echo "<h1>GET ALL TOPICS ACTION</h1>";
    }
}