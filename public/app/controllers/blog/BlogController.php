<?php

namespace app\controllers\blog;

use mf\Controller\ActionBlog;
use mf\Model\Container;

class BlogController extends ActionBlog
{

    private $post;
    private $categoria;

    public function __construct()
    {
        parent::__construct();
        $this->post = Container::getModel('Posts');
        $this->categoria = Container::getModel('Categorias');
    }

    public function index()
    {
       
        if (isset($_GET['post'])) {

            $this->post->__set('slug', $_GET['post']);
            $this->view->postSelecionado = $this->post->postSelecionado()[0] ?? null;
            $this->render('posts');
            
        } else if(isset($_GET['categoria'])) {

            $this->categoria->__set('slug', $_GET['categoria']);

            if (isset($_GET['p'])) {
                $this->categoria->__set('pagina', $_GET['p']);
            }
            
            $this->view->categoriaSlug = $this->categoria->__get('slug');
            $this->view->destaqueCategoria = $this->categoria->categoriaDestaque()[0] ?? null;
            $this->view->postsCategoria = $this->categoria->postCategoria();

            $this->render('categorias');

        } else {

            if (isset($_GET['p'])) {
                $this->post->__set('pagina', $_GET['p']);
            }

            $this->view->destaque = $this->post->destaques()[0] ?? null;
            $this->view->listarTodos = $this->post->listarTodos();
            $this->render('index');
        }
    }

    public function buscar()  
    {
        $this->post->__set('busca', $_GET['s']);

        if (isset($_GET['p'])) {
            $this->post->__set('pagina', $_GET['p']);
        }

        $this->view->busca = $this->post->__get('busca');
        $this->view->pesquisa = $this->post->pesquisa();

        if (isset($this->view->pesquisa['data'])) {
            $this->view->tempoLeitura = $this->post->tempoLeitura();
        }

        $this->render('buscar');
    }
}
