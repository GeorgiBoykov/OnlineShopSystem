var ajaxModule = (function () {
    // Register user
    (function () {
        var url = '/authentication/register';
        var registerForm = $('#register-form');

        registerForm.submit(function (e) {
            e.preventDefault();
            var data = registerForm.serialize();

            $.ajax({
                url: url,
                type : "POST",
                data: data,
                success: function (html) {
                    console.log(html);
                    window.location = '/home';
                },
                error: function(xhr, status, error) {
                    notificationModule.showErrorMessage(xhr.responseText);
                }
            });
        });
    }());

    // Login user
    (function () {
        var url = '/authentication/login';
        var loginForm = $('#login-form');

        loginForm.submit(function (e) {
            e.preventDefault();
            var data = loginForm.serialize();

            $.ajax({
                url: url,
                type : "POST",
                data: data,
                success: function () {
                    window.location = '/home';
                },
                error: function(xhr, status, error) {
                    notificationModule.showErrorMessage(xhr.responseText);
                }
            });
        });
    }());

    // Logout user
    (function () {
        var url = '/authentication/logout';
        var logoutButton = $('#logout-button');

        logoutButton.click(function (e) {
            e.preventDefault();

            $.ajax({
                url: url,
                type : "GET",
                success: function () {
                    window.location = '/';
                },
                error: function(xhr, status, error) {
                    notificationModule.showErrorMessage(xhr.responseText);
                }
            });
        });
    }());

    // List new product for sale
    (function () {
        var url = '/products/list';
        var addProductForm = $('#add-product-form');

        addProductForm.submit(function (e) {
            e.preventDefault();
            var data = addProductForm.serialize();

            $.ajax({
                url: url,
                type : "POST",
                data: data,
                success: function () {
                    notificationModule.showSuccessMessage('Product successfully listed.');
                    setTimeout(function () {
                        window.location = '/home';
                    }, 700);
                },
                error: function(xhr, status, error) {
                    notificationModule.showErrorMessage(xhr.responseText);
                }
            });
        });
    }());

    // Add new product to user shopping cart
    function addToCart(productId){
        var url = '/products/buy/' + productId;
        $.ajax({
                url: url,
                type : "GET",
                success: function(result){
                    notificationModule.showSuccessMessage('Product successfully added to cart');
                    $('#add-to-cart-' + productId).prop('disabled', true);
                },
                error: function(xhr, status, error) {
                    notificationModule.showErrorMessage(xhr.responseText);
                }
            });
    }

    // Remove product from shopping cart
    function removeFromCart(id) {
        var url = '/products/unbuy/' + id;
        var row = '#row-' + id;
        $.ajax({
            url: url,
            type : "GET",
            success: function (html) {
                $(row).fadeOut();
                notificationModule.showSuccessMessage('Product successfully removed from cart.');
            },
            error: function(xhr, status, error) {
                notificationModule.showErrorMessage(xhr.responseText);
            }
        });
    }

    // Check out shopping cart
    function checkOut(){
        var url = '/users/checkout';
        $.ajax({
                url: url,
                type : "GET",
                success: function(html){
                    notificationModule.showSuccessMessage('Checkout successful!');
                    $('.checkout-form').fadeOut(200);
                    $('.table-hover').fadeOut(400);
                },
                error: function(xhr, status, error) {
                    notificationModule.showErrorMessage(xhr.responseText);
                }
            });
    }

    function getCartItems(){
        var url = '/users/cart-items';
        $.ajax({
            url: url,
            type : "GET",
            success: function(result){
                var json = result.match(/(\[.*])/);
                var purchases = JSON.parse(json[1]);
                var cart = $(".cart-items");
                cart.empty();

                if(purchases.length == 0){
                    cart.append('<a href=""><div class="list-group-item">Cart is empty.</div></a>');
                    return;
                }

                for(var purchase in purchases){
                    var p = purchases[purchase];
                    cart.append(
                            '<div class="list-group-item">'+
                                '<img style="width: 14px; margin-right: 2px;" src="/images/basket.png"</img>'+
                                '<span>' + p['productName']+' <span>'+
                                '<span>(' + p['price']+' bgn)<span>'+
                            '</div>');
                }

                if(purchases.length >= 5){
                    cart.append('<div style="text-align: center; padding: 5px">And more...</div>');
                }
            },
            error: function(xhr, status, error) {
                notificationModule.showErrorMessage(xhr.responseText);
            }
        });
    }

    function addCategory(){
        var url = '/categories/create';
        var name = $('#new-category').val();
        $.ajax({
            url: url,
            type : "POST",
            data: { name: name, description: null },
            success: function () {
                notificationModule.showSuccessMessage('Category successfully created.');
                $('#categories').append(
                '<a href="/products/category/'+name+ '" id="category-'+name+'" class="list-group-item">'+ name +
                '<span class="btn btn-danger btn-xs" id="remove-category" onclick="ajaxModule.removeCategory(\'' + name +
                '\')">Remove</span></a>');
                $('#new-category').val('');
            },
            error: function(xhr, status, error) {
                notificationModule.showErrorMessage(xhr.responseText);
            }
        });
    }

    function removeCategory(name){
        var url = '/categories/remove/' + name;
        var categoryNode = '#category-' + name;
        $(categoryNode).prop('href', '#');
        $.ajax({
            url: url,
            type : "GET",
            success: function (html) {
                $(categoryNode).fadeOut();
                notificationModule.showSuccessMessage('Category successfully removed.');
            },
            error: function(xhr, status, error) {
                notificationModule.showErrorMessage(xhr.responseText);
            }
        });
    }
    function removeProduct(id){
        var url = '/products/remove/' + id;
        var productNode = '#product-full-' + id;
        $.ajax({
            url: url,
            type : "GET",
            success: function (html) {
                $(productNode).fadeOut();
                notificationModule.showSuccessMessage('Product successfully removed.');
            },
            error: function(xhr, status, error) {
                notificationModule.showErrorMessage(xhr.responseText);
            }
        });
    }

    return{
        addToCart: addToCart,
        removeFromCart: removeFromCart,
        checkOut: checkOut,
        getCartItems: getCartItems,
        addCategory: addCategory,
        removeCategory: removeCategory,
        removeProduct: removeProduct
    }
})();