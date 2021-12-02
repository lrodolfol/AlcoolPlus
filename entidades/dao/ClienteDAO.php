<?php

require __DIR__ . '/../classes/Cliente.php';

use entidades\Classes\Cliente;
$response = "";
if (isset($_POST)) {
    $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $objDados = (Object)$dados;
    
    $nome =  (empty($objDados->nome) ? "" : $objDados->nome);
    $senha = (empty($objDados->senha) ? "" : $objDados->senha);
    $senhaConfirmada = (empty($objDados->confirmaSenha) ? "" : $objDados->senha);
    $cpf = (empty($objDados->cpf) ? "" : str_replace(['.', '-'], '', $objDados->cpf));
    $asma = (empty($objDados->asma) ? "N" : "S");
    $hipertenso = (empty($objDados->hipertenso) ? "N" : "S");
    $diabetico = (empty($objDados->diabetico) ? "N" : "S");
    $fumante = (empty($objDados->fumante) ? "N" : "S");
    $senha = password_hash($senha, PASSWORD_DEFAULT);

    /* 
     * VERIFICA SE O CPF JÁ ESTA EM USO 
     */
    $cliente = new Cliente(
            $nome, $cpf, $senha, $hipertenso, $diabetico, $asma, $fumante
    );
    
    if($cliente->validaCPF($cliente)) {
        $resposta = "CPF esta em uso";
        echo json_encode($resposta); 
        die;
    }

    if (!$cliente->gravar()) {
        $resposta = "Erro ao gravar novo cliente. " . $cliente->message;
        //$cliente->message = $resposta;
        echo json_encode($resposta);
        return;
    } else {
        $resposta = "Dados gravados com sucesso. Codigo para login: {$cliente->getCodigo()}";
        //$response = true;
        echo json_encode($resposta);
        return;
    }
}