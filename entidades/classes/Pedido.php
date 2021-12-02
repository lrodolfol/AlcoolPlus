<?php

namespace entidades\classes;

require_once __DIR__ . '\..\..\database\source\Model.php';

class Pedido extends \database\source\Model {

    public static $table = "pedido";
    private Cliente $cliente;
    private Estabelecimento $codigoEstabelecimento;
    private $dataPedido;
    private $codigo;
    private $quantidade;

    function __construct(Cliente $cliente = null, Estabelecimento $estabelecimento = null,
            Produto $produto = null, $dataPedido = null, $quantidade = null) {
        if (isset($cliente)) {
            $this->setCliente($cliente);
        }
        if (isset($estabelecimento)) {
            $this->setEstabelecimento($estabelecimento);
        }
        if (isset($produto)) {
            $this->setProduto($produto);
        }
        if (isset($quantidade)) {
            $this->setQuantidade($quantidade);
        }
        $this->setDataPedido($dataPedido);
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function setQuantidade($quantidade): void {
        $this->quantidade = $quantidade;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo): void {
        $this->codigo = $codigo;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getEstabelecimento() {
        return $this->estabelecimento;
    }

    function getProduto() {
        return $this->produto;
    }

    function getDataPedido() {
        return $this->dataPedido;
    }

    function setCliente($cliente): void {
        $this->cliente = $cliente;
    }

    function setEstabelecimento($estabelecimento): void {
        $this->estabelecimento = $estabelecimento;
    }

    function setProduto($produto): void {
        $this->produto = $produto;
    }

    function setDataPedido($dataPedido): void {
        $this->dataPedido = $dataPedido;
    }

    public function salvarPedido(): ?bool {
        if (empty($this)) {
            return null;
        }
        if (!$this->verificaDataPedidoCliente($this->getCliente(), $this->getDataPedido())) {
            return false;
        }

        $this->salvar(self::$table,
                ['codigo_cliente', 'data_pedido', 'codigo_estabelecimento', 'codigo_produto', 'quantidade'],
                [$this->getCliente()->getCodigo(), "'{$this->getDataPedido()}'", $this->getEstabelecimento()->getCodigo(),
                    $this->getProduto()->getCodigo(), $this->getQuantidade()]);

        return true;
    }

    private function verificaDataPedidoCliente(Cliente $cliente, $dataPedido): bool {
        //$this->select()
        return true;
    }

    public function buscaPedidoCliente(Cliente $cliente) {
        $pedidos = $this->select(self::$table, 'codigo_cliente',
                $cliente->getCodigo(), ' data_pedido ', [' estabelecimento e ', ' produto p '],
                [' codigo_estabelecimento = e.codigo ', ' codigo_produto = p.codigo ']);
        if ($pedidos) {
            return $pedidos;
        } else {
            return null;
        }
    }

    public function buscaPedidoEstabelecimento(Estabelecimento $estabelecimento) {
        $campos = ['data_pedido', 'c.nome', 'c.prioridade', 'p.descricao', 'entregue', 'quantidade', 'd.codigo as codigo_pedido'];
        $pedidos = $this->selectCampos(self::$table . " d ", $campos, 'codigo_estabelecimento',
                $estabelecimento->getCodigo(), ' c.prioridade desc, entregue ', ['estabelecimento e ', 'cliente c ', ' produto p '],
                [' codigo_estabelecimento = e.codigo ', ' codigo_cliente = c.codigo', ' codigo_produto = p.codigo ']);
        if ($pedidos) {
            return $pedidos;
        }
        return null;
    }

    public function entregaPedido() {
        $pedido = $this->update(self::$table, ['entregue'],
                ["'S'"], 'codigo', "{$this->getCodigo()}");
    }
    
    public function ultimosPedidosCliente(Cliente $cliente) {
        $pedidos = ($this->select(self::$table, 'codigo_cliente', $cliente->getCodigo(), 
        'codigo desc', null, null, 2));
        
        if($pedidos) {
            return $pedidos;
        }
        return null;
    }

}
