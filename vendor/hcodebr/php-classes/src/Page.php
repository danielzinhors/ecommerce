<?php

namespace Hcode;

use Rain\Tpl;

class Page{

    private $tpl;
    private $options = [];
    private $defauts = [
        "data" => []
    ];

    public function __construct($opts = array()){

        $this->options = array_merge($this->defauts, $opts);
        // config
        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "ecommerce" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR,
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "ecommerce" . DIRECTORY_SEPARATOR ."views-cache" . DIRECTORY_SEPARATOR, 
            "debug"         => false // set to false to improve the speed
        );

        Tpl::configure( $config );

        $this->tpl = new Tpl;

        $this->setData($this->options["data"]);

        $this->tpl->draw("header");

    }

    private function setData($data = array()){
       
        foreach($data as $key => $value){
            $this->tpl->assign($key, $value);
        }
    }

    public function setTpl($name, $data = array(), $returnHTML = false){
        
        $this->setData($data);

        return $this->tpl->draw($name, $returnHTML);
    }

    public function __destruct(){
        $this->tpl->draw("footer");
    }
}