<?php
/**
 * Created by PhpStorm.
 * User: Georgi
 * Date: 02-Oct-15
 * Time: 10:50 PM
 */

namespace MVCFramework\ViewHelpers;


class AjaxForm
{
    private $formOpenTag = '<div';
    private $formCloseTag = '</div>';
    private $formAttributes = array();
    private $buttonOpenTag = '<button';
    private $buttonAttributes = array();


    private function __construct(){

    }

    public static function create(){
        return new self();
    }

    public function addFormAttribute($attrName, $attrValue){
        $this->formAttributes[$attrName] = $attrValue;
        return $this;
    }
    public function addButtonAttribute($attrName, $attrValue){
        $this->buttonAttributes[$attrName] = $attrValue;
        return $this;
    }

    public function render() {
        $form = $this->formOpenTag;
        $button = $this->buttonOpenTag;
        foreach ($this->formAttributes as $key => $value) {
            $form .= " $key=$value";
        }
        $form.= '>';
        foreach ($this->buttonAttributes as $key => $value){
            $button .= " $key=$value";
        }
        $button.= '></button>';

        $form.= $button;
        $form.=$this->formCloseTag;

        echo $form;
    }
}