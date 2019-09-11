<?php

use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Cart;

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

 ?>
