<?php

use \Berinc\Page;
use \Berinc\PageAdmin;
use \Berinc\Model\User;
use \Berinc\Model\Cart;
use \Berinc\Model\Company;

const ID_PARAMS_EMPRESA_PADRAO = 10;

function post($key){

		return str_replace("'", "", $_POST[$key]);
}

function get($key){

		return str_replace("'", "", $_GET[$key]);
}

function dateFormat($data){

	return date('d/m/Y', strtotime($data));

}

function chamaTpl($view, $data = array(), $mostraHeader = true, $mostraFooter = true){

	$page = new Page(array(
	    "header" => $mostraHeader,
	    "footer" => $mostraFooter
	));

	$page->setTpl($view, $data);
}

function chamaTplAdmin($view, $data = array(), $mostraHeader = true, $mostraFooter = true){

	$page = new PageAdmin(array(
	    "header" => $mostraHeader,
	    "footer" => $mostraFooter
	));

	$page->setTpl($view, $data);
}

function formatPrice($vlprice){

    if(!$vlprice > 0){
			$vlprice = 0;
	}
	return number_format($vlprice, '2', ',', '.');

}

function checkLogin($inadmin = true){

	return User::checkLogin($inadmin);
}

function getUserName(){

	$user = User::getFromSession();

	return $user->getdesperson();
}

function getCartNrQtd(){

	$cart = Cart::getFromSession();
	$totals = $cart->getProductsTotals();
	return $totals['nrqtd'];
}

function getCartVlSubTotal(){

	$cart = Cart::getFromSession();
	$totals = $cart->getProductsTotals();
	return formatPrice($totals['vlprice']);
}

function getImgBase64($file, $pid ){
		
	$extension = explode('.', $file['name']);
	$extension = end($extension);

	switch ($extension) {

		case "jpg":
		case "jpeg":
		$image = imagecreatefromjpeg($file["tmp_name"]);
		break;

		case "gif":
		$image = imagecreatefromgif($file["tmp_name"]);
		break;

		case "png":
		$image = imagecreatefrompng($file["tmp_name"]);
		break;

	}
	
	$dist = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $pid . ".jpg";

	imagejpeg($image, $dist);

	imagedestroy($image);
	
	$code = base64_encode(file_get_contents($dist));
	
	return 'data:image/jpeg;base64,' . $code;
}

function getFieldCompany($campo){
  
	$company = new Company();
	$company->get((int)ID_PARAMS_EMPRESA_PADRAO);
	
	return $company->getField($campo);

}

 ?>
