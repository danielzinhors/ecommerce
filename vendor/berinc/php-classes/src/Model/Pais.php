<?php

namespace Berinc\Model;

use \Berinc\DB\Sql;
use \Berinc\Model;

class Pais extends Model{
  
  public static function listAll(){

      $sql = new Sql();

      return $sql->select(
          "SELECT *
          FROM tb_pais
          order by nome_pais"
      );
    }

    public function get($idpais){
        $sql = new Sql();
        $results = $sql->select(
             "SELECT *
             FROM tb_pais
             WHERE id_pais = :id_pais",
             array(
               ":id_pais" => $idpais
             )
        );

        if(count($results) === 0){
            throw new \Exception("Pais não encontrado");
        }else {
          $data = $results[0];
          $data['nome_pais'] = utf8_encode($data['nome_pais']);
          $this->setData($data);
        }
    }

    public function save(){
      $sql = new Sql();
      $results = $sql->select(
          "CALL sp_pais_save(
            :id_pais,
            :nome_pais,
            :active
            )",
            array(
                ":id_pais" => $this->getid_pais(),
                ":nome_pais" => utf8_decode($this->getnome_pais()),
                ":active" => "V"
            )
      );

      $this->setData($results[0]);
    }

    public function delete(){

          $sql = new Sql();

          $sql->query(
            "DELETE
            FROM tb_pais
            WHERE id_pais = :id_pais",
            array(
              ":id_pais" => $this->getid_pais()
            )
          );
      }

    public function getEstados(){

        $sql = new Sql();

        return $sql->select(
            "SELECT *
            FROM tb_estado
            WHERE id_pais = :id_pais 
            AND active='V';",
                array(
                  ':id_pais' => $this->getid_pais()
                )
            );

    }

    public static function getPage($page = 1, $itemsPerPage = 10){
        $start = ($page -1) * $itemsPerPage;

        $sql = new Sql();

        $results = $sql->select(
            "SELECT SQL_CALC_FOUND_ROWS *
            FROM tb_pais
            order by nome_pais
            LIMIT $start, $itemsPerPage;"
        );

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");
           
        foreach($results as &$row){
          $row['nome_pais'] = utf8_encode($row['nome_pais']);
          $p = new Pais();          
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
            FROM tb_pais
            WHERE nome_pais LIKE :search
            order by nome_pais
            LIMIT $start, $itemsPerPage;",
            array(
                ':search' => '%' . $search . '%'
            )
        );

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");
        
        foreach($results as &$row){
          $row['nome_pais'] = utf8_encode($row['nome_pais']);
          $p = new Pais();          
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
