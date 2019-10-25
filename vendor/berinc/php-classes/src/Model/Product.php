<?php

namespace Berinc\Model;

use \Berinc\DB\Sql;
use \Berinc\Model;

class Product extends Model{

    public static function listAll(){
      
      $sql = new Sql();

      return $sql->select(
          "SELECT *
          FROM tb_products
          WHERE active='V'
          ORDER BY desproduct"
      );
    }

    public static function listSlider(){
      
      $sql = new Sql();

      return $sql->select(
          "SELECT *
          FROM tb_products
          WHERE in_slider='V'
            AND active='V'
          ORDER BY desproduct"
      );
    }

    public static function checkList($list){

      foreach ($list as &$row) {
          $p = new Product();
          $p->setData($row);
          $row = $p->getValues();
      }

      return $list;
    }

    public function get($idproduct){
        $sql = new Sql();
        $results = $sql->select(
             "SELECT *
             FROM tb_products
             WHERE idproduct = :idproduct
             AND active='V'",
             array(
               ":idproduct" => $idproduct
             )
        );
       
        if(count($results) === 0){
            throw new \Exception("Categoria não encontrada");
        }else {
          
          foreach($results as &$row){
            $row['desproduct'] = utf8_encode($row['desproduct']);
            $row['desurl'] = utf8_encode($row['desurl']);
            $row['descr_produto'] = utf8_encode($row['descr_produto']);
            $p = new Product();          
            $p->setData($row);
            $row = $p->getValues();
          }          
          $this->setData($results[0]);
        }
    }

    public function save(){

    		$sql = new Sql();

    		$results = $sql->select(
    			"CALL sp_products_save(
    				:idproduct,
    				:desproduct,
    				:vlprice,
    				:vlwidth,
    				:vlheight,
    				:vllength,
    				:vlweight,
            :desurl,
            :in_slider,
            :imagem_principal,
            :descr_produto,
            :imagem_2,
            :imagem_3)",
    				array(
    					":idproduct" => $this->getidproduct(),
    					":desproduct" => utf8_decode($this->getdesproduct()),
    					":vlprice" => $this->getvlprice(),
    					":vlwidth" => $this->getvlwidth(),
    					":vlheight" => $this->getvlheight(),
    					":vllength" => $this->getvllength(),
    					":vlweight" => $this->getvlweight(),
              ":desurl" => utf8_decode($this->getdesurl()),
              ":in_slider" => $this->getin_slider(),
              ":imagem_principal" => $this->getimagem_principal(),
              ":descr_produto" => utf8_decode($this->getdescr_produto()),              
              ":imagem_2" => $this->getimagem_2(),
              ":imagem_3" => $this->getimagem_3()
    				)
    			);

    		$this->setData($results[0]);

  	}

    public function delete(){

          $sql = new Sql();

          $sql->query(
            "UPDATE tb_products
            SET active='F'
            WHERE idproduct = :idproduct",
            array(
              ":idproduct" => $this->getidproduct()
            )
          );

    }

    public function checkPhoto(){

    		if (file_exists(
      			$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
      			"res" . DIRECTORY_SEPARATOR .
      			"site" . DIRECTORY_SEPARATOR .
      			"img" . DIRECTORY_SEPARATOR .
      			"products" . DIRECTORY_SEPARATOR .
      			$this->getidproduct() . ".jpg"
      			)) {
    			       $url = "/res/site/img/products/" . $this->getidproduct() . ".jpg";
    		} else {
    			   $url = "/res/site/img/product.jpg";
    		}

    		return $this->setdesphoto($url);

	  }

    public function getValues(){
    		  //  $this->checkPhoto();
    		    $values = parent::getValues();
    		    return $values;
    }


   /* public function setPhoto($file){

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

        		$dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
        			"res" . DIRECTORY_SEPARATOR .
        			"site" . DIRECTORY_SEPARATOR .
        			"img" . DIRECTORY_SEPARATOR .
        			"products" . DIRECTORY_SEPARATOR .
        			$this->getidproduct() . ".jpg";

        		imagejpeg($image, $dist);

        		imagedestroy($image);

        		$this->checkPhoto();

  }*/
  
  public function setPhoto($file, $numImagem = 1){
      $base64 = getImgBase64($file, 'fotoprod' . $this->getiproduct() . $numImagem);
      if ($numImagem === 1){
        $this->setimagem_principal($base64);
      }else if ($numImagem === 2){
        $this->setimagem_2($base64);
      }else{
        $this->setimagem_3($base64);
      }

  }

  public function getFromURL($desurl){

      $sql = new Sql();

      $result = $sql->select(
        "SELECT *
        FROM tb_products
        WHERE desurl = :desurl
        AND active='V'
        LIMIT 1",
        array(
          ':desurl' => $desurl
        )
      );

      $this->setData($result[0]);

  }

  public function getCategoies(){

      $sql = new Sql();

      return $sql->select(
        "SELECT *
        FROM tb_categories a
        INNER JOIN tb_productscategories b ON a.idcategory = b.idcategory
        WHERE b.idproduct = :idproduct",
        array(
          ':idproduct' => $this->getidproduct()
        )
      );
  }

  public static function getPage($page = 1, $itemsPerPage = 10){
      $start = ($page -1) * $itemsPerPage;

      $sql = new Sql();

      $results = $sql->select(
          "SELECT SQL_CALC_FOUND_ROWS *
          FROM tb_products
          WHERE active='V'
          order by desproduct
          LIMIT $start, $itemsPerPage;"
      );

      $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");
      foreach($results as &$row){
        $row['desproduct'] = utf8_encode($row['desproduct']);
        $row['desurl'] = utf8_encode($row['desurl']);
        $row['descr_produto'] = utf8_encode($row['descr_produto']);
        $p = new Product();          
        $p->setData($row);
        $row = $p->getValues();
      }     
      return array(
          'data' => $results,
          'total' => (int)$resultTotal[0]["nrtotal"],
          'pages' => ceil($resultTotal[0]["nrtotal"] / $itemsPerPage) // ceil arredonda para cima
      );
  }

  public static function getPageSearch($search, $page = 1, $itemsPerPage = 10){
      $start = ($page -1) * $itemsPerPage;

      $sql = new Sql();

      $results = $sql->select(
          "SELECT SQL_CALC_FOUND_ROWS *
          FROM tb_products
          WHERE desproduct LIKE :search
          AND active='V'
          ORDER BY desproduct
          LIMIT $start, $itemsPerPage;",
          array(
              ':search' => '%' . $search . '%'
          )
      );

      $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");
      foreach($results as &$row){
        $row['desproduct'] = utf8_encode($row['desproduct']);
        $row['desurl'] = utf8_encode($row['desurl']);
        $row['descr_produto'] = utf8_encode($row['descr_produto']);
        $p = new Product();          
        $p->setData($row);
        $row = $p->getValues();
      }     
      return array(
          'data' => $results,
          'total' => (int)$resultTotal[0]["nrtotal"],
          'pages' => ceil($resultTotal[0]["nrtotal"] / $itemsPerPage) // ceil arredonda para cima
      );
  }


}

?>
