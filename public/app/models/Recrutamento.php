<?php 

namespace app\models;

use mf\Model\Model;

class Recrutamento extends Model{
    private $id;
    private $nome;
    private $email;
    private $contato;
    private $caminho_arquivo;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr, $value){
        $this->$attr = $value;
    }

    public function cadastrar(){

        $query = "INSERT INTO tb_recrutamento(
          nome, email, contato, caminho_arquivo
        ) VALUES (
            :nome, :email, :contato, :caminho_arquivo
        )";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':contato', $this->__get('contato'));
        $stmt->bindValue(':caminho_arquivo', $this->__get('caminho_arquivo'));
        $stmt->execute();

        return $this;
    }

    public function uploadArquivo($arquivo){

         if(isset($arquivo) && $arquivo['error'] === UPLOAD_ERR_OK){
            $arquivoTmp = $arquivo['tmp_name'];
            $nomeArquivo = basename($arquivo['name']);

            $pastaDestino = "uploads/curriculos/";
            if(!is_dir($pastaDestino)){
                mkdir($pastaDestino, 0777, true);
            }

            $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
            $novoNome = uniqid("curriculo_") . "." . $extensao;
            $caminhoFinal = $pastaDestino . $novoNome;

            if(move_uploaded_file($arquivoTmp, $caminhoFinal)){
               return $caminhoFinal;
            }
        }

    }
}   