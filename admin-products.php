<?php


use \Berinc\Model\Product;
use \Berinc\Model\User;

$app->get('/admin/products', function(){

  User::verifyLogin();

  $search = (isset($_GET['search'])) ? $_GET['search'] : "";

  $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

  if($search != ''){
     $pagination = Product::getPageSearch($search, $page);
  }else{
      $pagination = Product::getPage($page);
  }

  $pages = [];

  for($x = 0; $x < $pagination['pages']; $x++){
      array_push(
        $pages,
        array(
          'href' => '/admin/products?' . http_build_query(
              array(
                  'page' => $x + 1,
                  'search' => $search
              )
          ),
          'text' => $x + 1
        )
      );
  }

  chamaTplAdmin("products", array(
        "products" => $pagination['data'],
        'search' => $search,
        'pages' => $pages
      ),
      true,
      true
  );

});

$app->get('/admin/products/create', function(){

    User::verifyLogin();
    
    chamaTplAdmin('products-create');
});

$app->post('/admin/products/create', function(){

    User::verifyLogin();
    $product = new Product();
    $_POST["in_slider"] = (isset($_POST["in_slider"]))? 'V' : 'F';
    //
		$product->setData($_POST);
		$product->save();

		header("Location: /admin/products");
		exit;
});

$app->get('/admin/products/:idproduct/delete', function($idproduct){

    User::verifyLogin();
		$product = new Product();
		$product->get((int)$idproduct);
		$product->delete();

    header("Location: /admin/products");
		exit;
});

$app->get('/admin/products/:idproduct', function($idproduct){

  	User::verifyLogin();
  	$product = new Product();
  	$product->get((int)$idproduct);

  	chamaTplAdmin("products-update", array(
  			'product' => $product->getValues()
  		)
  	);

});

$app->post('/admin/products/:idproduct', function($idproduct){

		$product = new Product();
    $product->get((int)$idproduct);
    $_POST["in_slider"] = (isset($_POST["in_slider"])) ? 'V' : 'F';
    $product->setData($_POST);
    $product->save();
    
    if ((int)$_FILES["file"]["size"] > 0) {
        $product->setPhoto($_FILES["file"]);
    }
		header("Location: /admin/products");
		exit;

});

 ?>
