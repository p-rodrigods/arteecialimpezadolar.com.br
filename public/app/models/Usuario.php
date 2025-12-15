<?php 

namespace app\models;

use mf\Model\Model;

class Usuario extends Model
{
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    public function autenticar()
    {
        $query = "SELECT id, nome, email FROM tb_usuarios WHERE email = :email AND senha = :senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($usuario) {
            $this->id = $usuario['id'];
            $this->nome = $usuario['nome'];
            $this->nivel_acesso = $usuario['nivel_acesso'];
            return true;
        } else {
            return false;
        }
    }
    
}
