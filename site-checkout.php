<?php
use \Hcode\Model\Cart;
use \Hcode\Model\Address;
use \Hcode\Model\User;

$app->get('/checkout', function() {

    User::verifyLogin(false);
    $cart = Cart::getFromSession();

    $address = new Address();

		chamaTpl("checkout",
      array(
        'cart' => $cart->getValues(),
        'address' => $address->getValues()
      ), true, true);
});

 ?>
