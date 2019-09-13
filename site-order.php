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

$app->get("/order/:idorder/pagseguro", function($idorder){

    User::verifyLogin(false);

    $order = new Order;

    $order->get((int)$idorder);
    $cart = $order->getCart();
    chamaTpl("payment-pagseguro",
        array(
            'order' => $order->getValues(),
            'cart' => $cart->getValues(),
            'products' => $cart->getProducts(),
            'phone' => array(
                'areaCode' => substr($order->getnrphone(), 0, 2),
                'number' => substr($order->getnrphone(), 2, strlen($order->getnrphone()))
            )
        ),
        false,
        false
    );

});

?>
