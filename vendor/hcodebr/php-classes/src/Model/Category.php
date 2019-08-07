<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class Category extends Model{

    public static function listAll(){

      $sql = new Sql();

      return $sql->select(
          "SELECT *
          FROM tb_categories
          order by descategory"
      );
    }

    public function get($idcategory){
        $sql = new Sql();
        $results = $sql->select(
             "SELECT *
             FROM tb_categories
             WHERE idcategory = :idcategory",
             array(
               ":idcategory" => $idcategory
             )
        );

        if(count($results) === 0){
            throw new \Exception("Categoria não encontrada");
        }else {
          $this->setData($results[0]);
        }
    }

    public function save(){
      $sql = new Sql();
      $results = $sql->select(
          "CALL sp_categories_save(
            :idcategory,
            :descategory
            )",
            array(
                ":idcategory" => $this->getidcategory(),
                ":descategory" => $this->getdescategory()
            )
      );

      $this->setData($results[0]);
      Category::updateHtmlCategories();
    }

    public function delete(){

          $sql = new Sql();

          $sql->query(
            "DELETE
            FROM tb_categories
            WHERE idcategory = :idcategory",
            array(
              ":idcategory" => $this->getidcategory()
            )
          );
          Category::updateHtmlCategories();

    }

    public static function updateHtmlCategories(){
        $categories = Category::listAll();
        $html = [];

        foreach ($categories as $registro) {
            array_push(
               $html,
               '<li><a href="/categories/' . $registro["idcategory"] . '">' . $registro["descategory"] .  '</a></li>'
            );
        }

        file_put_contents(
          $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "categories-menu.html",
          implode('', $html));
    }

}

?>
