<?php


use \Hcode\Model\User;

$app->get('/admin/users', function(){

		User::verifyLogin();

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";

		$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

		if($search != ''){
			 $pagination = User::getPageSearch($search, $page);
		}else{
				$pagination = User::getPage($page);
		}

		$pages = [];

		for($x = 0; $x < $pagination['pages']; $x++){
				array_push(
					$pages,
					array(
						'href' => '/admin/users?' . http_build_query(
								array(
										'page' => $x + 1,
										'search' => $search
								)
					  ),
						'text' => $x + 1
					)
				);
		}

		chamaTplAdmin("users", array(
					"users" => $pagination['data'],
					'search' => $search,
					'pages' => $pages
				),
				true,
				true
	  );

});
//criar usuario
$app->get('/admin/users/create', function(){

		User::verifyLogin();

		chamaTplAdmin("users-create");

});
//deletar tem que vir antes de outra rota que contenha o :iduser sem methodo
$app->get('/admin/users/:iduser/delete', function($iduser){

		User::verifyLogin();
		$user = new User;
		$user->get((int)$iduser);
		$user->delete();

		header("Location: /admin/users");
		exit;

});
//editar
$app->get('/admin/users/:iduser', function($iduser){

		User::verifyLogin();
		$user = new User();
		$user->get((int)$iduser);

    chamaTplAdmin("users-update", array(
			"user" => $user->getValues()
		));

});
//criar no bd
$app->post('/admin/users/create', function(){

		User::verifyLogin();
		$user = new User();
		$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
		$user->setData($_POST);
		$user->save();

		header("Location: /admin/users");
		exit;

});
//update no bd
$app->post('/admin/users/:iduser', function($iduser){

		User::verifyLogin();
		$user = new User();
	  $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
		$user->get((int)$iduser);
		$user->setData($_POST);
		$user->update();

		header("Location: /admin/users");
		exit;

});

 ?>
