<?php 
include("config_inicio.php");
require_once($lib.'classes/class.empresa.php');

$_empresa = new empresa($dbase);
$qrcode = $_empresa->getQrcode();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel1">QR-Code</h3>
    </div>
    <div class="modal-body">
    <p>
    <table width="1231" class="table table-bordered table-hover">
        <tr>
            <td colspan="2" style="text-align: center;">
                <img src='<?=$qrcode?>' width='200'>
            </td>
        </tr>
    
    </table>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCloseModal">Fechar</button>
	</div>
</div>    
