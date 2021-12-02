<?php

namespace entidades\classes;

require_once __DIR__ . '\..\..\database\source\Model.php';

use database\source\Model;

class Produto extends Model {

    public $descricao;
    private $valor;
    private $codigo;
    public static $table = "produto";

    function __construct($descricao = null, $valor = null) {
        $this->descricao;
        $this->setValor($valor);
    }

    function getValor() {
        return $this->valor;
    }

    function setValor($valor): void {
        $this->valor = $valor;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo): void {
        $this->codigo = $codigo;
    }

    public function produtos() {
        $produtos = $this->selectAll(self::$table);
        if ($produtos) {
            return $produtos;
        }
        return null;
    }

    public function salvarProduto(): bool {
        if (empty($this)) {
            return false;
        }

        $this->salvar(self::$table, ['descricao', 'valor'],
                ["'{$this->descricao}'", $this->getValor()]);

        return true;
    }

}
