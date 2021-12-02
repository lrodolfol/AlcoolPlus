<?php
require __DIR__ . '/../classes/Administrador.php' ;

use entidades\classes\Administrador;
$resposta = "";
if(isset($_POST)) {
    $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $objDados = (Object)$dados;
    
    $senha = (empty($objDados->senha) ? "" : $objDados->senha);
    $senhaConfirmada = (empty($objDados->senhaConfirmada) ? "" : $objDados->senhaConfirmada);
    $cpf = (empty($objDados->cpf) ? "" : str_replace(['.', '-'], '', $objDados->cpf));
    $nome = (empty($objDados->nome) ? "" : $objDados->nome);
    $senha = password_hash($objDados->senha, PASSWORD_DEFAULT);
       
    $administrador = new Administrador($nome, $cpf, $senha);
       
    /* 
     * VERIFICA SE O CPF JÁ ESTA EM USO 
     */
    if($administrador->validaCPF($administrador)) {
        $resposta = "CPF esta em uso";
        echo json_encode($resposta); 
        die;
    }
    
    if(!$administrador->gravar()){
        $resposta = "Erro ao gravar novo administrador";
        echo json_encode($resposta);
        die;
    }else{
        $resposta = "Dados gravados com sucesso. Codigo para login: {$administrador->getCodigo()}";
        echo json_encode($resposta);
        die;
    }
    
}