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


    // Page para criar novo post
    public function novoPost()
    {
        $this->view->categorias = $this->categoria->listarCategorias();
        $this->render('novo-post');
    }

    // Criar Post
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

        if($this->post->novoPost()){
            echo "sucesso";
        } else {
            echo "erro";
        }
    }

    // Page para editar post
    public function editarPost()
    {
        $this->post->__set('id', $_GET['id']);
        
        $this->view->post = $this->post->getPostById();
        $this->view->categorias = $this->categoria->listarCategorias();

        $this->render('edit-post');
    }

    // Salvar Post Editado
    public function update()
    {
       $this->post->__set('id', $_POST['id']);  
       $this->post->__set('categoria_id', $_POST['categorias']);  
       $this->post->__set('titulo', $_POST['titulo']);
       $this->post->__set('slug', $_POST['slug']);
       $this->post->__set('status', $_POST['status']);
       $this->post->__set('resumo', $_POST['resumo']);
       $this->post->__set('conteudo', $_POST['conteudo']);
         if(!empty($_FILES['imagem_capa']['name'])){
              $caminho =$this->post->UploadImagem($_FILES['imagem_capa']);
              $this->post->__set('caminho_imagem', $caminho);
         }

       if($this->post->atualizarPost()){
            echo "sucesso";
        } else {
            echo "erro";
        }
    }

    public function deletePost()
    {
        $this->post->__set('id', $_GET['id']);
        $this->view->post = $this->post->getPostById();
        $this->render('delete-post');
    }
 
    public function delete()
    {
        //receber em json o id do post a ser deletado
        $dados = file_get_contents("php://input");
        $dados = json_decode($dados, true); 

        $this->post->__set('id', $dados['id']);  

        if($this->post->deletarPost()){
            echo "sucesso";
        } else {
            echo "erro";
        }
    }
   
}

