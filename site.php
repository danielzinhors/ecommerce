<?php

use \Hcode\Model\Category;
use \Hcode\Model\Product;

$app->get('/', function() {

		chamaTpl("index");

});

$app->get('/categories/:idcategory', function($idcategory){

    $category = new Category;
    $category->get((int)$idcategory);

    chamaTpl("category",
				array(
					"category" => $category->getValues(),
					"products" => []
				)
		);
});


 ?>
