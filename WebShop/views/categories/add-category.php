<?php
    MVCFramework\ViewHelpers\TextField::create()
    ->addAttribute('class', 'form-control')
    ->addAttribute('id', 'new-category')
    ->addAttribute('placeholder', 'New_Category')
    ->render();
?>
<button id="add-category" onclick="ajaxModule.addCategory()" class="btn btn-primary btn-sm">Add</button>