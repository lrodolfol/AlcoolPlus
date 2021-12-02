<?php
namespace entidades\classes;

require_once '../../dataBase/source/Model.php';

use database\source\Model;

class Configuracoes extends Model {
    private $precoMaxProdutos;
    private $precoMinProdutos;
    private $dataIntervalorPedido;
    public static $table = "configuracoes";
    
    function __construct($precoMaxProdutos = null, $precoMinProdutos = null, $dataIntervalorPedido = null) {
        $this->SetPrecoMaxProdutos($precoMaxProdutos);
        $this->SetPrecoMinProdutos($precoMinProdutos);
        $this->SetDataIntervalorPedido($dataIntervalorPedido);
    }
    
    function getPrecoMaxProdutos() {
        return $this->precoMaxProdutos;
    }

    function getPrecoMinProdutos() {
        return $this->precoMinProdutos;
    }

    function getDataIntervalorPedido() {
        return $this->dataIntervalorPedido;
    }

    function setPrecoMaxProdutos($precoMaxProdutos): void {
        $this->precoMaxProdutos = $precoMaxProdutos;
    }

    function setPrecoMinProdutos($precoMinProdutos): void {
        $this->precoMinProdutos = $precoMinProdutos;
    }

    function setDataIntervalorPedido($dataIntervalorPedido): void {
        $this->dataIntervalorPedido = $dataIntervalorPedido;
    }
    
    public function buscaConfiguracoes() : ?Configuracoes {
        $config = $this->selectAll(self::$table, 1, 'codigo desc');
        if($config) {
            $this->setPrecoMaxProdutos($config[0]->preco_maximo_produto);
            $this->setPrecoMinProdutos($config[0]->preco_minimo_produto);
            $this->setDataIntervalorPedido($config[0]->intervalo_data_pedido);
            return $this;
        }else{
            /*
             * CASO NÃO TENHO NENHUM VALORES DE CONFIGURAÇÃO 
             * O SISTEMA SE ENCASSE DE GRAVAR
             */
            $this->setDataIntervalorPedido(15);
            $this->setPrecoMaxProdutos(999.99);
            $this->setPrecoMinProdutos(0.01);
            $config = $this->salvar(self::$table, 
            ['preco_maximo_produto', 'preco_minimo_produto', 'intervalo_data_pedido'],
            [999.99, 0.01, '15']);
            if($config) { 
                return $this;
            }
            return null;
        }
    }

    public function defineConfiguracao() {
        $config = $this->updateCommit(self::$table, 
        ['preco_maximo_produto', 'preco_minimo_produto', 'intervalo_data_pedido'], 
        [$this->getPrecoMaxProdutos(), $this->getPrecoMinProdutos(), "'".$this->getDataIntervalorPedido()."'"],
        'codigo', 1);
       if($config) {
           return "Salvo com sucesso";
       }
       return "Erro ao realizar atualizações";
    }
    
}
