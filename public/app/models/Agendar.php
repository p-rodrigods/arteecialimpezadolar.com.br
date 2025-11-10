<?php

namespace app\models;

use mf\Model\Model;

class Agendar extends Model{
    private $id;
    private $nome;
    private $contato;
    private $tipo;
    private $servico;
    private $sala;
    private $quarto;
    private $cozinha;
    private $banheiro;
    private $varanda;
    private $garagem;
    private $area_servico;
    private $frequencia;
    private $horas_ps;
    private $horas_cdi;
    private $mais_informacoes;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr, $value){
        $this->$attr = $value;
    }

    public function agendar(){

        $query = "INSERT INTO tb_agendamentos(
            tb_nome, tb_contato, tb_tipo, tb_servico, tb_sala, tb_quarto, tb_cozinha, tb_banheiro, tb_varanda, tb_garagem, tb_area_servico, tb_frequencia, tb_horas_ps, tb_horas_cdi, tb_mais_informacoes
        ) VALUES (
            :nome, :contato, :tipo, :servico, :sala, :quarto, :cozinha, :banheiro, :varanda, :garagem, :area_servico, :frequencia, :horas_ps, :horas_cdi, :mais_informacoes
        )";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':contato', $this->__get('contato'));
        $stmt->bindValue(':tipo', $this->__get('tipo'));
        $stmt->bindValue(':servico', $this->__get('servico'));
        $stmt->bindValue(':sala', $this->__get('sala'));
        $stmt->bindValue(':quarto', $this->__get('quarto'));
        $stmt->bindValue(':cozinha', $this->__get('cozinha'));
        $stmt->bindValue(':banheiro', $this->__get('banheiro'));
        $stmt->bindValue(':varanda', $this->__get('varanda'));
        $stmt->bindValue(':garagem', $this->__get('garagem'));
        $stmt->bindValue(':area_servico', $this->__get('area_servico'));
        $stmt->bindValue(':frequencia', $this->__get('frequencia'));
        $stmt->bindValue(':horas_ps', $this->__get('horas_ps'));
        $stmt->bindValue(':horas_cdi', $this->__get('horas_cdi'));
        $stmt->bindValue(':mais_informacoes', $this->__get('mais_informacoes'));
        $stmt->execute();

        return $this;
    }

    public function getAgendamentos(){

        $query = "SELECT id, nome, email, telefone, data, horario, servico FROM tb_agendamentos";
        return $this->db->query($query)->fetchAll(\PDO::FETCH_ASSOC);

    }

    
}