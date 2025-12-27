<?php

namespace app\controllers\admin;

use mf\Controller\ActionDashboard;
use mf\Model\Container;

class CategoriasController extends ActionDashboard{
    private $categoria;

    public function __construct()
    {
        parent::__construct();
        $this->categoria = Container::getModel('Categorias');
    }

    public function index()
    {
        $this->view->categorias = $this->categoria->listarCategorias();
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

        if($this->categoria->NovaCategoria()){
            echo "sucesso";
        } else {
            echo "erro";
        }

        $this->render('create');
    }
}