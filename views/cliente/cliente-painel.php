<?php
require '../layouts/cabecalhoPainel.php';
require_once '../../entidades/classes/Configuracoes.php';
require_once '../../entidades/classes/Cliente.php';
require_once '../../entidades/classes/Pedido.php';
?>

<?php
use entidades\classes\Configuracoes;
use entidades\Classes\Cliente;
use entidades\Classes\Pedido;

$objDados = (Object) $_SESSION;

$configuracao  = new Configuracoes();
$configuracao = $configuracao->buscaConfiguracoes();

$cliente = new Cliente();
$cliente->setCodigo($objDados->codigo);

$dataHoje = date_create();
//USANDO ESSA FUNÇÃO RETORNAR OS DOIS ULTIMOS PEDIDO DO CLIENTE.
//DESSA FORMA SERÁ POSSIVEL SABER SE ELE PODE OU NÃO REALIZAR UM NOVO PEDIDO
$pedido = new Pedido();
$ultimosPedidos = $pedido->ultimosPedidosCliente($cliente);

//APÓS RETORNADO OS DOIS ULTIMOS PEDIDOS, SERÁ VERIFICADO A DIFERENÇA ENTRE AS DUAS DATAS.
//SE MAIOR IGUA A 15 DIAS, O CLIENTE PODE FAZER NOVO PEDIDO
//SE MENOR QUE 15, SERÁ VERIFICADO A QUANTIDADE TOTAL DE PEDIDOS
//SE MAIOR QUE 2, USUARIO NAO PODE FAZER PEDIDOS, SE MENOR QUE 2, USUARIO PODE FAZER PEDIDOS.
$diferencaDatas = 30;
$totalUltimosPedidos = 0;
$pedidoSolicitar = 0;

if (isset($ultimosPedidos)) {
    $ultimosPedidos = get_object_vars($ultimosPedidos);
    if (count($ultimosPedidos) > 1) {
        $dataPenultimoPedido = date_create($ultimosPedidos[1]->data_pedido);
        $dataUltimoPedido = date_create($ultimosPedidos[0]->data_pedido);
        $diferencaDatas = date_diff($dataUltimoPedido, $dataPenultimoPedido)->days;
        $totalUltimosPedidos = $ultimosPedidos[0]->quantidade + $ultimosPedidos[1]->quantidade;
        
        if ($diferencaDatas > 15) {
            if ($totalUltimosPedidos == 0) {
                $pedidoSolicitar = 2;
            } elseif ($totalUltimosPedidos > 0 && $totalUltimosPedidos <= 2) {
                $pedidoSolicitar = 1;
            }
        } elseif ($diferencaDatas <= 15 && $totalUltimosPedidos < 2) {
            $pedidoSolicitar = 1;
        } elseif (date_diff($dataHoje, $dataUltimoPedido)->days > 15) {
            $pedidoSolicitar = 2;
        }
    } elseif (count($ultimosPedidos) == 1) {
        $dataUltimoPedido = date_create($ultimosPedidos[0]->data_pedido);
        if($ultimosPedidos[0]->quantidade >= 2) {
            $pedidoSolicitar =  (date_diff($dataHoje, $dataUltimoPedido)->days > 15) ? 2 : 0;
        }else{
            $pedidoSolicitar = (date_diff($dataHoje, $dataUltimoPedido)->days < 15) ? 1 : 0;
        }
    } 
}else{
    $pedidoSolicitar = 2;
}



$pedido = new Pedido();
$pedidoCliente = $pedido->buscaPedidoCliente($cliente);
$quantidadePedido = 0;
?>

<?php
/*
 * FUNÇÃO RÁPIDA PARA CALCULAR DIFERENÇA ENTRE DUAS DATAS
 */
$calculaDiferencaData = function ($dataInicial) {
    $dataHoje = date_create(DATE('Y-m-d'));
    $dataHoje = $dataHoje->format("Y-m-d");
    $diferenca = strtotime($dataInicial) - strtotime($dataHoje);
    $dias = floor($diferenca / (60 * 60 * 24));

    return $dias;
}
?>

<script>
    $(document).ready(function () {
        $(navPainel).css({"color": "red"});
    });
</script>

<title>Alcool+ Painel do Cliente</title>
</head>
<body>
    <nav>
        <ul>
            <li><a id="navPainel" href="cliente-painel.php">Painel inicial</a></li>
            <li><a href="novo-pedido.php">Fazer novo pedido</a></li>
            <li><a href="../logout.php">logout</a></li>
        </ul>
    </nav>

    <div class="tituloTela">
        <h1>Meus pedidos</h1>
    </div>

    <article>

        <?php if (!$pedidoCliente): ?>
            <div class="aviso">
                <p>Você ainda não fez nenhum pedido. </p>
                <p>Que tal fazer seu primeiro pedido agora?</p>
            </div>
        <?php else: ?>
            <table>
                <tr>
                    <th>Data pedido</th>
                    <th>Fornecor</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($pedidoCliente as $pedido): ?>
                    <tr>
                        <?php $dataPedido = new DateTime($pedido->data_pedido); ?>
                        <td><?= $dataPedido->format('d/m/Y'); ?></td>
                        <td><?= strtoupper($pedido->razao_social); ?></td>
                        <td><?= $pedido->descricao; ?></td>
                        <td><?= $pedido->quantidade; ?></td>
                        <td><?= ($pedido->entregue == "S") ? "<em style='color: green'>Entregue</em>" : "<em style='color: black'>Em análise</em>"; ?></td>
                    </tr>
                    <?php
                    $dataProximoPedido = $pedido->data_pedido;
                    $quantidadePedido = $pedido->quantidade;
                    ?>
                <?php endforeach; ?>
                <?php
                $dataProximoPedido = date("Y-m-d", strtotime("+15days", strtotime($dataProximoPedido)));
                ?>
            </table>
            <div class="aviso">
                <?php $diasNovoPedido = $calculaDiferencaData(date('Y/m/d', strtotime($dataProximoPedido))); ?>

                <?php if ($pedidoSolicitar <= 0): ?>
                    <p><i><?= "Você poderá realizar um novo pedido em {$diasNovoPedido} dias" ?></i></p>
                <?php elseif ($pedidoSolicitar == 1): ?>	
                    <p><i><?= "Você ainda pode realizar um pedido com até 1 produto" ?></i></p>
                <?php else: ?>
                    <p><i><?= "Você pode realizar um novo pedido com até 2 produtos" ?></i></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php $_SESSION['quantidadePedido'] = $pedidoSolicitar; ?>

    </article>


</body>
</html>
