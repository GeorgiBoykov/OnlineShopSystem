<?php

namespace MVCFramework;


abstract class BaseBindingModel
{
    protected $modelState = array();

    public function modelState(){
        return $this;
    }

    public function get(){
        return $this->modelState;
    }

    public function isValid(){
        return count($this->modelState) == 0;
    }

    protected function addToModelState($value){
        array_push($this->modelState, $value);
    }
}