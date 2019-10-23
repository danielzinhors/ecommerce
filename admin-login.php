<?php

use \Berinc\Model\User;

function chamaIndex(){

	chamaTplAdmin("login",
		array(
			'error' => User::getMsgError(),
		), false, false);
}

$app->get('/admin/login', function() {
	chamaIndex();
});

$app->get('/admin/login/', function() {
    chamaIndex();
});

$app->post('/admin/login', function() {

    try{
		 User::login($_POST["deslogin"], $_POST["despassword"]);
	}catch(Exception $e){
         User::setMsgError($e->getMessage());
    }
	  header("Location: /admin");
	  exit;

});

$app->get('/admin/logout', function(){

		User::logout();

  	header("Location: /admin/login");
		exit;
});


 ?>
