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
	
	chamaTpl("index", array(
			"products" => Product::checkList($products)
	));

});

 ?>
