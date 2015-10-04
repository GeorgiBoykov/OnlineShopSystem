<?php

namespace MVCFramework\ViewHelpers;

class DropDown
{
    private $openTag = '<select';
    private $closeTag = '</select>';
    private $attributes = array();
    private $content = "";


    private function __construct(){

    }

    public static function create(){
        return new self();
    }

    public function addAttribute($attrName, $attrValue){
        $this->attributes[$attrName] = $attrValue;
        return $this;
    }

    public function setContent($items, $key, $value){
        foreach($items as $item){
            $itemKey = $item->$key();
            $itemValue = $item->$value();
            $this->content.= "<option value='$itemValue'>$itemKey</option>";
        }

        return $this;
    }

    public function render(){
        $output = $this->openTag;
        foreach($this->attributes as $key => $value){
            $output .= " $key=$value";
        }
        $output.= ">";
        $output.= $this->content;
        $output.=$this->closeTag;

        echo $output;
    }
}