<?php

session_start();
require_once("vendor/autoload.php");
require_once("functions.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {

	$page = new Page();

	$page->setTpl("index");

});

function acessarAdmin(){
	User::verifyLogin();
	$page = new PageAdmin();

	$page->setTpl("index");
}

$app->get('/admin', function() {
		acessarAdmin();
});

$app->get('/admin/', function() {
		acessarAdmin();
});

function chamaLogin(){
	$page = new PageAdmin(array(
    "header" => false,
    "footer" => false
  ));

	$page->setTpl("login");
}

$app->get('/admin/login', function() {
	chamalogin();
});

$app->get('/admin/login/', function() {
	chamalogin();
});

$app->post('/admin/login', function() {

	User::login($_POST["deslogin"], $_POST["despassword"]);

  header("Location: /admin");
  exit;

});

$app->get('/admin/logout', function(){
	User::logout();
	header("Location: /admin/login");
	exit;
});

$app->run();

 ?>
