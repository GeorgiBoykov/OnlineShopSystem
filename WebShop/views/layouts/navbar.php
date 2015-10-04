<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"
               href="
               <?php if(isset($_SESSION['is_logged'])){
                   echo "/home";
               } else{
                   echo "/";
               }
               ?>">
                <img src="/images/webshop.png" width="110px" height="48px" alt="">
                </a>
        </div>
        <?php if(isset($_SESSION['is_logged'])){ include_once("navbar-logged-users.php"); }?>
    </div>
</nav>
