<?php

namespace app\controllers\blog;

use mf\Controller\ActionBlog;
use mf\Model\Container;

class BlogController extends ActionBlog
{

    public function index()
    {
        $post = Container::getModel('Posts');
        $categoria = Container::getModel('Categorias');

        if (isset($_GET['post'])) {

            $post->__set('slug', $_GET['post']);
            $this->view->postSelecionado = $post->postSelecionado()[0] ?? null;
            $this->render('posts');
            
        } else if(isset($_GET['categoria'])) {

            $categoria->__set('slug', $_GET['categoria']);

            if (isset($_GET['p'])) {
                $categoria->__set('pagina', $_GET['p']);
            }
            
            $this->view->categoriaSlug = $categoria->__get('slug');
            $this->view->destaqueCategoria = $categoria->categoriaDestaque()[0] ?? null;
            $this->view->postsCategoria = $categoria->postCategoria();

            $this->render('categorias');

        } else {

            if (isset($_GET['p'])) {
                $post->__set('pagina', $_GET['p']);
            }

            $this->view->destaque = $post->destaques()[0] ?? null;
            $this->view->listarTodos = $post->listarTodos();
            $this->render('index');
        }
    }

    public function buscar()  
    {
        $buscar = Container::getModel('Posts');

        $buscar->__set('busca', $_GET['s']);

        if (isset($_GET['p'])) {
            $buscar->__set('pagina', $_GET['p']);
        }

        $this->view->busca = $buscar->__get('busca');
        $this->view->pesquisa = $buscar->pesquisa();

        if (isset($this->view->pesquisa['data'])) {
            $this->view->tempoLeitura = $buscar->tempoLeitura();
        }

        $this->render('buscar');
    }
}
