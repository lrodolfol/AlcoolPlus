<?php
require_once '../../entidades/classes/estabelecimento.php';
require_once '../../entidades/classes/produto.php';
require_once '../../entidades/classes/Configuracoes.php';
	
use entidades\Classes\Estabelecimento;
use entidades\Classes\Produto;
use entidades\classes\Configuracoes;
	
$resposta = "";	
if(isset($_POST)) {
	$dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $objDados = (Object)$dados;
	$valorProduto = (empty($objDados->valor) ? "" : $objDados->valor);
	$descricaoProduto = (empty($objDados->descricao) ? "" : $objDados->descricao);
        
        $configuracao = new Configuracoes();
        $configuracao = $configuracao->buscaConfiguracoes();
        $vrMaxProd = $configuracao->getPrecoMaxProdutos();
        $vrMinProd = $configuracao->getPrecoMinProdutos();
        if(($valorProduto > $vrMaxProd) || ($valorProduto < $vrMinProd)) {
            $resposta = "O valor deve estar estre R$ " . number_format($vrMinProd,2,',','.') . " e R$ " . number_format($vrMaxProd,2,',','.');
            echo json_encode($resposta);
            return;
        }
	
	session_start();
	$estabelecimento = new Estabelecimento();
	$estabelecimento->setCodigo($_SESSION['codigo']);
	
	$produto = new Produto();
	$produto->setValor($valorProduto);
	$produto->descricao = $descricaoProduto;
	
	if($produto->salvarProduto()){
		$resposta = 'Produto criado com sucesso';
	}else{
		$resposta =  'Erro ao criar produto';
	}
	echo json_encode($resposta);
}