<?php

namespace WebShop\areas\forum\controllers;


use MVCFramework\BaseController;

class TopicsController extends BaseController
{
    public function index(){
        echo "<h1>Forum TopicsController</h1>";
    }

    /**
     * @param $param
     * @internal param $id
     * @Route("get")
     */
    public function getall($param){
        echo "<h1>GET ALL TOPICS ACTION</h1>";
        echo "<h2>You entered $param</h2>";
    }
}