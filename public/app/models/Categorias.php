<?php

namespace app\models;

use mf\Model\Model;

class Categorias extends Model
{
    private $id;
    private $nome;
    private $slug;
    private $descricao;
    private $status;
    private $created_at;
    private $pagina;
    private $limite;

    // Getters and Setters
    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    // Métodos para interagir com o banco de dados

    public function NovaCategoria()
    {
        $query = "INSERT INTO tb_categorias (nome, slug, descricao, status, created_at) 
                  VALUES (:nome, :slug, :descricao, :status, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':slug', $this->__get('slug'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':status', $this->__get('status'));

        return $stmt->execute();
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
        $query = "SELECT p.id, p.categoria_id, p.titulo, p.slug, p.resumo, p.imagem, c.nome AS categoria_nome
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

        //conta todos os registros da categoria (para paginação)
        $queryCount = "SELECT COUNT(*) AS total
               FROM tb_posts AS p
               INNER JOIN tb_categorias AS c ON c.id = p.categoria_id
               WHERE c.slug = :slug
               AND p.status = 'publicado'";
        $stmtCount = $this->db->prepare($queryCount);
        $stmtCount->bindValue(':slug', $this->__get('slug'));
        $stmtCount->execute();
        $total = (int) $stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];


        // total de resultados da categoria
        $query = "SELECT 
                p.id,
                p.titulo,
                p.slug,
                p.resumo,
                p.imagem,
                p.created_at,
                c.nome AS categoria_nome
                FROM tb_posts AS p
                INNER JOIN tb_categorias AS c ON c.id = p.categoria_id
                WHERE c.slug = :slug
                    AND p.status = 'publicado'
                ORDER BY p.created_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':slug', $this->__get('slug'));
        $stmt->bindValue(':limit', $limite, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return [
            'data' => $dados,
            'total' => $total,
            'pagina' => $pagina,
            'limite' => $limite,
            'paginas' => ($total > 0) ? ceil($total / $limite) : 0
        ];
    }
}
