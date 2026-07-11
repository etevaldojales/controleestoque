<?php
include("config_inicio.php");
require_once($lib.'classes/class.parcela.php');

$_class    	= new parcela($dbase);
;
$id			= $_POST['id']; 
$dados		= $_class->get($id);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel1">Estorno Parcela</h3>
    </div>
    <div class="modal-body">
    <p>
    
    <table class="table table-bordered table-hover">
        <form name="frmestorno" id="frmestorno" method="post" action="#">
            <tr>
                <td width="9%" class="hidden-phone"><strong>Data de Vencimento:</strong></td>
                <td width="20%" class="hidden-phone">
                    <input name="dtvenc" id="dtvenc" type="text" size="10" onclick="this.value=''" onkeydown="mascarag(this,mdata)" maxlength="10"/>
                </td>
            </tr>
            <tr>
                <td class="hidden-phone" colspan="2" align="center">
					<button type="button" class="btn btn-success" onClick="validarEstorno(<?=$id?>)" id="btnCad">Estornar</button>
                </td>
            </tr>
        </form>    
    </table>
    </p>
    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCloseModal">Fechar</button>
	</div>
</div>