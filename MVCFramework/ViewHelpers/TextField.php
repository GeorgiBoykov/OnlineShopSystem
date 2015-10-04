<?php

namespace MVCFramework\ViewHelpers;


class TextField
{
    private $openTag = '<input type="text"';
    private $attributes = array();

    private function __construct(){

    }

    public static function create(){
        return new self();
    }

    public function addAttribute($attrName, $attrValue){
        $this->attributes[$attrName] = $attrValue;
        return $this;
    }

    public function render(){
        $output = $this->openTag;
        foreach($this->attributes as $key => $value){
            $output .= " $key=$value";
        }
        $output.= " />";

        echo $output;
    }
}