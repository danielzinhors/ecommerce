<?php

use \Hcode\Model\User;

$app->get('/profile', function(){

    User::verifyLogin(false);
    $user = User::getFromSession();
    chamaTpl("profile",
        array(
          'user' => $user->getValues(),
          'profileMsg' => User::getSuccess(),
          'profileError' => User::getMsgError()
        )
    );

});

$app->post('/profile', function(){

    User::verifyLogin(false);

    if(!isset($_POST['desperson']) || $_POST['desperson'] === ''){
      User::setMsgError("Preencha seu nome!");
      header("Location: /profile");
      exit;
    }

    if(!isset($_POST['desemail']) || $_POST['desemail'] === ''){
      User::setMsgError("Preencha seu e-mail!");
      header("Location: /profile");
      exit;
    }

    $user = User::getFromSession();

    if ($_POST['desemail'] !== $user->getdesemail()){
      if(User::checkLoginExist($_POST['desemail']) === true){
        User::setMsgError("Este e-mail já está cadastrado!");
        header("Location: /profile");
        exit;
      }
    }

    $_POST['desemail'] = $user->getinadmin();
    $_POST['despassword'] = $user->getdespassword();
    $_POST['deslogin'] = $_POST['desemail'];

    $user->update();

    User::setSuccess('Alterações concluidas com sucesso!');
    header("Location: /profile");
    exit;
});


 ?>
