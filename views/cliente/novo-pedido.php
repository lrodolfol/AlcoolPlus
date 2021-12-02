<?php
require '../layouts/cabecalhoPainel.php';
require_once '../../entidades/classes/Estabelecimento.php';
require_once '../../entidades/classes/Produto.php';

use entidades\classes\Estabelecimento;
use entidades\classes\Produto;

$estabelecimento = new Estabelecimento();
$estabelecimentos = $estabelecimento->estabelecimentosAtivos();

$produto = new Produto();
$produtos = $produto->produtos();

$quantidadePedido = (empty($_SESSION['quantidadePedido']) ? null : $_SESSION['quantidadePedido']);
?>

<?php
$retornaVrMonetario = function(float $valor) {
    return number_format($valor, 2, ',', '.');
}
?>

<script>
    $(document).ready(function () {
        $(navNovoPedido).css({"color": "red"});
    });
</script>


<script>
    $(function () {
        $("#formCadastro").validate({
            rules: {
                produto: {
                    required: true
                },
                estabelecimento: {
                    required: true
                },
                quantidade: {
                    required: true
                }
            },
            messages: {
                produto: {
                    required: "informe o produto."
                },
                estabelecimento: {
                    required: "informe o estabelecimento."
                },
                quantidade: {
                    required: "Informe a quantidade."
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "efetua-pedido.php",
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

<title>Alcool+ Painel do Cliente (Novo pedido)</title>
</head>
<body>
    <nav>
        <ul>
            <li><a id="navPainel" href="cliente-painel.php">Painel inicial</a></li>
            <li><a id="navNovoPedido" href="novo-pedido.php">Fazer novo pedido</a></li>
            <li><a href="../logout.php">logout</a></li>
        </ul>
    </nav>

    <div class="tituloTela">
        <h1>Novo pedido</h1>
    </div>

    <article>
        <?php if (!$estabelecimentos): ?>
            <div class="aviso">
                <p>Infelizmente não temos nenhum forncedor cadastrado.</p>
                <p>Tente novamente mais tarde.</p>
            </div>

        <?php elseif (!$produtos): ?>
            <div class="aviso">
                <p>Infelizmente não temos nenhum produto cadastrado.</p>
                <p>Tente novamente mais tarde.</p>
            </div>

        <?php elseif (!$quantidadePedido): ?>
            <div class="aviso">
                <p>Que pena, você ainda não pode realizar nenhum pedido.</p>
                <p>Você precisa aguar o tempo determinado para novos pedidos</p>
            </div>

        <?php else: ?>
            <div class="cadastro" id="cadastro">
               <form method="post" name="formCadastro" id="formCadastro">  
                <div class="campoForm">
                    <label for="produto">Produto</label>
                    <select name="produto" id="produto">
                        <option></option>
                        <?php foreach ($produtos as $key => $value) : ?>
                            <option value="<?= $value->codigo ?>"> <?= $value->descricao . " | R$ " . $retornaVrMonetario($value->valor) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="campoForm">
                    <label for="estabelecimento">Fornecedor</label>
                    <select name="estabelecimento" id="estabelecimento">
                        <option></option>
                        <?php foreach ($estabelecimentos as $estab) : ?>
                            <option value="<?= $estab->codigo ?>"> <?= strtoupper($estab->razao_social) . " | " . $estab->cidade ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="campoForm">
                    <label for="quantidade">Quantidade</label>
                    <select name="quantidade" id="quantidade">
                        <option></option>
                        <?php for ($i = 1; $i <= $quantidadePedido; $i++): ?>
                            <option><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="campoForm">
                    <button class="btnEnviar" id="enviar">Realizar pedido</button>
                </div>

                <div id="resultado" class="mensagemCadastro"></div>
               </form>  
            </div>

        <?php endif; ?>


    </article>


</body>
</html>

