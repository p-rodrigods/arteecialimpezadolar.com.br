<?php

namespace app\controllers\admin;

use mf\Controller\ActionDashboard;
use mf\Model\Container;

class CategoriasController extends ActionDashboard
{
    private $categoria;

    public function __construct()
    {
        parent::__construct();
        $this->categoria = Container::getModel('Categorias');
    }

    public function index()
    {
        $this->view->categorias = $this->categoria->listarCategoriasDasboard();
        $this->render('index');
    }

    public function novaCategoria()
    {
        $this->render('nova-categoria');
    }

    public function create()
    {
        $this->categoria->__set('nome', $_POST['nome']);
        $this->categoria->__set('slug', $_POST['slug']);
        $this->categoria->__set('status', $_POST['status']);
        $this->categoria->__set('descricao', $_POST['descricao']);

        if ($this->categoria->novaCategoria()) {
            echo "sucesso";
        } 
    }

    public function editarCategoria(){

        $this->categoria->__set('id', $_GET['id']);
        $this->view->categoria = $this->categoria->getCategoriaById();
        $this->render('edit-categoria');

    }

    public function update(){

        $this->categoria->__set('id', $_POST['id']);
        $this->categoria->__set('nome', $_POST['nome']);
        $this->categoria->__set('slug', $_POST['slug']);
        $this->categoria->__set('status', $_POST['status']);
        $this->categoria->__set('descricao', $_POST['descricao']);

        if($this->categoria->atualizarCategoria()){
            echo "sucesso";
        } else {
            echo "erro";
        }
    }

    public function deleteCategoria(){
        $this->categoria->__set('id', $_GET['id']);
        $this->view->categoria = $this->categoria->getCategoriaById();
        $this->render('delete-categoria');
    }

    public function delete(){
         //receber em json o id do post a ser deletado
        $dados = file_get_contents("php://input");
        $dados = json_decode($dados, true); 

        $this->categoria->__set('id', $dados['id']);

        if($this->categoria->deleteCategoria()){
            echo "sucesso";
        } else {
            echo "erro";
        }
    }
}
