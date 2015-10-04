<div id="left-aside">
    <div id="categories">
    <div class="list-group-item active">Categories</div>
    <?php
        foreach($this->categories as $category){
            $name = $category->getName();
            if($category->getIsDeleted() === "0"){
                include('../views/categories/category.php');
            }
        }
    ?>
    </div>
    <?php
    if($_SESSION['role_id'] == "3"){
        include_once('../views/categories/add-category.php');
    }
    ?>
</div>
