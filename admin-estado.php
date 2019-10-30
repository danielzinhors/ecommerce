<?php


use \Berinc\Model\Pais;
use \Berinc\Model\Estado;
use \Berinc\Model\User;

$app->get('/admin/estados', function(){

  User::verifyLogin();

  $search = (isset($_GET['search'])) ? $_GET['search'] : "";

  $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
  
  if($search != ''){
     $pagination = Estado::getPageSearch($search, $page);
  }else{
      $pagination = Estado::getPage($page);
  }

  $pages = [];

  for($x = 0; $x < $pagination['pages']; $x++){
      array_push(
        $pages,
        array(
          'href' => '/admin/estado?' . http_build_query(
              array(
                  'page' => $x + 1,
                  'search' => $search
              )
          ),
          'text' => $x + 1
        )
      );
  }

  chamaTplAdmin("estado", array(
        "estados" => $pagination['data'],
        'search' => $search,
        'pages' => $pages
      ),
      true,
      true
  );

});

$app->get('/admin/estado/create', function(){

  User::verifyLogin();
    
  chamaTplAdmin('estado-create',
    array(
      "paises" => Pais::listAll()
    )  
  );
});

$app->post('/admin/estado/create', function(){

    User::verifyLogin();
    $estado = new Estado();
    //
    
    $estado->setData($_POST);
    
    $estado->save();

		header("Location: /admin/estados");
		exit;
});

$app->get('/admin/estado/:idestado/delete', function($idestado){

    User::verifyLogin();
		$estado = new Estado();
		$estado->get((int)$idestado);
		$estado->delete();

    header("Location: /admin/estados");
		exit;
});

$app->get('/admin/estado/:idestado', function($idestado){

  	User::verifyLogin();
  	$estado = new Estado();
  	$estado->get((int)$idestado);

  	chamaTplAdmin("estado-update", array(
        'estado' => $estado->getValues(),
        "paises" => Pais::listAll()
  		)
  	);

});

$app->post('/admin/estado/:idestado', function($idestado){

		$estado = new Estado();
    $estado->get((int)$idestado);
    $estado->setData($_POST);
    $estado->save();
    
		header("Location: /admin/estados");
		exit;

});

 ?>
