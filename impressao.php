<?php
include("config_inicio.php");
require_once($lib . 'classes/class.empresa.php');
require_once($lib . 'classes/class.pedido.php');
require_once($lib . 'classes/class.produto.php');
require_once($lib . 'classes/class.usuario.php');

require_once($lib . 'classes/class.utilidades.php');

$_class = new empresa($dbase);
$_util = new utilidades();
$_produto = new produto($dbase);
$_pedido = new pedido($dbase);
$_usu = new usuario($dbase);

$idpedido = $_SESSION["codpedido"];
$pedido = $_pedido->get($idpedido);
$empresa = $_class->get(1);
$itens = $_pedido->getItens($idpedido);
$usu = $_usu->get($pedido['id_usuario']);

function formataNumero($num)
{
    while (strlen($num) < 5) {
        $num = '0' . $num;
    }
    return $num;
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title><?= $empresa['nome'] ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="css/style_responsive.css" rel="stylesheet" />

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body style="background-color: white;">
    <!-- BEGIN HEADER -->
    <!-- END HEADER -->
    <!-- BEGIN CONTAINER -->
    <div>
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN EXAMPLE TABLE widget-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i> <?= $empresa['nome'] ?> - PEDIDO Nº
                                <?= formataNumero($pedido['numero_pedido']) ?>
                            </h4>
                        </div>
                        <div class="widget-body">
                            <div class="portlet-body">
                                <div class="span4">
                                    <h4>
                                        <nobr><?= isset($empresa['descricao']) ? $empresa['descricao'] : ''?></nobr>
                                    </h4>

                                    <p>
                                        <nobr><b>Endereço:</b> <?= $empresa['endereco'] ?></nobr><br>
                                        <nobr><b>Telefone:</b> <?= $empresa['telefone'] ?></nobr><br>
                                        <nobr><b>E-mail:</b> <?= $empresa['email'] ?></nobr><br>
                                        <nobr><b>Data Pedido:</b> <?= $_util->dataMySql2Php($pedido['data_pedido']) ?></nobr><br>

                                    </p>
                                </div>
                                <div class="space15"></div>
                                <div class="row-fluid">
                                    <div style="clear:both"></div>
                                    <div id="lista_detalhe">
                                        <table class="table table-hover invoice-input">
                                            <tr style="background-color: #C0C0C0;">
                                                <th style="text-align: center;">QTD</th>
                                                <th style="width: 50%; text-align: center;">PRODUTO</th>
                                                <th style="text-align: center;">VALOR</th>
                                            </tr>
                                            <?php
                                            if (is_array($itens)) {
                                                $total = 0;
                                                foreach ($itens as $i) {
                                                    $produto = $_produto->get($i['id_produto']);
                                                    $marca = $_produto->getMarca($produto['id_marca']);
                                                    $forn = $_produto->getFornecedor($produto['id_fornecedor']);
                                                    $total += $i['valor_total'];
                                                    $und = $produto['unidade'] == 2 ? "Kg" : "Und";
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: center"><?= $i['quantidade'] . " " . $und ?></td>
                                                        <td><?= $produto['nome'] ?></td>
                                                        <td style="text-align: right;">R$
                                                            <?= number_format($i['valor_total'], 2, ",", ".") ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="3" style="text-align: right">
                                                        <div class="span4 invoice-block pull-right">
                                                            <ul class="unstyled amounts">
                                                                <li><strong>TOTAL :</strong> R$
                                                                    <?= number_format($total, 2, ",", ".") ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <b>Usuário:</b> <?= $usu['nome'] ?>
                                                    </td>
                                                    <td style="text-align: right;">
                                                        <b>Fortaleza, <?= date("d/m/Y H:i") ?></b>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                    <div class="space20"></div>
                                    <div class="space20"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE widget-->
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END CONTAINER -->
    <!-- Load javascripts at bottom, this will reduce page load time -->
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="js/jquery.blockui.js"></script>
    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
    <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        jQuery(document).ready(function () {
            // initiate layout and plugins
            App.init();
            window.print();
            setTimeout('parent.redirecionar()', 500);
        });
    </script>
    <!-- END JAVASCRIPTS -->

    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="js/scripts.js"></script>

</body>
<!-- END BODY -->

</html>