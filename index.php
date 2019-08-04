<?php

session_start();
require_once("vendor/autoload.php");
require_once("functions.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;

$app = new Slim();

$app->config('debug', true);

function chamaTpl($view, $data = array(), $mostraHeader = true, $mostraFooter = true){

	$page = new PageAdmin(array(
    "header" => $mostraHeader,
    "footer" => $mostraFooter
  ));

	$page->setTpl($view, $data);
}

$app->get('/', function() {

	$page = new Page();

	$page->setTpl("index");

});

function acessarAdmin(){
	User::verifyLogin();
	chamaTpl("index");
}

$app->get('/admin', function() {
		acessarAdmin();
});

$app->get('/admin/', function() {
		acessarAdmin();
});

$app->get('/admin/login', function() {
	chamaTpl("login", array(), false, false);
});

$app->get('/admin/login/', function() {
	chamaTpl("login", array(), false, false);
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

		chamaTpl("users", array(
			"users" => $users
		),
		true,
		true
	);

});
//criar usuario
$app->get('/admin/users/create', function(){

		User::verifyLogin();

		chamaTpl("users-create");

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
		chamaTpl("forgot", array(), false, false);
});

$app->post('/forgot', function(){

	$user = User::getForgot($_POST["email"], false);
	header("Location: /forgot/sent");
	exit;
});

$app->get('/forgot/sent', function(){
		chamaTpl("forgot-sent", array(), false, false);
});

$app->get('/forgot/reset', function(){

		$user = User::validForgotDecrypt($_GET["code"]);

		chamaTpl("forgot-reset", array(
			  "name" => $user["desperson"],
			  "code" => $_GET["code"]
		  ),
			false,
			false
		);
});

$app->post('/forgot/reset', function(){
	$forgot = User::validForgotDecrypt($_POST["code"]);

	User::setForgotUsed($forgot["idrecovery"]);

	$user = new User();

	$user->get((int)$forgot["iduser"]);
  $password = User::getPasswordHash($_POST["password"]);
	$user->setPassword($password);

	chamaTpl("forgot-reset-success", array(), false, false);

});

$app->get('/admin/categories', function(){
		User::verifyLogin();
		$categories = Category::listAll();
		chamaTpl('categories', array(
			"categories" => $categories
		  )
		);
});

$app->get('/admin/categories/create', function(){
		User::verifyLogin();
		chamaTpl('categories-create');
});

$app->post('/admin/categories/create', function(){
		User::verifyLogin();
		$category = new Category();

		$category->setData($_POST);

		$category->save();

		header("Location: /admin/categories");
		exit;
});

$app->get('/admin/categories/:idcategory/delete', function($idcategory){
	  User::verifyLogin();
		$category = new Category();
		$category->get((int)$idcategory);
		$category->delete();
		header("Location: /admin/categories");
		exit;
});

$app->get('/admin/categories/:idcategory', function($idcategory){
  User::verifyLogin();
	$category = new Category();
	$category->get((int)$idcategory);
	chamaTpl("categories-update", array(
			"category" => $category->getValues()
		)
	);

});

$app->post('/admin/categories/:idcategory', function($idcategory){

	$category = new Category();
	$category->get((int)$idcategory);
  $category->setData($_POST);
	$category->save();
	header("Location: /admin/categories");
	exit;
});

$app->run();

 ?>
