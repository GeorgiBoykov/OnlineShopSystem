<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/users/profile"><?php echo $_SESSION['username']?></a></li>
                <li class="active"><a href="/products/add">Sell Product<span class="sr-only">(current)</span></a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search" action="/products/search">
                <div class="form-group">
                    <input type="text" name="term"  class="form-control" placeholder="Search product">
                </div>
                <input type="submit" class="btn btn-default" value="Search"/>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <?php include_once("../views/cart/cart-preview.php")?>
                </li>
                <li><a href="" id="logout-button">Logout</a></li>
            </ul>
        </div>