<div class="products">
    <h4>Newest products</h4>
    <?php foreach($this->products as $product){
            if((int)$product->getQuantity() > 0 && $product->getIsDeleted() === "0"){
                $id = $product->getId();
                $name = $product->getName();
                $price = $product->getPrice();
                echo "<a href='/products/view/$id'><div class='panel panel-default' id='recent-product'>
                            <div class='panel-body'>
                                <p><h4>$name</h4></p>
                                <p>Price: $price</p>
                            </div>
                      </div></a>";
            };
        }
    ?>
</div>