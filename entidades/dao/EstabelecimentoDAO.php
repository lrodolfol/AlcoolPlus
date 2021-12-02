<?php
require __DIR__ . '/../classes/Estabelecimento.php' ;

use entidades\classes\Estabelecimento;
$resposta = "";

if(isset($_POST)) {
    $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $objDados = (Object)$dados;
    
    $razaoSocial = (empty($objDados->razaoSocial) ? "" : $objDados->razaoSocial);
    $senha = (empty($objDados->senha) ? "" : $objDados->senha);
    $senhaConfirmada = (empty($objDados->senhaConfirmada) ? "" : $objDados->senhaConfirmada);
    $cnpj = ( empty($objDados->cnpj) ? "" : str_replace(['.', '-', '/'], '', $objDados->cnpj));
    $cidade = ( empty($objDados->cidade) ? "" : $objDados->cidade);
    $senha = password_hash($objDados->senha, PASSWORD_DEFAULT);
       
    $estabelecimento = new Estabelecimento($razaoSocial, $senha, $cnpj, $cidade);
    
    /* 
     * VERIFICA SE O CNPJ JÁ ESTA EM USO 
     */
    if($estabelecimento->validaCNPJ($estabelecimento)) {
        $resposta = "CNPJ esta em uso";
        echo json_encode($resposta); 
        die;
    }
    
    if(!$estabelecimento->gravar()){
        $resposta = "Erro ao gravar novo estabelecimento. ";
        echo json_encode($resposta);
        die;
    }else{
        $resposta = "Dados gravados com sucesso. Codigo para login: {$estabelecimento->getCodigo()}";
        echo json_encode($resposta);
        die;
    }
    
    
    
}