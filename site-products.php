<?php

use \Berinc\Model\Product;


$app->get('/products/:desurl', function($desurl){

		$product = new Product();
		$product->getFromURL($desurl);

		chamaTpl("product-detail", 
			array(
				'product' => $product->getValues(),
				'categories' => $product->getCategoies()
			)
		);

});

$app->get('/products', function(){

	$products = Product::listAll();

	chamaTpl("products", 
		array(
			"products" => Product::checkList($products)
			//'categories' => $product->getCategoies()
		)
	);

});

?>
