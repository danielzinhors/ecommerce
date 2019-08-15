<?php

use \Hcode\Model\Category;
use \Hcode\Model\Product;

$app->get('/', function() {

		$products = Product::listAll();

		chamaTpl("index", array(
				"products" => Product::checkList($products)
		));

});

/*$app->get('/categories/:idcategory', function($idcategory){

    $category = new Category;
    $category->get((int)$idcategory);

    chamaTpl("category",
				array(
					"category" => $category->getValues(),
					"products" => Product::checkList($category->getProducts())
				)
		);
});*/

$app->get('/categories/:idcategory', function($idcategory){

		$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    $category = new Category;
    $category->get((int)$idcategory);

		$pagination = $category->getProductsPage($page);

		$pages = [];

		for ($i = 1; $i <= $pagination['pages']; $i++){
				array_push(
						$pages,
						array(
							'link' => '/categories/' . $category->getidcategory() . '?page=' . $i,
						  'page' => $i
						)
				);
		}

    chamaTpl("category",
				array(
					"category" => $category->getValues(),
					"products" => $pagination['data'],
					"pages" => $pages
				)
		);
});

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
