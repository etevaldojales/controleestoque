<?php
$valor_raw = isset($_POST["valor"]) ? $_POST["valor"] : "";
$valor_clean = str_replace('.', '', $valor_raw);
$valor_clean = str_replace(',', '.', $valor_clean);
$valorc = ($valor_clean !== "") ? floatval($valor_clean) : 0.0;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel1">Calculadora</h3>
    </div>
    <div class="modal-body">
    <p>
    <table width="1231" class="table table-bordered table-hover">
        <tr>
            <td colspan="2" align="left"><b>Valor de Compra: <?=number_format($valorc,2,",",".")?></b></td>
        </tr>
        <tr>
            <td align="left" colspan="2">
            	<input type="radio" name="opcao" id="opc1" checked> <b>Acréscimo</b>
                &nbsp;
            	<input type="radio" name="opcao" id="opc2"> <b>Desconto</b>
            </td>
        </tr>
        <tr>
            <td width="102"><b>Percentual:</b></td>
            <td width="1117">
                <input type="text" name="percentual" id="percentual" onclick="this.value=''" class="span2" style="text-align:right" 
                onKeyPress="mascarag(this,mnum)" onKeyDown="mascarag(this,mnum)"> %
            </td>
        </tr>
        <tr>
        	<td class="2">
                <button type="button" class="btn btn-success" onClick="calcular()" id="btnCad">Calcular</button>
            </td>
        </tr>
    </table>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCloseModal">Fechar</button>
	</div>
</div>    