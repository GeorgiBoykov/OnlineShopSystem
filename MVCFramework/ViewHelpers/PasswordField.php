<?php

namespace MVCFramework\ViewHelpers;


class PasswordField
{
    private $openTag = '<input type="password"';
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

    public function render() {
        $output = $this->openTag;
        foreach ($this->attributes as $key => $value) {
            $output .= " $key=$value";
        }
        $output .= " />";

        echo $output;
    }
}