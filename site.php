<?php

use \Berinc\Model\Product;

$app->get('/', function() {
	
	chamaTpl("index2", 
		array(),
		false,
		false
	);

});

$app->get('/dev', function() {

	$products = Product::listAll();
	$productsSlider = Product::listSlider();

	chamaTpl("index", 
		array(
			"products" => Product::checkList($products),
			"productsslider" => Product::checklist($productsSlider)
		)
	);

});

 ?>
