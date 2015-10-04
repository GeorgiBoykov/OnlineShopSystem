<a href='/products/category/<?=$name?>' id='category-<?=$name?>' class='list-group-item'><?=$name?>
<?php if($_SESSION['role_id'] == "3"){
    echo "<span class='btn btn-danger btn-xs' id='remove-category' onclick='ajaxModule.removeCategory(\"$name\")'>Remove</span>";
} ?>
</a>
