<?php

namespace Berinc;

use Rain\Tpl;

class Page{

    private $tpl;
    private $options = [];
    private $defauts = [
        "header" => true,
        "footer" => true,
        "data" => []
    ];

    public function __construct($opts = array(), $tpl_dir = 'views'){

        $this->options = array_merge($this->defauts, $opts);
        // config
        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"] .
                  DIRECTORY_SEPARATOR . $tpl_dir .
                  DIRECTORY_SEPARATOR,
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"] .
                  DIRECTORY_SEPARATOR . "views-cache" .
                  DIRECTORY_SEPARATOR,
            "debug"         => false // set to false to improve the speed
        );

        Tpl::configure( $config );

        $this->tpl = new Tpl;

        $this->setData($this->options["data"]);

        if ($this->options["header"] === true){
            $this->tpl->draw("header");
        }

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

        if ($this->options["footer"] === true){
          $this->tpl->draw("footer");
        }
    }
}
