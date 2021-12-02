<?php
require __DIR__ . '/../classes/Login.php';

use entidades\classes\Login;

if(isset($_POST)) {
    $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $objDados = (Object)$dados;
    $codigoUsuario = $objDados->codigoUser;
    $senha = $objDados->senha;
    $view = "";
    $tipo = "";
        
    switch (strtoupper($objDados->tipo)) {
        case 'CLIENTE':
            $tipo = "CLIENTE";
            break;
        case 'ESTABELECIMENTO':
            $tipo = "ESTABELECIMENTO";
            break;
        case 'ADMINISTRADOR':
            $tipo = "ADMINISTRADOR";
            break;
         
        default:
            $tipo = "";
    }
   
    $login = new Login($codigoUsuario, $senha, $tipo);
    $viewLogin = $login->logIn();
    
    if(!$viewLogin) {
        session_start();
        $_SESSION['msgErro'] = "Login ou senha inválidos";
        header("location: ../../login.php");
    }else{
        $tipo = strtolower($tipo);
        $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $objDados = (Object)$dados;
        
        ob_start();
        session_start();
        $_SESSION['tipo'] = $objDados->tipo;
        $_SESSION['codigo'] = $viewLogin;
        ob_end_flush();
        header("location: ../../views/{$tipo}/{$tipo}-painel.php");
    }
    
}