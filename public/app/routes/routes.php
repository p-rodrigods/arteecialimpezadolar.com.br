<?php 

namespace app\routes;

class Routes {

    private $routes = [];

    public function add($nome, $route, $pasta, $controller, $action){
        $this->routes[$nome] = array(
            'route' => $route,
            'pasta' => $pasta,
            'controller' => $controller,
            'action' => $action
        );
    }

    public function getRoutes(){
        return $this->routes;
    }

}


