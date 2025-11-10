<?php

namespace app\models;

use mf\Model\Model;

class Categorias extends Model
{
    private $id;
    private $nome;
    private $slug;
    private $descricao;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    public function listarCategorias()
    {

        $query = "SELECT id, nome, slug, descricao FROM tb_categorias ORDER BY nome ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function categoriaDestaque()
    {

        $query = "SELECT p.id, p.categoria_id, p.titulo, p.slug, p.resumo, p.imagem
            FROM tb_posts AS p
            INNER JOIN tb_categorias AS c 
                ON p.categoria_id = c.id
            WHERE p.destaque_categoria = 1
            AND p.status = 'publicado'
            AND c.slug = :slug
            ORDER BY p.created_at DESC
            LIMIT 3";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':slug', $this->__get('slug'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function postCategoria()
    {

        $query = "SELECT p.*, c.nome FROM tb_posts AS p
                  INNER JOIN tb_categorias AS c ON (p.categoria_id = c.id)
                  WHERE c.slug = :slug AND p.status = 'publicado' AND p.destaque_categoria = 0
                  ORDER BY p.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':slug', $this->__get('slug'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
