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
      require_once __DIR__ . "/../../../app/views/layouts/index.phtml";
    }

    protected function content()
    {
        $class = get_class($this);

        //Remove o namespace e o sufixo Controller
        $class = str_replace('app\\controllers\\', '', $class);
        $class = strtolower(str_replace('Controller', '', $class));
        $class = explode('\\', $class);;
        
        $class = $class[0];

        require_once __DIR__ . "/../../../app/views/{$class}/{$this->view->page}.phtml";
    }
}
