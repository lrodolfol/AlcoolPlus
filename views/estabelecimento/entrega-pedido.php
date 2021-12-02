<?php
require_once '../../entidades/classes/Pedido.php';	

use entidades\Classes\Pedido;

if(isset($_POST)) {
	
	$dados = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        $objDados = (Object)$dados;
	
	$codPedido = $objDados->codPedido;
	
	$pedido = new Pedido();
	$pedido->setCodigo($codPedido);
	
	$pedido->entregaPedido();
        header("location: estabelecimento-painel.php");
	
}