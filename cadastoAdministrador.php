<?php

require 'views/layouts/cabecalho.php';
?>

<script>
    $(document).ready(function () {
        $('#cpf').mask('999.999.999-99');
        $(navAdministrador).css({"color": "red"});
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
                    required: true
                },
                cidade: {
                    required: true
                },
                senha: {
                    required: true
                },
                senhaConfirmada: {
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
                senhaConfirmada: {
                    required: "confirme a senha",
                    equalTo : "A confirmação deve ser igual à senha."
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "entidades/dao/AdministradorDAO.php",
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
    <h1>Cadastro de Administrador</h1><img src="public/images/Alcool.png">
</div>
<div class="cadastro">
     <form method="post" name="formCadastro" id="formCadastro">  
    <div class="campoForm">
        <label for="nome">Nome</label> 
        <input type="text" name="nome" id="nome" placeholder="seu nome"/>
    </div>
    <div class="campoForm">
        <label for="cpf">CPF</label> 
        <input type="text" name="cpf" id="cpf" placeholder="CPF"/>    
    </div>
    <div class="campoForm">
        <label for="senha">Senha</label> 
        <input type="password" name="senha" id="senha" placeholder="senha"/>    
    </div>
    <div class="campoForm">
        <label for="senhaConfirmada">Confirmação de Senha</label> 
        <input type="password" name="senhaConfirmada" id="senhaConfirmada" placeholder="confirme sua senha"/>    
    </div>
    <div class="campoForm">
        <button class="btnEnviar" id="enviar">Cadastrar</button>
    </div>
     </form> 
    <div id="resultado" class="mensagemCadastro"></div>
</div>

<?php

require 'views/layouts/rodape.php';
?>