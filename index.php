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

function chamaTpl($view, $data = array()){
	$page = new PageAdmin(array(
    "header" => false,
    "footer" => false
  ));

	$page->setTpl($view, $data);
}

$app->get('/admin/login', function() {
	chamaTpl("login");
});

$app->get('/admin/login/', function() {
	chamaTpl();
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

$app->get('/admin/users', function(){

		User::verifyLogin();

		$users = User::listAll();

		$page = new PageAdmin();

		$page->setTpl("users", array(
			"users" => $users
		));

});
//criar usuario
$app->get('/admin/users/create', function(){

		User::verifyLogin();

		$page = new PageAdmin();

		$page->setTpl("users-create");

});
//deletar tem que vir antes de outra rota que contenha o :iduser sem methodo
$app->get('/admin/users/:iduser/delete', function($iduser){

	User::verifyLogin();

	$user = new User;

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /admin/users");
	exit;

});
//editar
$app->get('/admin/users/:iduser', function($iduser){

		User::verifyLogin();
		$user = new User();
		$user->get((int)$iduser);
		$page = new PageAdmin();

		$page->setTpl("users-update", array(
			"user" => $user->getValues()
		));

});
//criar no bd
$app->post('/admin/users/create', function(){

		User::verifyLogin();

		$user = new User();

		$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
		$user->setData($_POST);

		$user->save();

		header("Location: /admin/users");
		exit;

});
//update no bd
$app->post('/admin/users/:iduser', function($iduser){

	User::verifyLogin();

	$user = new User();
  $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	$user->get((int)$iduser);
	$user->setData($_POST);

	$user->update();

	header("Location: /admin/users");
	exit;

});

$app->get('/forgot', function(){
		chamaTpl("forgot");
});

$app->post('/forgot', function(){

	$user = User::getForgot($_POST["email"], false);
	header("Location: /forgot/sent");
	exit;
});

$app->get('/forgot/sent', function(){
		chamaTpl("forgot-sent");
});

$app->get('/forgot/reset', function(){

		$user = User::validForgotDecrypt($_GET["code"]);

		chamaTpl("forgot-reset", array(
			"name" => $user["desperson"],
			"code" => $_GET["code"]
		));
});

$app->post('/forgot/reset', function(){
	$forgot = User::validForgotDecrypt($_POST["code"]);

	User::setForgotUsed($forgot["idrecovery"]);

	$user = new User();

	$user->get((int)$forgot["iduser"]);
  $password = User::getPasswordHash($_POST["password"]);
	$user->setPassword($password);

	chamaTpl("forgot-reset-success");

});

$app->run();

 ?>
