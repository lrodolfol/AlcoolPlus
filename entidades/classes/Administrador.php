<?php

namespace entidades\classes;

require_once __DIR__ . '\..\..\database\source\Model.php';

class Administrador extends \database\source\Model {

    public $nome;
    private $cpf;
    private $senha;
    private $codigo;
    public static $table = "administrador";
    private $obgrigatorios = ['nome', 'senha', 'cpf'];

    function __construct($nome = null, $cpf = null, $senha = null) {
        $this->nome = $nome;
        $this->setCpf($cpf);
        $this->setSenha($senha);
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo): void {
        $this->codigo = $codigo;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getSenha() {
        return $this->senha;
    }

    function setCpf($cpf): void {
        $this->cpf = $cpf;
    }

    function setSenha($senha): void {
        $this->senha = $senha;
    }

    public function gravar(): ?Administrador {
        foreach ($this->obgrigatorios as $value) {
            if (empty($this->$value)) {
                $this->message = "Dados incompletos";
                return null;
            }
        }

        $administradorRetorno = $this->salvar(self::$table,
                ['nome', 'cpf', 'senha'], ["'{$this->nome}'",
            "'{$this->getCpf()}'", "'{$this->getSenha()}'"]);
        if ($administradorRetorno) {
            $this->setCodigo($administradorRetorno);
            return $this;
        }
        return null;
    }

    public function validaCPF(Administrador $administrador): bool {
        $cpf = $administrador->getCpf();
        if (!$this->select(self::$table, 'cpf', $cpf)) {
            return false;
        }
        return true;
    }
    
    public function administrador() : ?Administrador{
       $adm = $this->select(self::$table, 'codigo', $this->getCodigo()); 
        if($adm){
            /*$this->setCpf($adm->cpf);
            $this->setSenha($adm->nome);*/
            return $this;
        }
        return null;
    }

}

?>