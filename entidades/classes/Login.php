<?php
namespace entidades\classes;

require __DIR__ . '\..\..\database\source\Model.php';

class Login extends \database\source\Model {

    private $usuario;
    private $senha;
    private $table;
    private $tipo;
    private $codigo;
    
    function __construct($codigo = null, $senha = null, $tipo = null) {
        $this->setCodigo($codigo);
        $this->setSenha($senha);
        $this->setTipo($tipo);
         
        switch (strtoupper($this->getTipo())) {
            case 'CLIENTE':
                $this->setTable('cliente');
                break;
            case 'ESTABELECIMENTO':
                $this->setTable('estabelecimento');
                break;
            case 'ADMINISTRADOR':
                $this->setTable('administrador');
                break;
            default:  
                $this->setTable('nothing');
        }
    }
    
    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo): void {
        $this->codigo = $codigo;
    }
    
    function getUsuario() {
        return $this->usuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function getTable() {
        return $this->table;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }

    function setSenha($senha): void {
        $this->senha = $senha;
    }

    function setTable($table): void {
        $this->table = $table;
    }

    function setTipo($tipo): void {
        $this->tipo = $tipo;
    }
    
    public function logIn() {
        if(!isset($this)) {
            return null;
        }
        
       return $this->logar($this->getCodigo(), $this->getSenha(), $this->getTable());        
        
    }


}

?>