<?php

namespace app\models;

use mf\Model\Model;

class Categorias extends Model
{
    private $id;
    private $nome;
    private $slug;
    private $descricao;
    private $pagina;
    private $limite;

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

        $pagina = (int) $this->__get('pagina') ?: 1;
        $limite = (int) $this->__get('limite') ?: 10;
        $offset = ($pagina - 1) * $limite;

        // total de resultados da caegoria
        $queryCount = "SELECT COUNT(*) AS total
            FROM tb_posts AS p
            INNER JOIN tb_categorias AS c ON p.categoria_id = c.id
            WHERE p.status = 'publicado'
            AND (p.titulo LIKE :busca OR p.conteudo LIKE :busca OR p.resumo LIKE :busca)";
        $stmtCount = $this->db->prepare($queryCount);
        $stmtCount->bindValue(':busca', '%' . $this->__get('busca') . '%');
        $stmtCount->execute();
        $total = (int) $stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];


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
