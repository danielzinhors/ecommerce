<?php

use \Berinc\Model\Product;

$app->get('/', function() {
	
	$products = Product::listAll();
	
	chamaTpl("index", array(
			"products" => Product::checkList($products)
	));

});

 ?>
