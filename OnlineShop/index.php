<a href="/home">Home</a>
<a href="/categories">Categories</a>

<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../MVCFramework/App.php';

$app = MVCFramework\App::getInstance();
$app->run();