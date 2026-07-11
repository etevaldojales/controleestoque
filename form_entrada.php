<?php
include("config_inicio.php");
require_once($lib.'classes/class.pedido.php');

$_class    	= new pedido($dbase);
;

$codigo 	= $_POST['codigo'];
$pedido		= $_class->get($codigo);
$numpedido	= $pedido['numero_pedido'] > 9 ? $pedido['numero_pedido'] : "0".$pedido['numero_pedido']; 
$forma		= $_class->getFormasPagamento();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel1">Cadastro de Entrada - Pedido: <?=$numpedido?></h3>
    </div>
    <div class="modal-body">
    <p>
    
    <table class="table table-bordered table-hover">
        <form name="frmEntrada" id="frmEntrada" method="post" action="#">
            <tr>
                <td width="9%" class="hidden-phone"><strong>Forma Pagamento:</strong></td>
                <td width="20%" class="hidden-phone">
                    <select name="formpgentrada" id="formpgentrada">
                        <?
                        foreach($forma as $f) {
                        ?>
                            <option value="<?=$f['id']?>"><?=$f['descricao']?></option>
                        <?
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="9%" class="hidden-phone"><strong>Data Pagamento:</strong></td>
                <td width="20%" class="hidden-phone">
					<input name="dtentrada" id="dtentrada" type="text" class="span4" onclick="this.value=''" onkeydown="mascarag(this,mdata)" maxlength="10"
                    value="<?=date("d/m/Y")?>"/>
                </td>
            </tr>
            <tr>
                <td width="9%" class="hidden-phone"><strong>Valor:</strong></td>
                <td width="20%" class="hidden-phone">
					<input type="text" name="valor_entrada" id="valor_entrada" class="span4" onkeypress="return(MascaraMoeda(this,'.',',',event))" 
                    style="text-align:right">
                </td>
            </tr>
            <tr>
                <td width="9%" class="hidden-phone"><strong>Recibo:</strong></td>
                <td width="20%" class="hidden-phone">
					<input type="text" name="recibo_entrada" id="recibo_entrada" class="span4">
                </td>
            </tr>
            <tr>
                <td class="hidden-phone" colspan="2" align="center">
					<button type="button" class="btn btn-success" onClick="validarEntrada()" id="btnCad">Cadastrar</button>
                </td>
            </tr>
            <input type="hidden" name="codpedido" id="codpedido" value="<?=$codigo?>">
        </form>    
    </table>
    </p>
    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCloseModal">Fechar</button>
	</div>
</div>