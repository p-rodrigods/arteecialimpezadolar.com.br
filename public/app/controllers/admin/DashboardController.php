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
}
