<?php

namespace app\controllers\site;

use mf\Controller\ActionIndex;
use mf\Model\Container;

class IndexController extends ActionIndex
{
  // Rendereiza a pagina principal do site
  public function index()
  {
    $this->render('index');
  }

  // Renderiza a pagina de Agendamento
  public function agendamento()
  {
    $this->render('agendamento');
  }

  // Função para inserir agendamento no banco de dados 
  public function insertAgendamento()
  {
    $tb_agendar = Container::getModel('Agendar');

    $tb_agendar->__set('nome', $_POST['nome']);
    $tb_agendar->__set('contato', $_POST['contato']);
    $tb_agendar->__set('tipo', $_POST['tipoResidencia']);
    $tb_agendar->__set('servico', $_POST['servico']);
    $tb_agendar->__set('horas_ps', $_POST['qtdRoupasPassar']);
    $tb_agendar->__set('horas_cdi', $_POST['qtdHorasCuidador']);
    $tb_agendar->__set('sala', $_POST['qtdSalas']);
    $tb_agendar->__set('quarto', $_POST['qtdQuartos']);
    $tb_agendar->__set('cozinha', $_POST['qtdCozinhas']);
    $tb_agendar->__set('banheiro', $_POST['qtdBanheiros']);
    $tb_agendar->__set('varanda', $_POST['qtdVarandas']);
    $tb_agendar->__set('area_servico', $_POST['qtdAreaServico']);
    $tb_agendar->__set('garagem', $_POST['qtdGaragem']);
    $tb_agendar->__set('frequencia', $_POST['frequencia']);
    $tb_agendar->__set('mais_informacoes', $_POST['maisInformacoes']);

    if ($tb_agendar->agendar()) {
       echo "sucesso";
    }

  }

  // Renderiza a pagina de Recrutamento
  public function recrutamento()
  {
    $this->render('recrutamento');
  }

  // Função para inserir recrutamento no banco de dados
  public function insertRecrutamento()
  {
    $tb_recrutamento = Container::getModel('Recrutamento');

    $caminhoDB = $tb_recrutamento->uploadArquivo($_FILES['arquivo']);

    $tb_recrutamento->__set('nome', $_POST['nome']);
    $tb_recrutamento->__set('email', $_POST['email']);
    $tb_recrutamento->__set('contato', $_POST['contato']);
    $tb_recrutamento->__set('caminho_arquivo', $caminhoDB);

    if ($tb_recrutamento->cadastrar()) {
      echo "sucesso";
    }

  }

  // Renderiza a pagina de sucesso do recrutamento
  public function success()
  {
    $this->render('pagina-sucesso');
  }
}
