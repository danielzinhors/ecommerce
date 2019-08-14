<?php


use \Hcode\Model\Category;
use \Hcode\Model\Product;
use \Hcode\Model\User;

$app->get('/admin/categories', function(){

    User::verifyLogin();
		$categories = Category::listAll();

    chamaTplAdmin('categories', array(
			   "categories" => $categories
		  )
		);
});

$app->get('/admin/categories/create', function(){

    User::verifyLogin();

    chamaTplAdmin('categories-create');
});

$app->post('/admin/categories/create', function(){

    User::verifyLogin();
		$category = new Category();
		$category->setData($_POST);
		$category->save();

		header("Location: /admin/categories");
		exit;
});

$app->get('/admin/categories/:idcategory/delete', function($idcategory){

    User::verifyLogin();
		$category = new Category();
		$category->get((int)$idcategory);
		$category->delete();

    header("Location: /admin/categories");
		exit;
});

$app->get('/admin/categories/:idcategory', function($idcategory){

    User::verifyLogin();
    $category = new Category();
		$category->get((int)$idcategory);

    chamaTplAdmin("categories-update", array(
				"category" => $category->getValues()
			)
		);

});

$app->post('/admin/categories/:idcategory', function($idcategory){

    User::verifyLogin();
		$category = new Category();
		$category->get((int)$idcategory);
	  $category->setData($_POST);
		$category->save();

    header("Location: /admin/categories");
		exit;
});

$app->get('/admin/categories/:idcategory/products', function($idcategory){

    User::verifyLogin();
    $category = new Category();
		$category->get((int)$idcategory);

    chamaTplAdmin("categories-products",
        array(
          'category' => $category->getValues(),
          'productsRelated' => $category->getProducts(),
          'productsNotRelated' => $category->getProducts(false)
        )
    );
});

$app->get('/admin/categories/:idcategory/products/:idproduct/add', function($idcategory, $idproduct){

    User::verifyLogin();
    $category = new Category();
		$category->get((int)$idcategory);

    $product = new Product();
    $product->get((int)$idproduct);
    $category->addProduct($product);

    header("Location: /admin/categories/" . $idcategory . "/products");
    exit;
});

$app->get('/admin/categories/:idcategory/products/:idproduct/remove', function($idcategory, $idproduct){

    User::verifyLogin();
    $category = new Category();
		$category->get((int)$idcategory);

    $product = new Product();
    $product->get((int)$idproduct);
    $category->removeProduct($product);

    header("Location: /admin/categories/" . $idcategory . "/products");
    exit;
});

 ?>
