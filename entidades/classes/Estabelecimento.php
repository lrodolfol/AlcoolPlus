<?php

namespace entidades\classes;

require_once __DIR__ . '\..\..\database\source\Model.php';

class Estabelecimento extends \database\source\Model {

    public static $table = "estabelecimento";
    public $message;
    public $razaoSocial;
    public $cidade;
    public $codStatus;
    private $codigo;
    private $senha;
    private $senhaConfirmada;
    private $cnpj;
    private $obgrigatorios = ['razaoSocial', 'cnpj', 'cidade', 'senha'];

    function __construct(string $razaoSocial = null, string $senha = null,
            string $cnpj = null, string $cidade = null,
            int $status = 0) {
        $this->razaoSocial = $razaoSocial;
        $this->setSenha($senha);
        $this->setCnpj($cnpj);
        $this->cidade = $cidade;
        $this->codStatus = $status;
    }

    function getSenha() {
        return $this->senha;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setSenha($senha): void {
        $this->senha = $senha;
    }

    function setCnpj($cnpj): void {
        $this->cnpj = $cnpj;
    }

    function setCodigo($codigo): void {
        $this->codigo = $codigo;
    }

    public function gravar(): ?Estabelecimento {
        foreach ($this->obgrigatorios as $value) {
            if (empty($this->$value)) {
                $this->message = "Dados incompletos";
                return null;
            }
        }

        $estabelecimentoRetorno = $this->salvar(self::$table,
                ['cnpj', 'razao_social', 'codigo_status', 'senha', 'cidade'],
                ["'{$this->getCnpj()}'", "'{$this->razaoSocial}'", "{$this->codStatus}",
                    "'{$this->getSenha()}'", "'{$this->cidade}'"]);
        if ($estabelecimentoRetorno) {
            $this->setCodigo($estabelecimentoRetorno);
            return $this;
        }
        return null;
    }

    public function estabelecimentosAtivos() {
        $estabelecimentos = $this->select(self::$table, 'codigo_status', '1');
        if ($estabelecimentos) {
            return $estabelecimentos;
        }
        return null;
    }

    public function estabelecimentosInativos() {
        $estabelecimentos = $this->select(self::$table, 'codigo_status', '0');
        if ($estabelecimentos) {
            return $estabelecimentos;
        }
        return null;
    }

    public function validaCNPJ(Estabelecimento $estabelecimento): bool {
        $cnpj = $estabelecimento->getCnpj();
        if (!$this->select(self::$table, 'cnpj', $cnpj)) {
            return false;
        }
        return true;
    }

    public function liberarEstabelecimento() {
        $estab = $this->update(self::$table, ['codigo_status'],
                [1], 'codigo', "{$this->getCodigo()}");
    }

}

?>