<?php
require 'views/layouts/cabecalho.php';
session_start();
if (isset($_SESSION) && isset($_SESSION['codigo']) && isset($_SESSION['tipo'])) {
    header("location: views/{$_SESSION['tipo']}/{$_SESSION['tipo']}-painel.php");
}
?>

<article>

    <header id="top">
        <h1>Bem Vindo</h1> 
        <img src="public/images/Alcool.png" alt="img Alcool+">
    </header>

</article>

<?php
require 'views/layouts/rodape.php';
?>

