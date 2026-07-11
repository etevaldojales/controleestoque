<?php
include("config_inicio.php");
require_once($lib . 'classes/class.cliente.php');
require_once($lib . 'classes/class.utilidades.php');
require_once($lib . 'classes/class.produto.php');
require_once($lib . 'classes/class.pedido.php');

$_class = new cliente($dbase);
$_pedido = new pedido($dbase);
$_produto = new produto($dbase);
$_util = new utilidades();

$idcli = $_class->getClientePdv();
//echo "id_cliente: " . $idcli;
$cliente = $_class->get($idcli);
// verificar pedido do cliente em aberto
$pedido = $_pedido->getPedido($idcli);

$usu = $_SESSION["usuario"];
if (is_array($pedido)) {
    //carregar o id do pedido
    $idpedido = $pedido['id'];
    $itens = $_pedido->getItens($idpedido);
} else {
    //cadastrar pedido para o cliente
    $itens = [];
} 

//print_r($itens);

$where = "where stativo = 1 and id <> 5";
$ordem = 'order by nome';
$dados = $_class->getList($where, '', $ordem);
?>
<style>
    .total-display {
        font-size: 1.2rem;
        font-weight: bold;
        text-align: right;
        margin-top: 15px;
    }

    .formpag {
        margin-top: 5px;
    }
    .lntable {
        font-size: 0.8rem;
        text-align: center;
    }
</style>

<div class="span12">
    <!-- BEGIN EXAMPLE TABLE widget-->
    <div class="widget">
        <div class="widget-title">
            <h4><i class="icon-reorder"></i> ITENS</h4>
        </div>
        <table style="width: 100%;" class="table">
            <tr style="background-color: #DCDCDC;">
                <th class="lntable" width="60">Cod.</th>
                <th class="lntable" width="80">Qtd</th>
                <th class="lntable" width="160">Produto</th>
                <th class="lntable" width="80">Preço</th>
                <th class="lntable" width="80">Total</th>
                <th class="lntable" width="36" style="text-align: center">Excluir</th>
            </tr>
            <?php
            if (is_array($itens)) {
                $total = 0;
                $total_custo = 0;
                $total_venda = 0;
                $x = 1;
                foreach ($itens as $i) {
                    $produto = $_produto->get($i['id_produto']);
                    //$marca = $_produto->getMarca($produto['id_marca']);
                    //$forn = $_produto->getFornecedor($produto['id_fornecedor']);
                    $valorv = $i['valor_unitario'] == 0 ? "" : number_format($i['valor_unitario'], 2, ",", ".");
                    $total += $i['valor_total'];
                    $total_custo += ($i['valor_unitario_compra'] * $i['quantidade']);
                    $total_venda += ($i['valor_unitario'] * $i['quantidade']);
                    $corLinha = $x % 2 == 1 ? "" : "#DCDCDC";
                    $und = $produto['unidade'] == 1 ? "Und" : "Kg";
                    ?>
                    <tr>
                        <td class="lntable"><?= $produto['codigo'] ?></td>
                        <td class="lntable"><?=$i['quantidade'] . " " . $und ?></td>
                        <td class="lntable"><?= $produto['nome'] ?></td>
                        <td class="lntable"><?= $valorv ?></td>
                        <td class="lntable" style="margin-left: 30px"><?= number_format($i['valor_total'], 2, ",", ".") ?></td>
                        <td class="lntable" style="text-align: center">
                            <a href="javascript: void(0)"  onClick="excluirItemPdv(<?= $i['id'] ?>)"  style="border: none; background-color: transparent; color: #ff0000; text-align: center;">
                                <i class="icon-trash icon-white "></i></a>
                        </td>
                    </tr> 
                    <?php
                    $x++;
                }
                ?>
                <tr>
                    <td colspan="5">
                        <div class="span4 invoice-block pull-right">
                            <ul class="unstyled amounts">
                                <li class="total-display">
                                    <nobr><strong>Total :</strong> R$ <?= number_format($total, 2, ",", ".") ?></nobr>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="9">
                        <div class="widget-title">
                            <h4><i class="icon-credit-card"></i> Forma de Pagamento</h4>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <input type="hidden" name="totalPedido" id="totalPedido" value="<?= $total ?>">
                        <input type="radio" name="formpag" id="formpag2" value="2" checked> <span
                            class="sp-formpag">Cartão</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="formpag" id="formpag1" value="1"> <span class="sp-formpag">Dinheiro</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="formpag" id="formpag3" value="3" onblur="showQrcode()" data-toggle="modal"
                            href="#myModal1"> <span class="sp-formpag">Pix</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a onClick="calculadora()" data-toggle="modal" href="#myModal1" style="text-decoration:none">
                            <img src="img/calculator.png" border="0" title="Calcular Troco">
                        </a>
                    </td>
                    <td colspan="7">
                        <table id="complemento_pg" style="display: none; width: 100%;">
                            <tr>
                                <td>
                                    <input type="hidden" name="numparc" id="numparc" value="1">
                                </td>
                                <td>
                                    <input type="date" name="primvenc" id="primvenc" value="<?= date("Y-m-d") ?>">
                                </td>
                            </tr>
                        </table>
                    </td>
                <tr>
                    <td colspan="9">
                        <div class="row-fluid text-center" style="margin-top: 20px;">
                            <a class="btn btn-success btn-large hidden-print" href="javascript: void(0)"
                                style="border-radius: 10px;" id="btnFinaliza"
                                onClick="concluirPedidoPdv(<?= $idpedido ?>, <?= $total ?>, <?= $total_custo ?>, <?= $total_venda ?>)">Finalizar Venda</a>
                        </div>
                    </td>
                    <input type="hidden" name="data" id="data" value="<?= date("Y-m-d") ?>" />
                    <input type="hidden" name="obs" id="obs"

                </tr>
                <?php
            } else {
                ?>
                <tr>
                    <td colspan="9">Pedido não cadastrado</td>
                </tr>
            <?php
            }
            ?>
        </table>

    </div>
    <!-- END EXAMPLE TABLE widget-->
</div>
<iframe src="#" frameborder="1" style="width: 100%; display: none" id="frmimpressao"></iframe>