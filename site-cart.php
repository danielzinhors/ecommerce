<?php

use \Hcode\Model\Product;
use \Hcode\Model\Cart;

$app->get('/cart', function(){

		$cart = Cart::getFromSession();

		chamaTpl("cart",
			array(
				'cart' => $cart->getValues(),
				'products' => $cart->getProducts(),
				'error' => $cart->getMsgError()
			)
		);
});

$app->get('/cart/:idproduct/add', function($idproduct){

		$cart = Cart::getFromSession();

		$product = new Product();

		$product->get((int)$idproduct);

    $qtd = (isset($_GET['qtd'])) ? (int)$_GET['qtd'] : 1;
		for ($i = 0; $i < $qtd; $i++){
			$cart->addProduct($product);
	  }
		header("Location: /cart");
		exit;
});

$app->get('/cart/:idproduct/minus', function($idproduct){

		$cart = Cart::getFromSession();

		$product = new Product();

		$product->get((int)$idproduct);

		$cart->removeProduct($product);
		header("Location: /cart");
		exit;
});

$app->get('/cart/:idproduct/remove', function($idproduct){

		$cart = Cart::getFromSession();

		$product = new Product();

		$product->get((int)$idproduct);

		$cart->removeProduct($product, true);
		header("Location: /cart");
		exit;
});

$app->post('/cart/freight', function(){

	  $cart = Cart::getFromSession();

		$cart->setFreight($_POST{'zipcode'});

		header("Location: /cart");
		exit;
});

 ?>
