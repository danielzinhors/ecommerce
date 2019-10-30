<?php

namespace Berinc\Model;

use \Berinc\DB\Sql;
use \Berinc\Model;

class Estado extends Model{
  
  public static function listAll(){

      $sql = new Sql();

      return $sql->select(
          "SELECT *
          FROM tb_estado
          INNER JOIN tb_pais USING (id_pais)
          ORDER BY id_pais, nome_estado"
      );
    }

    public function get($idestado){
        $sql = new Sql();
        $results = $sql->select(
             "SELECT *
             FROM tb_estado
             INNER JOIN tb_pais USING (id_pais)
             WHERE id_estado = :id_estado",
             array(
               ":id_estado" => $idestado
             )
        );

        if(count($results) === 0){
            throw new \Exception("Estado não encontrado");
        }else {
          $data = $results[0];
          $data['nome_pais'] = utf8_encode($data['nome_pais']);
          $this->setData($data);
        }
    }

    public function save(){
      $sql = new Sql();
      
      $results = $sql->select(
          "CALL sp_estado_save(
            :id_estado,
            :nome_estado,
            :id_pais,
            :active
            )",
            array(
                ":id_estado" => $this->getid_estado(),
                ":nome_estado" => utf8_decode($this->getnome_estado()),
                ":id_pais" => $this->getid_pais(),
                ":active" => 'V'
            )
      );

      $this->setData($results[0]);
    }

    public function delete(){

          $sql = new Sql();

          $sql->query(
            "DELETE
            FROM tb_estado
            WHERE id_estado = :id_estado",
            array(
              ":id_estado" => $this->getid_estado()
            )
          );
      }

    public function getCidades(){

        $sql = new Sql();

        return $sql->select(
            "SELECT *
            FROM tb_cidade
            WHERE id_estado = :id_estado 
            AND active='V';",
                array(
                  ':id_estado' => $this->getid_estado()
                )
            );

    }

    public static function getPage($page = 1, $itemsPerPage = 10){
        $start = ($page -1) * $itemsPerPage;

        $sql = new Sql();

        $results = $sql->select(
            "SELECT SQL_CALC_FOUND_ROWS *
            FROM tb_estado
            INNER JOIN tb_pais USING (id_pais)
            ORDER BY id_pais, nome_estado
            LIMIT $start, $itemsPerPage;"
        );

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");
           
        foreach($results as &$row){
          $row['nome_estado'] = utf8_encode($row['nome_estado']);
          $p = new Estado();          
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
            FROM tb_estado
            WHERE nome_estado LIKE :search
            INNER JOIN tb_pais USING (id_pais)
            ORDER BY id_pais, nome_estado
            LIMIT $start, $itemsPerPage;",
            array(
                ':search' => '%' . $search . '%'
            )
        );

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");
        
        foreach($results as &$row){
          $row['nome_estado'] = utf8_encode($row['nome_estado']);
          $p = new Estado();          
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
