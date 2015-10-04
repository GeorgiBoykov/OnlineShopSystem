<div class="products">
    <?php foreach($this->products as $product){
            if((int)$product->getQuantity() > 0 && $product->getIsDeleted() === "0" ){
                $name = $product->getName();
                $id = $product->getId();
                $price = $product->getPrice();
                $description = $product->getDescription();
                echo "<div class='panel panel-default' id='product'>
                       <div class='panel-heading'><h4>$name</h4></div>
                        <div class='panel-body'>
                            <p>Description: $description</p>
                            <p>Price: $price</p>
                        </div>
                        <button onclick='ajaxModule.addToCart($id)' id='add-to-cart-$id' class='btn btn-primary btn-sm'>Add to cart</button>
                        <a href='/products/view/$id' class='btn btn-primary btn-sm'>Show more</a>
                  </div>";
            };
        }
    ?>
</div>