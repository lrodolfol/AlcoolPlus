<?php

require 'views/layouts/cabecalho.php';
?>

<script>
    $(document).ready(function () {
        $('#cnpj').mask('99.999.999/9999-99');
        $(navEstabelecimento).css({"color": "red"});
    });
</script>

<script>
    $(function () {
        $("#formCadastro").validate({
            rules: {
                razaoSocial: {
                    required: true
                },
                cnpj: {
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
                razaoSocial: {
                    required: "informe seu nome."
                },
                cnpj: {
                    required: "informe seu cnpj",
                    remote: "CNPJ já está em uso"
                },
                cidade: {
                    required: "Informe a cidade",
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
                    url: "entidades/dao/EstabelecimentoDAO.php",
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
    <h1>Cadastro de Estabelecimentos</h1><img src="public/images/Alcool.png">
</div>
<div class="cadastro">
    <form method="post" name="formCadastro" id="formCadastro">  
        <div class="campoForm">
            <label for="razaoSocial">Nome</label>
            <input type="text" name="razaoSocial" id="razaoSocial" placeholder="razaoSocial"/>
        </div>
        <div class="campoForm">
            <label for="cnpj">CNPJ</label>
            <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ"/>
        </div>
        <div class="campoForm">
            <label for="cidade">Cidade</label>
            <select name="cidade" id="cidade">
                <option></option>
                <option>SÃO LOURENÇO</option>
                <option>SANTA RITA DO SAPUCAI</option>
                <option>BELO HORIZONTE</option>
                <option>BRASILIA</option>
            </select>
        </div>
        <div class="campoForm">
            <label for="senha">Senha</label> 
            <input type="password" name="senha" id="senha" placeholder="senha"/>
        </div>
        <div class="campoForm">
            <label for="senha">Confirmação de Senha</label> 
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
