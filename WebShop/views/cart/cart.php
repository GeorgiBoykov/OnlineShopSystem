<h2>Shopping cart</h2>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Price</th>
        <th>Date bought</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
<?php
    $total = 0;
    foreach($this->purchases as $purchase){
    $id = $purchase->id;
    $username = $purchase->username;
    $product = $purchase->productName;
    $price = $purchase->price;
    $date = $purchase->date;
    $total += floatval($price);
    echo    "<tr id='row-$id'>
                  <td>$id</td>
                  <td>$product</td>
                  <td>$price</td>
                  <td>$date</td>
                  <td><button class='btn btn-primary btn-xs'
                  onclick='ajaxModule.removeFromCart($id)'>Remove</button></td>
            </tr>";
    }
    if($total > 0){
        echo "<tr>
            <td></td>
            <td></td>
            <td><b>Total: </b></td>
            <td><b>$total</b></td>
            <td></td>
          </tr>";
    }
?>
    </tbody>
</table>
<div class="form-group checkout-form">
    <label class="control-label" for="card-number">Credit Card number</label>
    <input class="form-control" id="card-number" type="text" value="Enter card number...">

    <label class="control-label" for="security-code">Security code</label>
    <input class="form-control" id="security-code" type="text" value="Enter security code...">

    <button onclick="ajaxModule.checkOut();" class="btn btn-primary checkout-button">Checkout</button>
</div>
