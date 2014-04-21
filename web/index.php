<?php 
define('ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
$config = include_once ROOT . DS . 'config.php';
include_once ROOT . DS . 'Tiny.php';
$app = new Tiny();
$app->init($config);


