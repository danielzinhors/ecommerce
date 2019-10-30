<?php


use \Berinc\Model\Pais;
use \Berinc\Model\User;

$app->get('/admin/pais', function(){

  User::verifyLogin();

  $search = (isset($_GET['search'])) ? $_GET['search'] : "";

  $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

  if($search != ''){
     $pagination = Pais::getPageSearch($search, $page);
  }else{
      $pagination = Pais::getPage($page);
  }

  $pages = [];

  for($x = 0; $x < $pagination['pages']; $x++){
      array_push(
        $pages,
        array(
          'href' => '/admin/pais?' . http_build_query(
              array(
                  'page' => $x + 1,
                  'search' => $search
              )
          ),
          'text' => $x + 1
        )
      );
  }

  chamaTplAdmin("pais", array(
        "pais" => $pagination['data'],
        'search' => $search,
        'pages' => $pages
      ),
      true,
      true
  );

});

$app->get('/admin/pais/create', function(){

    User::verifyLogin();
    
    chamaTplAdmin('pais-create');
});

$app->post('/admin/pais/create', function(){

    User::verifyLogin();
    $pais = new Pais();
    //
    $pais->setData($_POST);
		$pais->save();

		header("Location: /admin/pais");
		exit;
});

$app->get('/admin/pais/:idpais/delete', function($idpais){

    User::verifyLogin();
		$pais = new Pais();
		$pais->get((int)$idpais);
		$pais->delete();

    header("Location: /admin/pais");
		exit;
});

$app->get('/admin/pais/:idpais', function($idpais){

  	User::verifyLogin();
  	$pais = new Pais();
  	$pais->get((int)$idpais);

  	chamaTplAdmin("pais-update", array(
  			'pais' => $pais->getValues()
  		)
  	);

});

$app->post('/admin/pais/:idpais', function($idpais){

		$pais = new Pais();
    $pais->get((int)$idpais);
    $pais->setData($_POST);
    $pais->save();
    
		header("Location: /admin/pais");
		exit;

});

 ?>
