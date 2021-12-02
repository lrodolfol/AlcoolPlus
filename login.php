<?php
require 'views/layouts/cabecalho.php';
session_start();
$msgErro = (isset($_SESSION) && isset($_SESSION['msgErro']) ) ? "Login ou senha inválidos" : "";
session_destroy();
unset( $_SESSION );
?>

<script>
    $(document).ready(function () {
        $(navLogin).css({"color": "red"});
    });
</script>

<div class="tituloTelaLogin">
    <h1>Login</h1><img src="public/images/Alcool.png">
</div>
<div class="cadastro" id="cadastro">

    <form action="entidades/dao/loginDAO.php" name="login" method="post">
        <div class="row">
            <div class="campoFormLogin">
                <label for="codigoUser">Cód.Usuário</label> 
                <input type="text" name="codigoUser" placeholder="seu codigo" required/>
            </div>
        </div>

        <div class="row">
            <div class="campoFormLogin"> 
                <label for="senha">Senha</label> 
                <input type="password" name="senha" placeholder="sua senha" required/><br>
            </div>
        </div>
        <input type="radio" class="radio" id="tipo" name="tipo" value="Administrador">Administrador  
        <input type="radio" class="radio"  id="tipo" name="tipo" value="Cliente">Cliente
        <input type="radio" class="radio"  id="tipo" name="tipo" value="Estabelecimento">Estabelecimento

        <div class="row">
              <div class="campoFormLogin">
                <button class="btnEnviar">Logar</button>
            </div>
        </div>
    </form>
    <div id="resultado" class="mensagemCadastro">
        <p><?= $msgErro ?></p>
    </div>
</div>

<?php

require 'views/layouts/rodape.php';
?>