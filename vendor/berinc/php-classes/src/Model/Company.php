<?php

namespace Berinc\Model;

use \Berinc\DB\Sql;
use \Berinc\Model;

class Company extends Model{

  	public static function listAll(){
        
        $sql = new Sql();

        return $sql->select(
        "SELECT *
        FROM tb_params_empresa
        ORDER BY idparamsempresa");

    }
      
    public function save(){

        $sql = new Sql();

        $results = $sql->select(
            "CALL sp_params_empresa_save(
                :idparamsempresa,
                :razao_social,
                :nome_fantasia,
                :cnpj,
                :site,
                :idcontaemail,
                :inscr_estadual,
                :inscr_municipal,
                :idaddresses,
                :logo)",
                array(
                    ":idparamsempresa" => $this->getidparamsempresa(),
                    ":razao_social" => $this->getrazao_social(),
                    ":nome_fantasia" => $this->getnome_fantasia(),
                    ":cnpj" => $this->getcnpj(),
                    ":site" => $this->getsite(),
                    ":idcontaemail" => $this->getidcontaemail(),
                    ":inscr_estadual" => $this->getinscr_estadual(),
                    ":inscr_municipal" => $this->getinscr_municipal(),
                    ":idaddresses" => $this->getidaddresses(),
                    ":logo" => $this->getlogo()
                )
            );

        $this->setData($results[0]);

    }

    public function delete(){

        $sql = new Sql();

        $sql->query(
          "DELETE
          FROM tb_params_empresa
          WHERE idparamsempresa = :idparamsempresa",
          array(
            ":idparamsempresa" => $this->getidparamsempresa()
          )
        );
    }

    public static function getPage($page = 1, $itemsPerPage = 10){
        $start = ($page -1) * $itemsPerPage;
  
        $sql = new Sql();
        
        $results = $sql->select(
            "SELECT SQL_CALC_FOUND_ROWS *
            FROM tb_params_empresa
            order by idparamsempresa
            LIMIT $start, $itemsPerPage;"
        );
        
        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");
  
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
            FROM tb_params_empresa
            WHERE nome_fantasia LIKE :search
            order by idparamsempresa
            LIMIT $start, $itemsPerPage;",
            array(
                ':search' => '%' . $search . '%'
            )
        );
  
        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");
  
        return array(
            'data' => $results,
            'total' => (int)$resultTotal[0]["nrtotal"],
            'pages' => ceil($resultTotal[0]["nrtotal"] / $itemsPerPage) // ceil arredonda para cima
        );
    }

    public function get($idparamsempresa){
        $sql = new Sql();
        $results = $sql->select(
             "SELECT *
             FROM tb_params_empresa
             WHERE idparamsempresa = :idparamsempresa",
             array(
               ":idparamsempresa" => $idparamsempresa
             )
        );

        if(count($results) === 0){
            throw new \Exception("Empresa não encontrada");
        }else {
          $this->setData($results[0]);
        }
    }

}

?>