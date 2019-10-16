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
                :endereco,
                :numero_endereco,
                :compl_endereco,
                :email_contato,
                :facebook,
                :twitter,
                :whatsapp,
                :descr_empresa,
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
                    ":endereco" => $this->getendereco(),
                    ':numero_endereco' => $this->getnumero_endereco(),
                    ':compl_endereco' => $this->getcompl_endereco(),
                    ':email_contato' => $this->getemail_contato(),
                    ':facebook' => $this->getfacebook(),
                    ':twitter' => $this->gettwitter(),
                    ':whatsapp' => $this->getwhatsapp(),
                    ':descr_empresa' => $this->getdescr_empresa(),
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

    public function setPhoto($file){
        $base64 = getImgBase64($file, 'logo' . $this->getidparamsempresa());
        $this->setlogo($base64);

    }

    public function getField($campo){
        switch ($campo) {
            case "logo": 
              $campo = $this->getlogo();
              break;
            case "descr_empresa": 
              $campo = $this->getdescr_empresa();
              break;
            case "razao_social": 
              $campo = $this->getrazao_social();
              break;
            case "nome_fantasia": 
              $campo = $this->getnome_fantasia();
              break;
            case "facebook": 
              $campo = $this->getfacebook();
              break;
            case "twitter": 
              $campo = $this->gettwitter();
              break;
            case "whatsapp": 
              $campo = $this->getwhatsapp();
              break;
            case "cnpj": 
              $campo = $this->getcnpj();
              break;
            case "email_contato": 
              $campo = $this->getemail_contato();
              break;
            case "inscr_estadual": 
              $campo = $this->getinscr_estadual();
              break;
            case "inscr_municipal": 
              $campo = $this->getinscr_municipal();
              break;
            case "site": 
              $campo = $this->getsite();
              break;
            case "endereco": 
              $campo = $this->getendereco();
              break;
            case "numero_endereco": 
              $campo = $this->getnumero_endereco();
              break;
            case "compl_endereco": 
              $campo = $this->getcompl_endereco();
              break;
        }
        return $campo;
    }

}

?>