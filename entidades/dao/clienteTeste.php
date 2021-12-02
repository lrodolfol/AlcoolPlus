<?php

require __DIR__ . '/../classes/Cliente.php';

use entidades\Classes\Cliente;

    /* VERIFICA SE O CPF JÁ ESTA EM USO */

    $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $objDados = (Object)$dados;
    $nome =  (empty($objDados->nome) ? "" : $objDados->nome);
    $senha = (empty($objDados->senha) ? "" : $objDados->senha);
    $senhaConfirmada = (empty($objDados->confirmaSenha) ? "" : $objDados->senha);
    $cpf = (empty($objDados->cpf) ? "" : $objDados->cpf);
    $asma = (empty($objDados->asma) ? "S" : "N");
    $hipertenso = (empty($objDados->hipertenso) ? "S" : "N");
    $diabetico = (empty($objDados->diabetico) ? "S" : "N");
    $hiv = (empty($objDados->hiv) ? "S" : "N");
    $senha = password_hash($senha, PASSWORD_DEFAULT);
          
    $cliente = new Cliente(null, "13414231662");
          
    if($cliente->validaCPF($cliente)) {
        echo json_encode(false); 
    }else{
        echo json_encode(true); 
    }

/*
if ($cpf == "13414231662") {
    echo json_encode(false); 
} else {
    echo json_encode(true);
}*/