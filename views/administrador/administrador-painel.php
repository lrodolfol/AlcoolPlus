<?php
require '../layouts/cabecalhoPainel.php';
require_once '../../entidades/classes/Estabelecimento.php';
require_once '../../entidades/classes/Administrador.php';

use entidades\Classes\Estabelecimento;
use entidades\classes\Administrador;

$estabelecimento = new Estabelecimento();
$estabelecimentos = $estabelecimento->estabelecimentosInativos();

$codigoAdm = $_SESSION['codigo'];
$administrador = new Administrador();
$administrador->setCodigo($codigoAdm);
$administrador = $administrador->administrador()
?>

<script>
    $(document).ready(function () {
        $('#cnpjFornecedor').mask('99.999.999/9999-99');
    });
</script>

<script>
    $(document).ready(function () {
        $(navPainel).css({"color": "red"});
    });
</script>

<title>Alcool+ Painel do Adm</title>
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
        <h1>Painel do Adm</h1>
    </div>

    <article>
        <?php if (!$estabelecimentos): ?>
            <div class="aviso">
                <p>Sem novos cadastro de fornecedores</p>
            </div>
        <?php else: ?>
            <div class="aviso">
                <p>Fornecedores aguardando liberação</p>
            </div>
            <table>
                <tr>
                    <th>CNPJ</th>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>Liberar</th>
                </tr>
                <?php foreach ($estabelecimentos as $estab): ?>
                    <tr>
                        <td id="cnpjFornecedor"><?= $estab->cnpj ?></td>
                        <td><?= $estab->razao_social ?></td>
                        <td><?= $estab->cidade ?></td>
                        <?php $codEstab = $estab->codigo; ?>
                        <td><a href="libera-estabelecimento.php?codEstabelecimento=
                               <?= $codEstab; ?>" > <img src="../../public/images/check.png" alt="liberar fornecedor"></a></td>
                    </tr>
                <?php endforeach; ?>

            <?php endif; ?>
        </table>
    </article>


</body>
</html>

