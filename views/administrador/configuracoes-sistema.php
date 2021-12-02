<?php
require '../layouts/cabecalhoPainel.php';
require_once '../../entidades/classes/Configuracoes.php';

use entidades\classes\Configuracoes;

$configuracao = new Configuracoes();
$configuracoes = $configuracao->buscaConfiguracoes();

$precoMaxProdutos = $configuracoes->getPrecoMaxProdutos();
$precoMinProdutos = $configuracoes->getPrecoMinProdutos();
$dataIntervaloPedido = $configuracoes->getDataIntervalorPedido();
?>

<script>
    $(document).ready(function () {
        $(navConfiguracoes).css({"color": "red"});
    });
</script>

<script>
    $(function () {
        $("#formCadastro").validate({
            rules: {
                precoMax: {
                    required: true
                },
                precoMin: {
                    required: true
                },
                intervaloData: {
                    required: true
                }
            },
            messages: {
                precoMax: {
                    required: "informe o preço máximo do produto."
                },
                precoMin: {
                    required: "informe o preço mínimo do produto",
                },
                intervaloData: {
                    required: "informe o intervalo de data para novos pedidos"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "define-configuracoes.php",
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

</head>
<body>
    <nav>
        <ul>
            <li><a id="navPainel" href="administrador-painel.php">Painel inicial</a></li>
            <li><a id="navConfiguracoes" href="configuracoes-sistema.php">Configurações</a></li>
            <li><a id="navProdutosCad" href="produtos-cadastrados.php">Produtos</a></li>
            <li><a id="navClienteCad" href="clientes-cadastrados.php">Clientes</a></li>
            <li><a href="../logout.php">logout</a></li>
        </ul>
    </nav>

    <div class="tituloTela">
        <h1>Definição de configurações do sistema</h1>
    </div>

    <div class="cadastro" id="cadastro">
        <form method="post" name="formCadastro" id="formCadastro">  
            <div class="campoForm">
                <label for="precoMax">Preço máximo dos produtos</label>
                <input type="number" name="precoMax" id="precoMax" value="<?= $precoMaxProdutos ?>" step="0.01">
            </div>
            <div class="campoForm">
                <label for="precoMin">Preço mínimo dos produtos</label>
                <input type="number" name="precoMin" id="precoMin" value="<?= $precoMinProdutos ?>" step="0.01">
            </div>
            <div class="campoForm">
                <label for="intervaloData">Intervalo de dias para novos pedidos</label>
                <input type="number" name="intervaloData" id="intervaloData" value="<?= $dataIntervaloPedido ?>" step="1">
            </div>
            <div class="campoForm">
                <button class="btnEnviar" id="enviar">Atualizar</button>
            </div>
        </form>  
        <div id="resultado" class="mensagemCadastro"></div>
    </div>

</body>
</html>
