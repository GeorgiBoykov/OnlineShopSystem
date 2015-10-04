<?php ob_start(); session_start(); error_reporting(E_ALL ^ E_STRICT ^ E_NOTICE); ?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>WebShop</title>
        <link rel="stylesheet" type="text/css" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <script src="/node_modules/jquery/dist/jquery.min.js"></script>
        <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/node_modules/noty/jquery.noty.packaged.js"></script>
    </head>
<body>
<?php
        include_once("../views/layouts/navbar.php");
        include '../../MVCFramework/App.php';
        $app = MVCFramework\App::getInstance();
?>
<div id="wrapper">
<?php
        $app->run();
        ob_end_flush();
?>
</div>
<script src="/js/notificationModule.js"></script>
<script src="/js/ajaxModule.js"></script>
</body>
</html>