<?php
require '../layouts/cabecalhoPainel.php';
require_once '../../entidades/classes/Cliente.php';

use entidades\classes\Cliente;

$cliente = new Cliente();
$clientes = $cliente->clientes();
?>

<script>
    $(document).ready(function () {
        $(navClienteCad).css({"color": "red"});
        $('#cpfCliente').mask('999.999.999-99');
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
        <?php if (!$clientes): ?>
            <div class="aviso">
               <p> Ainda nao temos nenhum cliente cadastrado.</p>
            </div>
        <?php else: ?>
            <div class="tituloTela">
                <h1>Lista de Clientes</h1>
            </div>

            <table>
                <tr>
                    <th>CPF</th>
                    <th>Nome</th>
                </tr>
                <?php foreach ($clientes as $cli): ?>
                    <tr>
                        <td id="cpfCliente"><?= $cli->cpf ?></td>
                        <td><?= $cli->nome ?></td>
                    </tr>
                <?php endforeach; ?>

                </nav>
            <?php endif; ?>


    </article>


</body>
</html>

