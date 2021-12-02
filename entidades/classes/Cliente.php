<?php

namespace entidades\classes;

require_once __DIR__ . '\..\..\database\source\Model.php';

//USAR O use AQUI.

class Cliente extends \database\source\Model {

    public $message;
    public static $table = "cliente";
    public $nome;
    private $cpf;
    private $senha;
    private $codigo;
    protected $hipertenso;
    protected $diabetico;
    protected $asma;
    protected $fumante;
    private $obgrigatorios = ['nome', 'senha', 'cpf'];

    function __construct(
            string $nome = null, string $cpf = null, string $senha = null,
            string $hipertenso = null, string $diabetico = null,
            string $asma = null, string $fumante = null) {
        $this->nome = $nome;
        $this->setCpf($cpf);
        $this->setSenha($senha);
        $this->setHipertenso($hipertenso);
        $this->setDiabetico($diabetico);
        $this->setAsma($asma);
        $this->setFumante($fumante);
    }

    function getTable() {
        return $this->table;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getSenha() {
        return $this->senha;
    }

    function getHipertenso() {
        return $this->hipertenso;
    }

    function getDiabetico() {
        return $this->diabetico;
    }

    function getAsma() {
        return $this->asma;
    }

    function getFumante() {
        return $this->fumante;
    }

    function setCpf($cpf): void {
        $this->cpf = $cpf;
    }

    function setSenha($senha): void {
        $this->senha = $senha;
    }

    function setHipertenso($hipertenso): void {
        $this->hipertenso = $hipertenso;
    }

    function setDiabetico($diabetico): void {
        $this->diabetico = $diabetico;
    }

    function setAsma($asma): void {
        $this->asma = $asma;
    }

    function setFumante($fumante): void {
        $this->fumante = $fumante;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo): void {
        $this->codigo = $codigo;
    }

    public function gravar(): ?Cliente {
        foreach ($this->obgrigatorios as $value) {
            if (empty($this->$value)) {
                $this->message = "Dados incompletos";
                return null;
            }
        }
        $prioridade = 0;
        $prioridade = ($this->getAsma() == 'S' ? $prioridade + 1 : $prioridade);
        $prioridade = ($this->getDiabetico() == 'S' ? $prioridade + 1 : $prioridade);
        $prioridade = ($this->getHipertenso() == 'S' ? $prioridade + 1 : $prioridade);
        $prioridade = ($this->getFumante() == 'S' ? $prioridade + 1 : $prioridade);

        $clienteRetorno = $this->salvar(self::$table,
                ['nome', 'cpf', 'prioridade', 'senha'], ["'{$this->nome}'",
            "'{$this->getCpf()}'", $prioridade, "'{$this->getSenha()}'"]);
        if ($clienteRetorno) {
            $this->setCodigo($clienteRetorno);
            return $this;
        }
        return null;
    }

    public function validaCPF(Cliente $cliente): bool {
        $cpf = $cliente->getCpf();
        if (!$this->select(self::$table, 'cpf', $cpf)) {
            return false;
        }
        return true;
    }
     
    public function clientes(){
        $clientes = $this->selectAll(self::$table);
        return $clientes;
    }

}

?>