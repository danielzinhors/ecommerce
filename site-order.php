<?php
use \Hcode\Model\Cart;
use \Hcode\Model\Address;
use \Hcode\Model\User;
use \Hcode\Model\Order;


$app->get('/order/:idorder', function($idorder){

     User::verifyLogin(false);

     $order = new Order();
     $order->get((int)$idorder);

     chamaTpl("payment",
        array(
           'order' => $order->getValues()
        ),
        true,
        true
     );

});

?>
