<?php

namespace MVCFramework\ViewHelpers;

class Form
{
    private $openTag = '<form';
    private $closeTag = '</form>';
    private $attributes = array();

    private function __construct(){

    }

    public static function create(){
        return new self();
    }

    public function setMethodType($methodType){
        $this->attributes['method'] = $methodType;
        return $this;
    }

    public function addAttribute($attrName, $attrValue){
        $this->attributes[$attrName] = $attrValue;
        return $this;
    }

    public function render() {
        $output = $this->openTag;
        foreach ($this->attributes as $key => $value) {
            $output .= " $key=$value";
        }
        $output.=$this->closeTag;

        echo $output;
    }
}