<?php
require_once '../../entidades/classes/Configuracoes.php';

use entidades\classes\Configuracoes;

$resposta = "";

if (isset($_POST)) {
    $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $objDados = (Object) $dados;
    $precoMaxProdutos = (empty($objDados->precoMax) ? "" : $objDados->precoMax);
    $precoMinProdutos = (empty($objDados->precoMin) ? "" : $objDados->precoMin);
    $dataIntervaloPedido = (empty($objDados->intervaloData) ? "" : $objDados->intervaloData);

    $configuracao = new Configuracoes($precoMaxProdutos, $precoMinProdutos, $dataIntervaloPedido);
    
    $resposta = $configuracao->defineConfiguracao();

    echo json_encode($resposta);
}