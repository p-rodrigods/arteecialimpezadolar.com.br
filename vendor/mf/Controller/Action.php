<?php

namespace mf\Controller;

abstract class Action
{

    protected $view;

    public function __construct()
    {   

        $this->view = new \stdClass();
    }

    protected function render($view)
    {   
       $this->view->page = $view;
       require_once "app/views/layouts/layout2.phtml";
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
