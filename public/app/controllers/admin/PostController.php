<?php 

namespace app\controllers\admin;

use mf\Controller\ActionDashboard;
use mf\Model\Container;


class PostController extends ActionDashboard
{
    private $categoria;
    private $post;

    public function __construct()
    {
        parent::__construct();
        $this->categoria = Container::getModel('Categorias');
        $this->post = Container::getModel('Posts');
    }  
    
    public function index()
    {   
        $this->view->totalPosts = $this->post->countPosts();
        $this->view->totalRascunhos = $this->post->countRascunhos();
        $this->view->postsRecentes = $this->post->listarPostsDashboard();
        $this->render('index');
    }

    public function novoPost()
    {
        $this->view->categorias = $this->categoria->listarCategorias();
        $this->render('novo-post');
    }

    public function create()
    {
       $this->post->__set('categoria_id', $_POST['categorias']);  
       $this->post->__set('titulo', $_POST['titulo']);
       $this->post->__set('slug', $_POST['slug']);
       $this->post->__set('status', $_POST['status']);
       $this->post->__set('resumo', $_POST['resumo']);
       $this->post->__set('conteudo', $_POST['conteudo']);
       $caminho =$this->post->UploadImagem($_FILES['imagem_capa']);
       $this->post->__set('caminho_imagem', $caminho);
       $this->post->__set('autor', 'Equipe Arte&Cia');  

        if($this->post->NovoPost()){
            echo "sucesso";
        } else {
            echo "erro";
        }
    }

    public function editarPost()
    {
        $this->post->__set('id', $_GET['id']);
        
        $this->view->post = $this->post->getPostById();
        $this->view->categorias = $this->categoria->listarCategorias();

        $this->render('edit-post');
    }
 
   
}

