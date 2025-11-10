<?php

namespace mf\Init;


abstract class Bootstrap {
    private $routes;

    abstract protected function initRoutes();

    //Construtor da classe
    public function __construct()
    {
        $this->initRoutes();
        $this->run($this->getUrl());
    }
 
    //Métodos mágicos para setar e pegar valores de propriedades privadas
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

       //Pega a URL atual
    protected function getUrl()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $param = str_replace('/public', '', $url);
        return $param;
    }

    //Roda a aplicação
    protected function run($url)
    { 

        $rotaEncontrada = false;

        foreach ($this->routes as $key => $route) {

            if ($url == $route['route']) {
              
                //Define a classe e o método a serem chamados
                $class = "app\\controllers\\" . $route['pasta']."\\". ucfirst($route['controller']);
                
                $controller = new $class;

                //Chama o método
                $action = $route['action'];
                $controller->$action();

                $rotaEncontrada = true;
                break;
            }
        }

        if (!$rotaEncontrada) {


            $class = "app\\controllers\\" . $this->routes['notFound']['controller'];
            $controller = new $class;

            //Chama o método
            $action = $this->routes['notFound']['action'];
            $controller->$action();

        }
    }

}      