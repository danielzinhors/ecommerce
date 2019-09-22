<?php
use \Berinc\Model\Cart;
use \Berinc\Model\Address;
use \Berinc\Model\User;
use \Berinc\Model\Order;


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

$app->get("/order/:idorder/paypal", function($idorder){

    User::verifyLogin(false);

    $order = new Order;

    $order->get((int)$idorder);
    $cart = $order->getCart();
    
    chamaTpl("payment-paypal",
        array(
            'order' => $order->getValues(),
            'cart' => $cart->getValues(),
            'products' => $cart->getProducts()
        ),
        false,
        false
    );

});

?>
