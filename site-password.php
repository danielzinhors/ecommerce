<?php

use \Berinc\Model\User;

$app->get('/forgot', function(){

		chamaTpl("forgot", array());
});

$app->post('/forgot', function(){

		$user = User::getForgot($_POST["email"], false);

  	header("Location: /forgot/sent");
		exit;
});

$app->get('/forgot/sent', function(){

  	chamaTpl("forgot-sent", array());
});

$app->get('/forgot/reset', function(){

		$user = User::validForgotDecrypt($_GET["code"]);

		chamaTpl("forgot-reset", array(
			  "name" => $user["desperson"],
			  "code" => $_GET["code"]
		  )
		);
});

$app->post('/forgot/reset', function(){

  	$forgot = User::validForgotDecrypt($_POST["code"]);

		User::setForgotUsed($forgot["idrecovery"]);

		$user = new User();

		$user->get((int)$forgot["iduser"]);
	  $password = User::getPasswordHash($_POST["password"]);
		$user->setPassword($password);

		chamaTpl("forgot-reset-success", array());

});


 ?>
