<?php

use \Hcode\Model\User;

$app->get('/admin/login', function() {

		chamaTplAdmin("login", array(), false, false);
});

$app->get('/admin/login/', function() {

		chamaTplAdmin("login", array(), false, false);
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


 ?>
