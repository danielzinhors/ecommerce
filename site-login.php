<?php

use \Hcode\Model\User;

$app->get('/login', function() {

		chamaTpl("login",
      array(
        'error' => User::getMsgError()
      ), true, true);
});

$app->post('/login', function() {

    try{
      User::login($_POST['login'], $_POST['password']);
    }catch(Exception $e){
        User::setMsgError($e->getMessage());
    }
	 	  header("Location: /checkout");
      exit;
});

$app->get('/logout', function() {

      User::logout();
      header("Location: /login");
      exit;
});

 ?>
