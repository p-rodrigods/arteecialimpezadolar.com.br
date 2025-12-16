<?php

namespace app;

use mf\Init\Bootstrap;
use app\routes\Routes;

class Route extends Bootstrap
{
    //Define as rotas do sistema
    public function initRoutes()
    {   
        //Instancia a classe Routes
        $routes = new Routes();

        // Adiciona rota home usando o método add
        $routes->add('home', '/', 'site', 'IndexController','index');

        // Adiciona rota agendamento usando o método add
        $routes->add('agendamento', '/agendamento', 'site', 'IndexController','agendamento');

        // Adiciona rota para insert agendamento
        $routes->add('agendamento-insert', '/agendamento-insert', 'site', 'IndexController','insertAgendamento');

        // Adiciona rota recrutamento usando o método add
        $routes->add('recrutamento', '/recrutamento', 'site', 'IndexController','recrutamento');

        // Adiciona rota para cadastrar recrutamento
        $routes->add('recrutamento-insert', '/recrutamento-insert', 'site', 'IndexController','insertRecrutamento');

        // Adiciona rota para mensagem de sucesso do recrutamento
        $routes->add('recrutamento-sucesso', '/recrutamento-sucesso', 'site', 'IndexController','success');

        // Adiciona rota do BLOG
        $routes->add('blog', '/blog', 'blog', 'BlogController','index');

        // Adiciona rota Buscar
        $routes->add('buscar', '/buscar', 'blog', 'BlogController','buscar');

        // Adiciona rota Admin
        $routes->add('admin', '/admin', 'admin', 'AdminController','index');

        // Adiciona rota Admin autenticar
        $routes->add('admin-authenticate', '/admin-authenticate', 'admin', 'AdminController','authenticate');

        // Adiciona rota Admin logout
        $routes->add('admin-logout', '/admin-logout', 'admin', 'AdminController','logout');

        // Adiciona rota dashboard
        $routes->add('dashboard', '/dashboard', 'admin', 'DashboardController','index');

        // Adiciona rota notFound
        $routes->add('notFound', '/notFound', '', 'NotFoundController','notFound');

        return $this->__set('routes', $routes->getRoutes());

    }

}
