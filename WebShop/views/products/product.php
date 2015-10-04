<div class='panel panel-default product-full' id='product-full-<?= $this->id ?>'>
    <div class='panel-heading'><h4><?= $this->name ?></h4></div>
    <div class='panel-body'>
        <p>Description: <?= $this->description ?></p>
        <p>Id: <?= $this->id ?></p>
        <p>Price: <?= $this->price ?></p>
        <p>Category: <?= $this->categoryId ?></p>
        <p>Quantity: <?= $this->quantity ?></p>
        <p>Date listed: <?= $this->dateListed ?></p>
    </div>
    <button onclick='ajaxModule.addToCart(<?= $this->id ?>)' id="add-to-cart"
            class='btn btn-primary btn-sm'>Add to cart</button>
    <?php
        if($_SESSION['role_id'] == '3'){
            echo "<button class='btn btn-danger btn-sm'
            onclick='ajaxModule.removeProduct($this->id)' id='remove-product'>Remove product</button>";
        }
        ?>
</div>