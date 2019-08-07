<?php

use \Hcode\Model\User;

$app->get('/forgot', function(){

		chamaTplAdmin("forgot", array(), false, false);
});

$app->post('/forgot', function(){

		$user = User::getForgot($_POST["email"], false);

  	header("Location: /forgot/sent");
		exit;
});

$app->get('/forgot/sent', function(){

  	chamaTplAdmin("forgot-sent", array(), false, false);
});

$app->get('/forgot/reset', function(){

		$user = User::validForgotDecrypt($_GET["code"]);

		chamaTplAdmin("forgot-reset", array(
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

		chamaTplAdmin("forgot-reset-success", array(), false, false);

});


 ?>
