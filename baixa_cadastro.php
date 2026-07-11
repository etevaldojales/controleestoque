<?php
include("config_inicio.php");
require_once($lib."classes/class.pedido.php");
require_once($lib."classes/class.parcela.php");
require_once($lib."classes/class.usuario.php");
require_once($lib."classes/class.utilidades.php");

$_util	 	= new utilidades();
$_pedido 	= new pedido($dbase); 
$_parcela 	= new parcela($dbase);
$_usu		= new usuario($dbase);

$forma		= $_pedido->getFormasPagamento();
$cdpedido	= $_POST["id"];
$pedido		= $_pedido->get($cdpedido);
$num_ped 	= $pedido["numero_pedido"];

$where 		= "where id_pedido = ".$cdpedido;
$ordem		= "order by id";
$parcelas	= $_parcela->getList($where,$ordem);
$entrada   	= $_pedido->getDadosEntrada($cdpedido);
function formataNumero($num) {
	while(strlen($num) < 5) {
		$num = '0'.$num; 		
	}
	return $num;
}
?>
<h5><i class="icon-reorder"></i> PARCELAS GERADAS</h5>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
        <td></td>
    </tr>
    <tr>
    	<td>
    		<table width="100%" border="0" align="left" cellpadding="2" cellspacing="2">
                <tr>
                    <td colspan="12" align="left"><b>Pedido Nº:</b> <?=formataNumero($num_ped)?></td>
                </tr>
                <tr>
                    <td colspan="13" align="left">
                        <select name="formpag" id="formpag" style="width:300px;">
                            <option selected value="">Baixa Manual</option>
                            <?php
                            foreach($forma as $f) {
							?>
                            <option value="<?=$f['id']?>"><?=$f['descricao']?></option>
                            <?php
							}
							?>
                        </select>	
                    </td>
                </tr>
                <?php
                if(is_array($entrada)) {
				?>
                    <tr>
                        <td colspan="12"><hr></td>
                    </tr>
                    <tr bgcolor="#CCCCCC"> 
                        <td width="47" align="center" bgcolor="#EEEEEE"><b>Entrada.</b></td>
                        <td width="97" align="center" bgcolor="#EEEEEE"><b>Vencimento</b></td>
                        <td width="112" align="center" bgcolor="#EEEEEE"><nobr><b>Vlr. Entrada</b></nobr></td>
                        <td width="129" align="center" bgcolor="#EEEEEE"><nobr><b>Vlr. Recebido</b></nobr></td>
                        <td width="137" align="center" bgcolor="#EEEEEE"><nobr><b>Troco</b></nobr></td>
                        <td width="111" align="center" bgcolor="#EEEEEE"><nobr><b>Pago em</b></nobr></td>
                        <td width="137" align="center" bgcolor="#EEEEEE"><nobr><b>Form.Pag</b></nobr></td>
                        <td width="124" align="center" bgcolor="#EEEEEE"><b>Usuário</b></td>
                        <td width="108" align="center" bgcolor="#EEEEEE"><b>Status</b></td>
                        <td width="249" align="center" bgcolor="#EEEEEE" colspan="2"><b>Operações</b></td>
                    </tr>
					<?php					
						$login = $_usu->getLogin($entrada['id_usuario']);
						$status 	= $entrada['flgstatus'] == 1 ? "Pendente" : "Pago";
						$datapag	= $entrada['data_pgto'] != "0000-00-00" ? $_util->dataMySql2Php($entrada['data_pgto']) : "";
						$descfpg 	= $entrada['id_forma_pag'] > 0 ? $_pedido->getDescFormasPag($entrada['id_forma_pag']) : "";
						$valorec 	= $entrada['valor_rec'] == 0 ? $entrada['valor'] : $entrada['valor_rec'];  
						if($entrada['flgstatus'] == 2) {
							$vrdesabilitado = "readonly='readonly'";	
						}
						else {
							$vrdesabilitado = "";	
						}
						if($entrada['flgstatus'] == 1) {
						$troco = $valorec - $entrada['valor'];
						$troco = $troco > 0 ? number_format($troco,2,",",".") : "";	
						?>
						<tr>
							<td align="center">01</td>
							<td align="center"><?=$_util->dataMySql2Php($entrada['vencimento'])?></td>
							<td align="center"><nobr>R$ <?=number_format($entrada['valor'],2,",",".")?></nobr></td>
							<td align="center">
                            <nobr>
								R$ <input type="text" name="val_rec" id="val_rec_entrada" value="<?=number_format($valorec,2,",",".")?>" 
								class="span8" style="direction:rtl" onclick="this.value=''" onkeypress="return(MascaraMoeda(this,'.',',',event))">
                            </nobr>    
							</td>
							<td align="center" id="troco_entrada"><?=$troco?></td>
							<td align="center"><?=$datapag?></td>
							<td align="center"><nobr><?=$descfpg?></nobr></td>
							<td align="center"><?=$login?></td>
							<td align="center"><?=$status?></td>
							<td align="center" colspan="2">
                            <nobr>
							<?php
							if($_SESSION["tipo_usuario"] == 1) {
							?>
								<a href="javascript: void(0)" 
								onclick="baixarEntrada(<?=$entrada['id']?>,document.getElementById('val_rec_entrada').value,'',document.getElementById('formpag').value)" 
								style="text-decoration:none">Baixar</a> 
							<?php
							}
							else {
							?>
								<a href="javascript: void(0)" onclick="baixarEntrada(<?=$entrada['id']?>,document.getElementById('val_rec_entrada').value,'',document.getElementById('formpag').value)" style="text-decoration:none">Baixar</a> 
							<?php
							}
							?>
                            </nobr>
							</td>
						</tr>
						<?php
						}
						else {
						$troco = $valorec - $entrada['valor'];
						$troco = $troco > 0 ? number_format($troco,2,",",".") : "";	
						?>
						<tr>
							<td align="center">01</td>
							<td align="center"><?=$_util->dataMySql2Php($entrada['vencimento'])?></td>
							<td align="center"><nobr>R$ <?=number_format($entrada['valor'],2,",",".")?></nobr></td>
							<td align="center">
								R$ <?=number_format($valorec,2,",",".")?> 
							</td>
							<td align="center"><?=$troco?></td>
							<td align="center"><?=$datapag?></td>
							<td align="center"><nobr><?=$descfpg?></nobr></td>
							<td align="center"><?=$login?></td>
							<td align="center"><?=$status?></td>
                            <td colspan="2">&nbsp;</td>
						</tr>
						<?php
						}
				?>
                <tr>
                	<td colspan="12"><hr></td>
                </tr>
				<?php		
				}
				?>
                <tr bgcolor="#CCCCCC"> 
                    <td width="47" align="center" bgcolor="#EEEEEE"><b>Parc.</b></td>
                    <td width="97" align="center" bgcolor="#EEEEEE"><b>Vencimento</b></td>
                    <td width="112" align="center" bgcolor="#EEEEEE"><nobr><b>Vlr. Parcela</b></nobr></td>
                    <td width="129" align="center" bgcolor="#EEEEEE"><nobr><b>Vlr. Recebido</b></nobr></td>
                    <td width="137" align="center" bgcolor="#EEEEEE"><nobr><b>Troco</b></nobr></td>
                    <td width="111" align="center" bgcolor="#EEEEEE"><nobr><b>Pago em</b></nobr></td>
                    <td width="137" align="center" bgcolor="#EEEEEE"><nobr><b>Form.Pag</b></nobr></td>
                    <td width="124" align="center" bgcolor="#EEEEEE"><b>Usuário</b></td>
                    <td width="108" align="center" bgcolor="#EEEEEE"><b>Status</b></td>
                    <td width="249" align="center" bgcolor="#EEEEEE"><b>Operações</b></td>
                </tr>
                <?php
                if(is_array($parcelas)) {
					$nparc = 1;
					foreach($parcelas as $p) {
						$login = $_usu->getLogin($p['id_usuario']);
						$numparcela = $nparc < 10 ? "0".$nparc : $nparc;
						$status 	= $p['flgstatus'] == 1 ? "Pendente" : "Pago";
						$datapag	= $p['data_pgto'] != "0000-00-00" ? $_util->dataMySql2Php($p['data_pgto']) : "";
						$descfpg 	= $p['id_forma_pag'] > 0 ? $_pedido->getDescFormasPag($p['id_forma_pag']) : "";
						$valorec 	= $p['valor_rec'] == 0 ? $p['valor_parcela'] : $p['valor_rec'];  
						$nosso_numero = $p['nosso_numero'] > 0 ? $p['nosso_numero'] : "";
						if($p['flgstatus'] == 2) {
							$vrdesabilitado = "readonly='readonly'";	
							if($p['nosso_numero'] > 0) {
								$local_baixa = "SANTANDER";
							}
						}
						else {
							$vrdesabilitado = "";	
						}
						if($p['flgstatus'] == 1) {
						$troco = $valorec - $p['valor_parcela'];
						$troco = $troco > 0 ? number_format($troco,2,",",".") : "";	
						?>
						<tr>
							<td align="center"><?=$numparcela?></td>
							<td align="center"><?=$_util->dataMySql2Php($p['vencimento'])?></td>
							<td align="center"><nobr>R$ <?=number_format($p['valor_parcela'],2,",",".")?></nobr></td>
							<td align="center">
                            <nobr>
								R$ <input type="text" name="val_rec" id="val_rec<?=$nparc?>" value="<?=number_format($valorec,2,",",".")?>" 
								class="span8" style="direction:rtl" onclick="this.value=''" onkeypress="return(MascaraMoeda(this,'.',',',event))">
                            </nobr>    
							</td>
							<td align="center" id="troco_parcela"><?=$troco?></td>
							<td align="center"><?=$datapag?></td>
							<td align="center"><nobr><?=$descfpg?></nobr></td>
							<td align="center"><?=$login?></td>
							<td align="center"><?=$status?></td>
							<td align="center">
                            <nobr>
							<?php
							if($_SESSION["tipo_usuario"] == 1) {
							?>
								<a href="javascript: void(0)" 
								onclick="baixarParcela(<?=$p['id']?>,document.getElementById('val_rec<?=$nparc?>').value,'',document.getElementById('formpag').value),'<?=$nparc?>'" style="text-decoration:none">Baixar</a> 
							<?php
							}
							else {
							?>
								<a href="javascript: void(0)" onclick="baixarParcela(<?=$p['id']?>,document.getElementById('val_rec<?=$nparc?>').value,'',document.getElementById('formpag').value)" style="text-decoration:none">Baixar</a> 
							<?php
							}
							?>
                            </nobr>
							</td>
						</tr>
						<?php
						}
						else {
						$troco = $valorec - $p['valor_parcela'];
						$troco = $troco > 0 ? number_format($troco,2,",",".") : "";	
						?>
						<tr>
							<td align="center"><?=$numparcela?></td>
							<td align="center"><?=$_util->dataMySql2Php($p['vencimento'])?></td>
							<td align="center"><nobr>R$ <?=number_format($p['valor_parcela'],2,",",".")?></nobr></td>
							<td align="center">
								R$ <?=number_format($valorec,2,",",".")?> 
							</td>
							<td align="center"><?=$troco?></td>
							<td align="center"><?=$datapag?></td>
							<td align="center"><nobr><?=$descfpg?></nobr></td>
							<td align="center"><?=$login?></td>
							<td align="center"><?=$status?></td>
						</tr>
						<?php
						}
                    $nparc++;
                    }
				}
				?>
   			</table>
    	</td>
    </tr>
    <tr>
    	<td colspan="12" style="height:25px;">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="12">
            <div class="row-fluid text-center">
            <a class="btn btn-primary btn-large hidden-print" onclick="finalizarPedido()">Novo Pedido</a>
            </div>
        </td>
    </tr>
</table>
<div style="clear:both"></div>
