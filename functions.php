<?php

use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

function post($key){

		return str_replace("'", "", $_POST[$key]);
}

function get($key){

		return str_replace("'", "", $_GET[$key]);
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

function formatPrice(float $vlprice){

		return number_format($vlprice, '2', ',', '.');

}

function checkLogin($inadmin = true){

		return User::checkLogin($inadmin);
}

function getUserName(){

	  $user = User::getFromSession();

		return $user->getdesperson();
}

 ?>
