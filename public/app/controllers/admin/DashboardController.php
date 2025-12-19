<?php

namespace app\controllers\admin;

use mf\Controller\ActionDashboard;
use mf\Model\Container;


class DashboardController extends ActionDashboard
{
    public function index()
    {   
        session_start();
        $this->view->dadosUsuario = $_SESSION['usuario'];
        $this->render('index');
    }


    public function posts()
    {
        /*session_start();
        $this->view->dadosUsuario = $_SESSION['usuario'];

        //Recupera todos os posts do banco de dados
        $post = Container::getModel('Post');
        $this->view->posts = $post->getAllPosts();*/

        $this->render('posts');
    }
}
