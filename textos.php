  <div class="alert alert-light shadow-sm border-0" role="alert">
        <h4 class="mb-3"><i class="bi bi-info-circle-fill text-primary"></i> Informações Importantes sobre o Agendamento</h4>
        <ul class="list-unstyled mb-0">
            <li><i class="bi bi-calendar-check-fill text-success"></i> Agendamentos de <strong>segunda a sexta-feira</strong>, com mínimo de <strong>3 dias de antecedência</strong>.</li>
            <li><i class="bi bi-clock-fill text-success"></i> Horário do serviço: das 8h às 18h.</li>
            <li><i class="bi bi-card-checklist text-success"></i> Consulte valores e serviços preenchendo o <strong>formulário</strong> abaixo. Após o envio, você será atendido pelo <strong>WhatsApp</strong>.</li>
            <li><i class="bi bi-currency-dollar text-success"></i> Pagamento realizado na chegada da colaboradora, via <strong>Pix, Débito ou Crédito</strong> por link seguro enviado na confirmação.</li>
            <li><i class="bi bi-bucket-fill text-success"></i> Os <strong>produtos e materiais de limpeza</strong> são de responsabilidade do cliente.</li>
            <li><i class="bi bi-info-circle text-success"></i> Informe no campo de observações a quantidade de cômodos, banheiros, áreas externas, pets ou necessidades especiais.</li>
            <li><i class="bi bi-geo-alt-fill text-success"></i> Após verificar os valores e confirmar o agendamento, informe o <strong>endereço completo com referência</strong>.</li>
            <li><i class="bi bi-arrow-repeat text-success"></i> Cancelamentos ou alterações devem ser feitos com pelo menos <strong>24h de antecedência</strong>.</li>
            <li><i class="bi bi-shield-fill-check text-success"></i> Certifique-se de que haverá alguém para liberar o acesso ao imóvel no horário agendado.</li>
            <li><i class="bi bi-clock-history text-success"></i> O tempo estimado do serviço depende do tamanho do imóvel e da quantidade de cômodos informados.</li>
        </ul>
    </div>

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
            'action' => 'success'
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

        // Adiciona rota Admin logout
        $routes['admin-logout'] = array(
            'route' => '/admin-logout',
            'pasta' => 'admin',
            'controller' => 'AdminController',
            'action' => 'logout'
        );

        // Adiciona rota notFound
        $routes['notFound'] = array(
            'route' => '/notFound',
            'controller' => 'NotFoundController',
            'action' => 'notFound'
        );
'
        return $this->__set('routes', $routes->getRoutes());
