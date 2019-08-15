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

    public function getProducts($related = true){

        $sql = new Sql();

        if ($related === true){
            $filtro = ' IN ';
        }else{
             $filtro = ' NOT IN ';
        }

        return $sql->select(
            "SELECT *
            FROM tb_products
            WHERE idproduct $filtro (
                SELECT a.idproduct
                FROM tb_products a
                INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct
                WHERE b.idcategory = :idcategory);",
                array(
                  ':idcategory' => $this->getidcategory()
                )
            );

    }

    public function getProductsPage($page = 1, $itemsPerPage = 2){
        $start = ($page -1) * $itemsPerPage;

        $sql = new Sql();

        $results = $sql->select(
            "SELECT SQL_CALC_FOUND_ROWS *
            FROM tb_products a
            INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct
            INNER JOIN tb_categories c ON c.idcategory = b.idcategory
            WHERE c.idcategory = :idcategory
            LIMIT $start, $itemsPerPage;",
            array(
               ':idcategory' => $this->getidcategory()
            )
        );

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

        return array(
            'data' => Product::checkList($results),
            'total' => (int)$resultTotal[0]["nrtotal"],
            'pages' => ceil($resultTotal[0]["nrtotal"] / $itemsPerPage) // ceil arredonda para cima
        );
    }

    public function addProduct(Product $product){

      $sql = new Sql();
      $sql->query(
        "INSERT
        INTO tb_productscategories
        (idcategory, idproduct)
        VALUES (:idcategory, :idproduct)",
        array(
          ':idcategory' => $this->getidcategory(),
          ':idproduct' => $product->getidproduct()
        )
      );
    }

    public function removeProduct(Product $product){

      $sql = new Sql();
      $sql->query(
        "DELETE
        FROM tb_productscategories
         WHERE idcategory = :idcategory
         AND idproduct = :idproduct",
        array(
          ':idcategory' => $this->getidcategory(),
          ':idproduct' => $product->getidproduct()
        )
      );
    }

}

?>
