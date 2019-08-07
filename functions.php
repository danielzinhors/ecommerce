<?php

use \Hcode\Page;
use \Hcode\PageAdmin;

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

 ?>
