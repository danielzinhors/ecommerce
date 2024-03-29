<?php

use \Berinc\Model\User;

$app->get('/admin/forgot', function(){

		chamaTplAdmin("forgot", array(), false, false);
});

$app->post('/admin/forgot', function(){

		$user = User::getForgot($_POST["email"]);

  	header("Location: /admin/forgot/sent");
		exit;
});

$app->get('/admin/forgot/sent', function(){

  	chamaTplAdmin("forgot-sent", array(), false, false);
});

$app->get('/admin/forgot/reset', function(){

		$user = User::validForgotDecrypt($_GET["code"]);
		
		chamaTplAdmin("forgot-reset", array(
			  "name" => $user["desperson"],
			  "code" => $_GET["code"]
		  ),
			false,
			false
		);
});

$app->post('/admin/forgot/reset', function(){

  	$forgot = User::validForgotDecrypt($_POST["code"]);

		User::setForgotUsed($forgot["idrecovery"]);

		$user = new User();

		$user->get((int)$forgot["iduser"]);
	  $password = User::getPasswordHash($_POST["password"]);
		$user->setPassword($password);

		chamaTplAdmin("forgot-reset-success", array(), false, false);

});


 ?>
