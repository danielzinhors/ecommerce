<?php

use \Hcode\Model\User;
use \Hcode\Model\Order;
use \Hcode\Model\Cart;

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

$app->get('/profile/orders', function(){

    User::verifyLogin(false);
    $user = User::getFromSession();

    chamaTpl("profile-orders",
        array(
          'orders' => $user->getOrders()
        )
    );

});

$app->get('/profile/orders/:idorder', function($idorder){

  User::verifyLogin(false);

  $order = new Order();

  $order->get((int)$idorder);

  $cart = new Cart();

  $cart->get((int)$order->getidcart());

  chamaTpl("profile-orders-detail",
      array(
        'order' => $order->getValues(),
        'cart' => $cart->getValues(),
        'products' => $cart->getProducts()
      )
  );

});

$app->get('/profile/change-password', function(){

  User::verifyLogin(false);

  chamaTpl("profile-change-password",
      array(
        'changePassError' => User::getMsgError(),
        'changePassSuccess' => User::getSuccess()
      )
  );

});

$app->post('/profile/change-password', function(){

  User::verifyLogin(false);

  if(!isset($_POST['current_pass']) || $_POST['current_pass'] === ''){
    User::setMsgError('Digite a senha atual');
    header("Location: /profile/change-password");
    exit;
  }

  if(!isset($_POST['new_pass']) || $_POST['new_pass'] === ''){
    User::setMsgError('Digite a nova atual');
    header("Location: /profile/change-password");
    exit;
  }

  if(!isset($_POST['new_pass_confirm']) || $_POST['new_pass_confirm'] === ''){
    User::setMsgError('Confirme a nova senha');
    header("Location: /profile/change-password");
    exit;
  }

  if($_POST['new_pass_confirm'] != $_POST['new_pass']){
    User::setMsgError('Confirme a senha corretamente');
    header("Location: /profile/change-password");
    exit;
  }

  if($_POST['current_pass'] === $_POST['new_pass']){
    User::setMsgError('A nova senha não pode ser igual a senha atual');
    header("Location: /profile/change-password");
    exit;
  }

  $user = User::getFromSession();
  if(!password_verify($_POST['current_pass'], $user->getdespassword())){
    User::setMsgError('Senha atual inválida');
    header("Location: /profile/change-password");
    exit;
  }

  $user->setdespassword($_POST['new_pass']);
  $user->update();

  User::setSuccess('Senha alterada com sucesso!');
  header("Location: /profile/change-password");
  exit;

});




 ?>
