<?php

namespace mf\Controller;

use app\models\Categorias;
use mf\Model\Container;

abstract class ActionBlog
{

    protected $view;

    public function __construct()
    {
        $this->view = new \stdClass();
    }

    protected function render($view)
    {   
       $categorias = Container::getModel('Categorias');
       $this->view->categorias = $categorias->listarCategorias();
       $this->view->page = $view;
       require_once "app/views/layouts/layout3.phtml";
    }

    protected function content()
    {
        $class = get_class($this);
        $class = str_replace('app\\controllers\\', '', $class);
        $class = strtolower(str_replace('Controller', '', $class));
        $class = explode('\\', $class);
        $class = $class[1];
        require_once "app/views/{$class}/{$this->view->page}.phtml";
    }
}
