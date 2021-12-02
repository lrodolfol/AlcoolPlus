<?php
require '../layouts/cabecalhoPainel.php';
require_once '../../entidades/classes/Estabelecimento.php';

use entidades\classes\Estabelecimento;

$estabelecimento = new Estabelecimento();
$codEstabelecimento = $_SESSION['codigo'];
$estabelecimento->setCodigo($codEstabelecimento);
$estabelecimentosInativos = $estabelecimento->estabelecimentosInativos();

/*
 * CONTROLA SE O ESTABELECIMENTO ESTA INTAIVO OU NÃO(AINDA NÃO FOI LIBERADO PELO ADM)
 * NÃO PODERÁ CRIAR NOVOS PRODUTOS
 */
$inativo = false;
if ($estabelecimentosInativos) {
    foreach ($estabelecimentosInativos as $value) {
        if ($codEstabelecimento == $value->codigo) {
            $inativo = true;
            break;
        }
    }
}
?>

<script>
    $(document).ready(function () {
        $(novoProduto).css({"color": "red"});
    });
</script>

<script>
    $(function () {
        $("#formCadastro").validate({
            rules: {
                descricao: {
                    required: true
                },
                valor: {
                    required: true
                }
            },
            messages: {
                descricao: {
                    required: "informe a descrição."
                },
                valor: {
                    required: "informe o valor",
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "efetua-produto.php",
                    type: "POST",
                    data: $(form).serialize(),
                    success: function (response) {
                        $('#resultado').html(response);
                    }
                });
            }
        });
    });
</script>

<title>Alcool+ Painel do Fornecedor (Novo produto)</title>
</head>
<body>
    <nav>
        <ul>
            <li><a id="painelCliente" href="estabelecimento-painel.php">Painel inicial</a></li>
            <li><a id="novoProduto" href="novo-produto.php">Fazer novo produto</a></li>
            <li><a href="../logout.php">logout</a></li>
        </ul>
    </nav>

    <article>
        <?php if ($estabelecimentosInativos): ?>
            <div class="aviso">
                <p>Que pena, você ainda não foi liberado para criar novos produtos.</p>
                <p>Contate o administrador do sistema.</p>
            </div>
        <?php else: ?>
            <div class="tituloTela">
                <h1>Novo produto</h1>
            </div>

            <div class="cadastro" id="cadastro">
                <form method="post" name="formCadastro" id="formCadastro">  
                    <div class="campoForm">
                        <label for="descricao">Descrição</label>
                        <input type="text" name="descricao" id="descricao" >
                    </div>
                    <div class="campoForm">
                        <label for="valor">valor</label>
                        <input type="number" name="valor" id="valor" min="0.01" step="0.01">
                    </div>
                    <div class="campoForm">
                        <button class="btnEnviar" id="enviar">Realizar pedido</button>
                    </div>
                </form>
                <div id="resultado" class="mensagemCadastro"></div>
            </div>
        <?php endif; ?>

    </article>


</body>
</html>
