<?php
require_once '../../entidades/classes/Pedido.php';
require_once '../../entidades/classes/cliente.php';
require_once '../../entidades/classes/estabelecimento.php';
require_once '../../entidades/classes/produto.php';
	
use entidades\Classes\Pedido;
use entidades\Classes\Cliente;
use entidades\Classes\Estabelecimento;
use entidades\Classes\Produto;
	
$resposta = "";

if(isset($_POST)) {
	$dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $objDados = (Object)$dados;
	
	$codProduto = (empty($objDados->produto) ? "" : $objDados->produto);
	$codEstabelecimento = (empty($objDados->estabelecimento) ? "" : $objDados->estabelecimento);
	$quantidade = (empty($objDados->quantidade) ? 0 : $objDados->quantidade);
	
	$estabelecimento = new Estabelecimento();
	$estabelecimento->setCodigo($codEstabelecimento);
	
	$produto = new Produto();
	$produto->setCodigo($codProduto);
	
	$cliente = new Cliente();
	session_start();
	$cliente->setCodigo($_SESSION['codigo']); //TRATAR E PASSAR PARA OBJ
	
	$dataHoje = date_create(DATE('Y-m-d'));
        $dataHoje = $dataHoje->format("Y.m.d");
	
	$pedido = new Pedido($cliente, $estabelecimento, $produto, $dataHoje, $quantidade);
	if($pedido->salvarPedido()){
		$resposta = 'PEDIDO FEITO COM SUCESSO';
	}else{
		$resposta = 'ERRO AO EFETUAR PEDIDO';
	}
	echo json_encode($resposta);
}