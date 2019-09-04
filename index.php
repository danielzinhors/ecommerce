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
require_once("site-login.php");
require_once("site-checkout.php");
require_once("site-password.php");
require_once("site-profile.php");
//  Partes do admin
require_once("admin.php");
require_once("admin-login.php");
require_once("admin-password.php");
require_once("admin-users.php");
require_once("admin-products.php");
require_once("admin-categories.php");

$app->run();

 ?>
