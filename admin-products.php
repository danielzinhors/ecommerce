<?php


use \Hcode\Model\Product;
use \Hcode\Model\User;

$app->get('/admin/products', function(){

    User::verifyLogin();
		$products = Product::listAll();

    chamaTplAdmin('products', array(
					"products" => $products
		  )
		);
});

$app->get('/admin/products/create', function(){

    User::verifyLogin();

    chamaTplAdmin('products-create');
});

$app->post('/admin/products/create', function(){

    User::verifyLogin();
		$product = new Product();
		$product->setData($_POST);
		$product->save();

		header("Location: /admin/products");
		exit;
});

$app->get('/admin/products/:idproduct/delete', function($idproduct){

    User::verifyLogin();
		$product = new Product();
		$product->get((int)$idproduct);
		$product->delete();

    header("Location: /admin/products");
		exit;
});

$app->get('/admin/products/:idproduct', function($idproduct){

  	User::verifyLogin();
  	$product = new Product();
  	$product->get((int)$idproduct);

  	chamaTplAdmin("products-update", array(
  			'product' => $product->getValues()
  		)
  	);

});

$app->post('/admin/products/:idproduct', function($idproduct){

		$product = new Product();
	  $product->get((int)$idproduct);
		$product->setData($_POST);
		$product->save();
    if ((int)$_FILES["file"]["size"] > 0) {
        $product->setPhoto($_FILES["file"]);
  }
		header("Location: /admin/products");
		exit;

});

 ?>
