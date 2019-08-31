<?php

use \Hcode\Model\Product;


$app->get('/products/:desurl', function($desurl){

		$product = new Product();
		$product->getFromURL($desurl);

		chamaTpl("product-detail", array(
						'product' => $product->getValues(),
						'categories' => $product->getCategoies()
			  )
		);

});

?>
