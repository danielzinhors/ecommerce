<?php

use \Hcode\Model\User;
use \Hcode\Model\Cart;
use \Hcode\Model\Order;
use \Hcode\Model\OrderStatus;

$app->get('/admin/orders/:idorder/status', function($idorder){

    User::verifyLogin();

    $order = new Order();
    $order->get((int)$idorder);

    chamaTplAdmin('order-status', array(
			   'order' => $order->getValues(),
         'status' => OrderStatus::listAll(),
         'msgSuccess' => Order::getSuccess(),
         'msgError' => Order::getError()
		  )
		);
});

$app->post('/admin/orders/:idorder/status', function($idorder){

    User::verifyLogin();

    if(!isset($_POST['idstatus']) || !(int)$_POST['idstatus'] > 0){
      Order::setError("Defina um status!");
      header("Location: /admin/orders/" . $idorder . "/status");
      exit;
    }
    $order = new Order();
    $order->get((int)$idorder);

    $order->setidstatus($_POST['idstatus']);
    $order->save();
    Order::setSuccess("Status atualizado!");
    header("Location: /admin/orders/" . $idorder . "/status");
    exit;

});

$app->get('/admin/orders/:idorder/delete', function($idorder){

    User::verifyLogin();

    $order = new Order();
    $order->get((int)$idorder);
    $order->delete();
    header("Location: /admin/orders");
    exit;
});

$app->get('/admin/orders/:idorder', function($idorder){

    User::verifyLogin();

    $order = new Order();
    $order->get((int)$idorder);
    $cart = $order->getCart();

    chamaTplAdmin('order', array(
			   'order' => $order->getValues(),
         'cart' => $cart->getValues(),
         'products' => $cart->getProducts()
		  )
		);
});

$app->get('/admin/orders', function(){

    User::verifyLogin();

    chamaTplAdmin('orders', array(
			   "orders" => Order::listAll()
		  )
		);
});



 ?>
