<?php


use \Berinc\Model\User;

function acessarAdmin(){
	
		User::verifyLogin();
		chamaTplAdmin("index");
}

$app->get('/admin', function() {

		acessarAdmin();
});

$app->get('/admin/', function() {

		acessarAdmin();
});

 ?>
