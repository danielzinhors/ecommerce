<?php

use \Hcode\Model\Category;
use \Hcode\Model\Product;
use \Hcode\Model\Cart;

$app->get('/', function() {

		$products = Product::listAll();

		chamaTpl("index", array(
				"products" => Product::checkList($products)
		));

});

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

$app->get('/cart', function(){

		$cart = Cart::getFromSession();
		
		//chamaTpl("cart");
		chamaTpl("cart",
			array(
				'cart' => $cart->getValues(),
				'products' => $cart->getProducts()
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

 ?>
