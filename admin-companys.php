<?php


use \Berinc\Model\Company;
use \Berinc\Model\User;

$app->get('/admin/companys', function(){

  User::verifyLogin();

  $search = (isset($_GET['search'])) ? $_GET['search'] : "";

  $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

  if($search != ''){
     $pagination = Company::getPageSearch($search, $page);
  }else{
      $pagination = Company::getPage($page);
  }

  $pages = [];

  for($x = 0; $x < $pagination['pages']; $x++){
      array_push(
        $pages,
        array(
          'href' => '/admin/companys?' . http_build_query(
              array(
                  'page' => $x + 1,
                  'search' => $search
              )
          ),
          'text' => $x + 1
        )
      );
  }
  

  chamaTplAdmin("companys", 
    array(
        "companys" => $pagination['data'],
        'search' => $search,
        'pages' => $pages
    ),
    true,
    true
  );

});

$app->get('/admin/companys/create', function(){

    User::verifyLogin();
    
    chamaTplAdmin('company-create');
});

$app->post('/admin/companys/create', function(){

    User::verifyLogin();
    $company = new Company();
    $company->setData($_POST);
    if ((int)$_FILES["logo"]["size"] > 0) {
        $company->setPhoto($_FILES["logo"]);
    }
    $company->save();

    header("Location: /admin/companys");
    exit;
});

$app->get('/admin/companys/:idparamsempresa/delete', function($idparamsempresa){

    User::verifyLogin();
    $company = new Company();
    $company->get((int)$idparamsempresa);
    $company->delete();

    header("Location: /admin/companys");
	exit;
});

$app->get('/admin/companys/:idparamsempresa', function($idparamsempresa){

  	User::verifyLogin();
  	$company = new Company();
  	$company->get((int)$idparamsempresa);

    chamaTplAdmin("company-update", 
        array(
  			'company' => $company->getValues()
  		)
  	);

});

$app->post('/admin/companys/:idparamsempresa', function($idparamsempresa){

	$company = new Company();
    $company->get((int)$idparamsempresa);
    
    $company->setData($_POST);
    
    
    if ((int)$_FILES["logo"]["size"] > 0) {
        $company->setPhoto($_FILES["logo"]);
    }
    $company->save();
    
    header("Location: /admin/companys");
    exit;

});

 ?>
