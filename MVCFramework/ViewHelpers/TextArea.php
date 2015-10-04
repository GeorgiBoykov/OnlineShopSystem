<?php
/**
 * Created by PhpStorm.
 * User: Georgi
 * Date: 02-Oct-15
 * Time: 10:29 PM
 */

namespace MVCFramework\ViewHelpers;


class TextArea
{
    private $openTag = '<textarea';
    private $closeTag = "</textarea>";
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
        $output .=' >';
        $output.= $this->closeTag;

        echo $output;
    }
}