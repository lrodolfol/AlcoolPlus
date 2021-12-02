<?php
require_once '../../entidades/classes/estabelecimento.php';	

use entidades\Classes\Estabelecimento;

if(isset($_POST)) {
	
	$dados = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        $objDados = (Object)$dados;
	
	$codEstabelecimento = $objDados->codEstabelecimento;
	
	$estabelecimento = new Estabelecimento();
	$estabelecimento->setCodigo($codEstabelecimento);
	
	$estabelecimento->liberarEstabelecimento();
        header("location: administrador-painel.php");
	
}