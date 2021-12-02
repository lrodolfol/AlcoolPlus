<?php
require 'views/layouts/cabecalho.php';
?>

<script>
    $(document).ready(function () {
        $('#cpf').mask('999.999.999-99');
        $(navCliente).css({"color": "red"});
    });
</script>

<script>
    $(function () {
        $("#formCadastro").validate({
            rules: {
                nome: {
                    required: true
                },
                cpf: {
                    required: true,
                    /*  remote : {
                     url : "entidades/dao/validaCPFCliente.php",
                     type: "post",
                     data : {
                     login : function(){
                     return $("#login").val();
                     }
                     }
                     }*/
                },
                senha: {
                    required: true
                },
                confirmaSenha: {
                    required: true,
                    equalTo : "#senha"
                }
            },
            messages: {
                nome: {
                    required: "informe seu nome."
                },
                cpf: {
                    required: "informe seu cpf",
                    remote: "CPF já está em uso"
                },
                senha: {
                    required: "informe uma senha"
                },
                confirmaSenha: {
                    required: "confirme a senha",
                    equalTo : "A confirmação deve ser igual à senha."
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "entidades/dao/ClienteDAO.php",
                    type: "POST",
                    data: $(form).serialize(),
                    success: function (response) {
                        $('#resultado').html(response);
                    }
                });
                $('#formCadastro')[0].reset();
            }
        });
    });
</script>

<div class="tituloTela">
    <h1>Cadastro de Clientes</h1><img src="public/images/Alcool.png">
</div>
<div class="cadastro" id="cadastro">
    <form method="post" name="formCadastro" id="formCadastro">  
        <div class="campoForm">
            <label for="nome">Nome</label>
            <input type="text" id="nome" class="compoTexto" name="nome" placeholder="nome">
        </div>
        <div class="campoForm">
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" class="compoTexto" name="cpf" placeholder="cpf">
        </div>
        <div class="campoForm">
            <label for="senha">Senha</label>
            <input type="password" id="senha" class="compoTexto" name="senha" placeholder="senha">
        </div>
        <div class="campoForm">
            <label for="senhaConfirmada">Confirmação de Senha</label>
            <input type="password" id="confirmaSenha" class="compoTexto" name="confirmaSenha" placeholder="confirme sua senha">
        </div>
        <div class="campoForm">

            <input class="radio" type="checkbox" name="asma" id="asma" value="asma" >Possuo asma

            <input class="radio" type="checkbox" name="hipertenso" id="hipertenso">Sou hipertenso

            <input class="radio" type="checkbox" name="diabetico" id="diabetico">Sou diabético

            <input class="radio" type="checkbox" name="fumante" id="fumante">Fumante
        </div>
        <div class="campoForm">
            <button class="btnEnviar" id="enviar">Cadastrar</button>
        </div>
        <div id="resultado" class="mensagemCadastro"></div>
    </form> 
</div>

<?php
require 'views/layouts/rodape.php';
?>