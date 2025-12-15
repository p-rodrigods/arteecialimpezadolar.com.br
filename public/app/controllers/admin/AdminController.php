<?php

namespace app\controllers\admin;

use mf\Controller\ActionAdmin;
use mf\Model\Container;

class AdminController extends ActionAdmin
{
    private $usuario;

    public function __construct()
    {
        parent::__construct();
        $this->usuario = Container::getModel('Usuario');
    }

    public function index()
    {
        //$this->view->dadosUsuario = $_SESSION['usuario'];
        $this->render('index');

    }

    public function logout()
    {
        session_destroy();
        header("Location: /");
    }  
    
    public function authenticate(){

       // Receber os dados do Formuláros
       $this->usuario->__set('email', $_POST['usuario']);
       $this->usuario->__set('senha', $_POST['senha']);
    
       if($this->usuario->autenticar()){
             $_SESSION['usuario'] = $this->usuario;
             echo "success";
             return;
         } 
    }
    

}

?>