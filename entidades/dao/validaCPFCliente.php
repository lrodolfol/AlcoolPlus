<?php
/*
 * ARQUIVO SOMENTE PARA TRATAR O CPF DIGITADO PELO CLIENTE
 * VERIFICA SE ESSE CPF JÁ ESTA EM USO
 */
require __DIR__ . '/../classes/Cliente.php';

use entidades\Classes\Cliente;
$resposta = "";
if (isset($_POST)) {
    $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $objDados = (Object)$dados;
    $cpf = (empty($objDados->cpf) ? "" : str_replace(['.', '-'], '', $objDados->cpf));
   
    /* 
     * VERIFICA SE O CPF JÁ ESTA EM USO 
     */
    $cliente = new Cliente(null, $cpf);
    
    if($cliente->validaCPF($cliente)) {
        $resposta = "CPF esta em uso";
        echo json_encode($resposta); 
    }
}