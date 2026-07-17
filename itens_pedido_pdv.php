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

$idcli = !empty($_POST['idcliente']) ? intval($_POST['idcliente']) : $_class->getClientePdv();
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
                        <input type="checkbox" name="chk_multiplas" id="chk_multiplas" onChange="toggleMultiplasFpg(this.checked)"> <span class="sp-formpag"><b>Múltiplas Formas</b></span>
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
                </tr>
                <tr>
                    <td colspan="12">
                        <div id="div_multiplas" style="display: none; margin-top: 15px; border: 1px solid #ccc; padding: 15px; border-radius: 8px; background-color: #fafafa;">
                            <div class="row-fluid">
                                <div class="span4">
                                    <label><b>Dinheiro (R$)</b></label>
                                    <input type="text" class="span12 input_valor_fpg" name="val_dinheiro" id="val_dinheiro" value="0,00" onKeyup="calcularTrocoMultiplas()">
                                </div>
                                <div class="span4">
                                    <label><b>Cartão (R$)</b></label>
                                    <input type="text" class="span12 input_valor_fpg" name="val_cartao" id="val_cartao" value="0,00" onKeyup="calcularTrocoMultiplas()">
                                </div>
                                <div class="span4">
                                    <label><b>Pix (R$)</b></label>
                                    <input type="text" class="span12 input_valor_fpg" name="val_pix" id="val_pix" value="0,00" onKeyup="calcularTrocoMultiplas()">
                                </div>
                            </div>
                            <div class="row-fluid" style="margin-top: 10px; font-size: 13px;">
                                <div class="span4" style="color: #6c757d;">
                                    Total do Pedido: <span style="font-weight: bold; color: #333;" id="disp_total_pedido">R$ <?= number_format($total, 2, ",", ".") ?></span>
                                </div>
                                <div class="span4" style="color: #6c757d;">
                                    Total Pago: <span style="font-weight: bold; color: #333;" id="disp_total_pago">R$ 0,00</span>
                                </div>
                                <div class="span4" id="disp_troco_container" style="color: #6c757d;">
                                    Falta Pagar: <span style="font-weight: bold; color: #d9534f;" id="disp_diferenca">R$ <?= number_format($total, 2, ",", ".") ?></span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <script>
                function toggleMultiplasFpg(checked) {
                    var div = document.getElementById('div_multiplas');
                    var radios = document.getElementsByName('formpag');
                    if (checked) {
                        div.style.display = 'block';
                        for (var i = 0; i < radios.length; i++) {
                            radios[i].disabled = true;
                        }
                        $('.input_valor_fpg').mask('#.##0,00', { reverse: true });
                        calcularTrocoMultiplas();
                    } else {
                        div.style.display = 'none';
                        for (var i = 0; i < radios.length; i++) {
                            radios[i].disabled = false;
                        }
                    }
                }

                function parseMoney(value) {
                    if (!value) return 0;
                    var cleanValue = value.replace(/\./g, '').replace(',', '.');
                    var parsed = parseFloat(cleanValue);
                    return isNaN(parsed) ? 0 : parsed;
                }

                function formatMoney(value) {
                    return value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }

                function calcularTrocoMultiplas() {
                    var totalPedido = parseFloat(document.getElementById('totalPedido').value) || 0;
                    var dinheiro = parseMoney(document.getElementById('val_dinheiro').value);
                    var cartao = parseMoney(document.getElementById('val_cartao').value);
                    var pix = parseMoney(document.getElementById('val_pix').value);
                    
                    var totalPago = dinheiro + cartao + pix;
                    var diferenca = totalPago - totalPedido;
                    
                    document.getElementById('disp_total_pago').innerText = 'R$ ' + formatMoney(totalPago);
                    
                    var dispTrocoContainer = document.getElementById('disp_troco_container');
                    
                    if (diferenca < 0) {
                        dispTrocoContainer.innerHTML = 'Falta Pagar: <span style="font-weight: bold; color: #d9534f;" id="disp_diferenca">R$ ' + formatMoney(Math.abs(diferenca)) + '</span>';
                    } else {
                        dispTrocoContainer.innerHTML = 'Troco: <span style="font-weight: bold; color: #27ae60;" id="disp_diferenca">R$ ' + formatMoney(diferenca) + '</span>';
                    }
                }
                </script>
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