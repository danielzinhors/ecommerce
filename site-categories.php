<?php

use \Berinc\Model\Category;

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


 ?>
