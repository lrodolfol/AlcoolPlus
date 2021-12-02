<?php
require '../layouts/cabecalhoPainel.php';

$objDados = (Object) $_SESSION;

require_once '../../entidades/classes/Estabelecimento.php';
require_once '../../entidades/classes/Pedido.php';

use entidades\Classes\Estabelecimento;
use entidades\Classes\Pedido;

$estabelecimento = new Estabelecimento();
$estabelecimento->setCodigo($objDados->codigo);

$pedido = new Pedido();
$pedidoEstabelecimento = $pedido->buscaPedidoEstabelecimento($estabelecimento);
?>

<script>
    $(document).ready(function () {
        $(navPainel).css({"color": "red"});
    });
</script>

<title>Alcool+ Painel do Fornecedor</title>
</head>
<body>
    <nav>
        <ul>
            <li><a id="navPainel" href="estabelecimento-painel.php">Painel inicial</a></li>
            <li><a href="novo-produto.php">Cadastrar novo produto</a></li>
            <li><a href="../logout.php">logout</a></li>
        </ul>
    </nav>

    <div class="tituloTela">
        <h1>Pedidos de produtos</h1>
    </div>

    <article>
        <?php if (!$pedidoEstabelecimento): ?>
            <div class="aviso">
                <p>Nenhum pedido até agora</p>
            </div>
        <?php else: ?>
            <table>
                <tr>
                    <th>Data do pedido</th>
                    <th>Cliente</th>
                    <th>Prioridade</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Status</th>
                    <th>Entregar</th>
                </tr>
                <tr>
                    <?php foreach ($pedidoEstabelecimento as $pedido): ?>
                        <?php $dataPedido = new DateTime($pedido->data_pedido); ?>
                        <td><?= $dataPedido->format('d/m/Y'); ?></td>
                        <td><?= ucfirst($pedido->nome); ?></td>
                        <td><?= $pedido->prioridade; ?></td>
                        <td><?= $pedido->descricao; ?></td>
                        <td><?= $pedido->quantidade; ?></td>
                        <td id="status"><?= ($pedido->entregue) == "N" ? "<em style='color: red'>não entregue</em>" : "<em>entregue</em>"; ?></td>
                        <?php if ($pedido->entregue == "N"): ?>
                            <td><a id="imgEntrega" href="entrega-pedido.php?codPedido=<?= $pedido->codigo_pedido ?>"><img src="../../public/images/check.png"></a></td>
                                <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </article>


</body>
</html>
