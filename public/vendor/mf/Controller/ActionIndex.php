<?php

namespace mf\Controller;

abstract class ActionIndex
{

    protected $view;

    public function __construct()
    {
        $this->view = new \stdClass();
    }

    protected function render($view)
    {   
       $this->view->page = $view;
       require_once "app/views/layouts/layout.phtml";
    }

    protected function content()
    {
        $class = get_class($this);

        //Remove o namespace e o sufixo Controller
        $class = str_replace('app\\controllers\\', '', $class);
        $class = strtolower(str_replace('Controller', '', $class));
        $class = explode('\\', $class);
        $class = $class[1];

        require_once "app/views/{$class}/{$this->view->page}.phtml";
    }
}
