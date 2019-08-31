<?php

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new Slim();

$app->config('debug', true);

//Partes do site cliente
require_once("functions.php");
require_once("site.php");
require_once("site-categories.php");
require_once("site-products.php");
require_once("site-cart.php");
//  Partes do admin
require_once("admin.php");
require_once("login.php");
require_once("password.php");
require_once("admin-users.php");
require_once("admin-products.php");
require_once("admin-categories.php");

$app->run();

 ?>
