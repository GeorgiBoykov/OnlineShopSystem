<?php
/**
 * Created by PhpStorm.
 * User: Georgi
 * Date: 02-Oct-15
 * Time: 10:35 PM
 */

namespace MVCFramework\ViewHelpers;


class RadioButton
{
    private $openTag = '<input type="radio"';
    private $attributes = array();
    private $label = '';

    private function __construct(){

    }

    public static function create(){
        return new self();
    }

    public function addAttribute($attrName, $attrValue){
        $this->attributes[$attrName] = $attrValue;
        return $this;
    }
    public function setLabel($label){
        $this->label= $label;
        return $this;
    }

    public function render(){
        $output = $this->openTag;
        foreach($this->attributes as $key => $value){
            $output .= " $key=$value";
        }
        $output.= " />". $this->label . '<br>';

        echo $output;
    }
}