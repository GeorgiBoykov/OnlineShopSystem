<html>
    <head>
        <meta charset="UTF-8">
        <title>Online Shop</title>
        <base href="http://localhost">
        <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </head>
<body>
<?php
        error_reporting(E_ALL ^ E_NOTICE);
        session_start();
        include_once("../views/layouts/navbar.php");

        echo "<div id=\"wrapper\">";

        include '../../MVCFramework/App.php';

        $app = MVCFramework\App::getInstance();
        $app->run();

        echo "<div>";
?>
</body>
</html>