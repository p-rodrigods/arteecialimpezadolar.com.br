<?php

namespace app\controllers\admin;

use mf\Controller\ActionDashboard;
use mf\Model\Container;


class DashboardController extends ActionDashboard
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

}
