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

		$category = new Category();
		$category->get((int)$idcategory);
	  $category->setData($_POST);
		$category->save();

    header("Location: /admin/categories");
		exit;
});



 ?>
