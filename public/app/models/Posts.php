<?php

namespace app\models;

use mf\Model\Model;

class Posts extends Model
{
    private $id;
    private $categoria_id;
    private $titulo;
    private $slug;
    private $resumo;
    private $conteudo;
    private $imagem;
    private $autor;
    private $status;
    private $data_criacao;
    private $busca;
    private $pagina;
    private $limite;
    private $caminho_imagem;

    // Getters e Setters
    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    // Métodos específicos
    public function destaques()
    {
        $query = "SELECT id, categoria_id, titulo, slug, resumo, imagem FROM tb_posts WHERE destaque_principal = 1 AND status = 'publicado' ORDER BY created_at DESC LIMIT 3";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Método para obter post selecionado pelo slug
    public function postSelecionado()
    {

        $query = "SELECT * FROM tb_posts WHERE slug = :slug AND status = 'publicado'";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':slug', $this->__get('slug'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Método para listar todos os posts com paginação
    public function listarTodos()
    {
        $pagina = (int) $this->__get('pagina') ?: 1;
        $limite = (int) $this->__get('limite') ?: 10;
        $offset = ($pagina - 1) * $limite;

        // total de registros (para paginação)
        $queryCount = "SELECT COUNT(*) AS total
            FROM tb_posts AS p
            INNER JOIN tb_categorias AS c ON p.categoria_id = c.id
            WHERE p.status = 'publicado' AND p.destaque_principal = 0";
        $stmtCount = $this->db->prepare($queryCount);
        $stmtCount->execute();
        $total = (int) $stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];

        // resultados paginados
        $query = "SELECT 
                    p.id,
                    p.titulo,
                    p.slug,
                    p.resumo,
                    p.imagem,
                    p.autor,
                    p.created_at,
                    p.destaque_principal,
                    c.nome AS categoria
                  FROM tb_posts AS p
                  INNER JOIN tb_categorias AS c ON p.categoria_id = c.id
                  WHERE p.status = 'publicado' AND p.destaque_principal = 0
                  ORDER BY p.created_at DESC
                  LIMIT :limite OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limite', $limite, \PDO::PARAM_INT);
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

    // Método para pesquisa de posts
    public function pesquisa(){
         
        $pagina = (int) $this->__get('pagina') ?: 1;
        $limite = (int) $this->__get('limite') ?: 10;
        $offset = ($pagina - 1) * $limite;

        // total de resultados da busca
        $queryCount = "SELECT COUNT(*) AS total
            FROM tb_posts AS p
            INNER JOIN tb_categorias AS c ON p.categoria_id = c.id
            WHERE p.status = 'publicado'
            AND (p.titulo LIKE :busca OR p.conteudo LIKE :busca OR p.resumo LIKE :busca)";
        $stmtCount = $this->db->prepare($queryCount);
        $stmtCount->bindValue(':busca', '%' . $this->__get('busca') . '%');
        $stmtCount->execute();
        $total = (int) $stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];

        // resultados paginados (mantém a ordenação por relevância e data)
        $query = "SELECT 
                p.id,
                p.titulo,
                p.slug,
                p.resumo,
                p.imagem,
                p.autor,
                p.conteudo,
                p.created_at,
                c.nome AS categoria,
                (
                    (CASE WHEN p.titulo LIKE :busca THEN 3 ELSE 0 END) +
                    (CASE WHEN p.resumo LIKE :busca THEN 2 ELSE 0 END) +
                    (CASE WHEN p.conteudo LIKE :busca THEN 1 ELSE 0 END)
                ) AS relevancia
            FROM tb_posts AS p
            INNER JOIN tb_categorias AS c ON p.categoria_id = c.id
            WHERE p.status = 'publicado'
            AND (p.titulo LIKE :busca OR p.conteudo LIKE :busca OR p.resumo LIKE :busca)
            ORDER BY relevancia DESC, p.created_at DESC
            LIMIT :limite OFFSET :offset
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':busca', '%' . $this->__get('busca') . '%');
        $stmt->bindValue(':limite', $limite, \PDO::PARAM_INT);
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

    // Método para calcular o tempo de leitura de um post
    public function tempoLeitura() {
        $res = $this->pesquisa();
        $texto = '';

        $items = $res['data'] ?? [];

        // If 'data' is a numerically indexed array of posts
        if (isset($items[0]) && is_array($items[0])) {
            foreach ($items as $item) {
                $texto .= ($item['conteudo'] ?? '') . ' ';
            }
        }
        // If 'data' is a single associative post
        elseif (is_array($items)) {
            $texto .= ($items['conteudo'] ?? '') . ' ';
            $texto .= ($items['conteudo1'] ?? '') . ' ';
            $texto .= ($items['conteudo2'] ?? '') . ' ';
            $texto .= ($items['conteudo3'] ?? '') . ' ';
            $texto .= ($items['conteudo4'] ?? '') . ' ';
        }

        $palavras = str_word_count(strip_tags($texto));
        $tempo = ($palavras > 0) ? (int) ceil($palavras / 200) : 0; // Considerando uma média de 200 palavras por minuto
        return $tempo;
    }

    // Método para cadastrar um novo post
    public function NovoPost()
    {
        $query = "INSERT INTO tb_posts(categoria_id, titulo, slug, resumo, conteudo, imagem, autor, status, created_at) VALUES (:categoria, :titulo, :slug, :resumo, :conteudo, :imagem, :autor, :status, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':categoria', $this->__get('categoria_id'));
        $stmt->bindValue(':titulo', $this->__get('titulo'));
        $stmt->bindValue(':slug', $this->__get('slug'));
        $stmt->bindValue(':resumo', $this->__get('resumo'));
        $stmt->bindValue(':conteudo', $this->__get('conteudo'));
        $stmt->bindValue(':imagem', $this->__get('caminho_imagem'));
        $stmt->bindValue(':autor', $this->__get('autor'));
        $stmt->bindValue(':status', $this->__get('status'));

        $stmt->execute();

        return $this;
    }

    // Método para upload de imagem
    public function UploadImagem($imagem)
    {
        // Lógica para upload de imagem
        if (isset($imagem) && $imagem['error'] === UPLOAD_ERR_OK) {
            $arquivoTmp = $imagem['tmp_name'];
            $nomeArquivo = basename($imagem['name']);

            $pastaDestino = "resources/uploads/posts/";
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0777, true);
            }

            $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
            $novoNome = uniqid("post_") . "." . $extensao;
            $caminhoFinal = $pastaDestino . $novoNome;

            if (move_uploaded_file($arquivoTmp, $caminhoFinal)) {
                return $caminhoFinal;
            }
        }
    }
}
