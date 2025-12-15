<?php

namespace app;

use mf\Init\Bootstrap;

class Route extends Bootstrap
{

    //Define as rotas do sistema
    public function initRoutes()
    {
        // Adiciona rota home
        $routes['home'] = array(
            'route' => '/',
            'pasta' => 'site',
            'controller' => 'IndexController',
            'action' => 'index'
        );

        // Adiciona rota agendar
        $routes['agendamento'] = array(
            'route' => '/agendamento',
            'pasta' => 'site',
            'controller' => 'IndexController',
            'action' => 'agendamento'
        );

        // Adiciona rota para insert
        $routes['agendamento-insert'] = array(
            'route' => '/agendamento-insert',
            'pasta' => 'site',
            'controller' => 'IndexController',
            'action' => 'insertAgendamento'
        );

        // Adiciona rota recrutamento
        $routes['recrutamento'] = array(
            'route' => '/recrutamento',
            'pasta' => 'site',
            'controller' => 'IndexController',
            'action' => 'recrutamento'
        );

        // Adiciona rota para cadastrar recrutamento
        $routes['recrutamento-insert'] = array(
            'route' => '/recrutamento-insert',
            'pasta' => 'site',
            'controller' => 'IndexController',
            'action' => 'insertRecrutamento'
        );

        // Adiciona rota recrutamento sucesso
        $routes['recrutamento-sucesso'] = array(
            'route' => '/recrutamento-sucesso',
            'pasta' => 'site',
            'controller' => 'IndexController',
            'action' => 'sucess'
        );

        // Adiciona rota do BLOG
        $routes['blog'] = array(
            'route' => '/blog',
            'pasta' => 'blog',
            'controller' => 'BlogController',
            'action' => 'index'
        );

        // Adiciona rota Buscar
        $routes['buscar'] = array(
            'route' => '/buscar',
            'pasta' => 'blog',
            'controller' => 'BlogController',
            'action' => 'buscar'
        );

        // Adiciona rota Admin
        $routes['admin'] = array(
            'route' => '/admin',
            'pasta' => 'admin',
            'controller' => 'AdminController',
            'action' => 'index'
        );

        // Adiciona rota Admin autenticar
        $routes['admin-authenticate'] = array( 
            'route' => '/admin-authenticate',
            'pasta' => 'admin',
            'controller' => 'AdminController',
            'action' => 'authenticate'
        );

        // Adiciona rota notFound
        $routes['notFound'] = array(
            'route' => '/notFound',
            'controller' => 'NotFoundController',
            'action' => 'notFound'
        );




        return $this->__set('routes', $routes);
    }

    
}
