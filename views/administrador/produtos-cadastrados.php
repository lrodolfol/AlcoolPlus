<?php
require '../layouts/cabecalhoPainel.php';
require_once '../../entidades/classes/Produto.php';

use entidades\classes\Produto;

$produto = new Produto();
$produtos = $produto->produtos();
$totalValorProdutos = 0;
?>

<script>
    $(document).ready(function () {
        $(navProdutosCad).css({"color": "red"});
    });
</script>

<title>Alcool+ Painel do Cliente (Novo pedido)</title>
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

    <article>
        <?php if (!$produtos): ?>
            <div class="aviso">
                <p> Os fornecedores ainda não cadastraram nenhum produto.</p>
            </div>
        <?php else: ?>
            <div class="tituloTela">
                <h1>Lista de Produtos</h1>
            </div>

            <table>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>
                <?php foreach ($produtos as $prod): ?>
                    <tr>
                        <td><?= $prod->descricao ?></td>
                        <td><?= 'R$ ' . number_format($prod->valor, 2, ',', '.') ?></td>
                    </tr>
                    <?php $totalValorProdutos = ($totalValorProdutos + $prod->valor); ?>
                <?php endforeach; ?>

            </table>
            <div class="aviso">
                <?= "<p>Valor total em produtos: R$ " . number_format($totalValorProdutos, 2, ',', '.') . "</p>"; ?>
            </div>
        <?php endif; ?>
    </article>

</body>
</html>

