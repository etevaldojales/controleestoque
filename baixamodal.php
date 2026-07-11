<?
include("config_inicio.php");
require_once($lib."classes/class.pedido.php");
require_once($lib."classes/class.parcela.php");
require_once($lib."classes/class.usuario.php");
require_once($lib."classes/class.utilidades.php");
require_once($lib."classes/class.cliente.php");
require_once($lib."classes/class.bancos.php");

$_util	 	= new utilidades();
$_pedido 	= new pedido($dbase); 
$_parcela 	= new parcela($dbase);
$_cliente 	= new cliente($dbase);
$_usu		= new usuario($dbase);
$_bancos 	= new bancos($dbase);

$banco 		= $_bancos->get(1);
$forma		= $_pedido->getFormasPagamento();
$cdpedido	= $_POST["id"];
$_SESSION["codpedido"] = $cdpedido;
$pedido		= $_pedido->get($cdpedido);
$num_ped 	= $pedido["numero_pedido"];

$where 		= "where id_pedido = ".$cdpedido;
$ordem		= "order by id";
$parcelas	= $_parcela->getList($where,$ordem);
$entrada   	= $_pedido->getDadosEntrada($cdpedido);
$credito	= $_cliente->getSaldo($pedido['id_cliente']);
$saldo		= $credito > 0 ? number_format($credito,2,",",".") : "";
$stilodb	= $credito <= 0 ? "display:none" : ""; 
//print_r($parcelas);

function formataNumero($num) {
	while(strlen($num) < 5) {
		$num = '0'.$num; 		
	}
	return $num;
}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel1">Parcelas do Pedido: <?=formataNumero($num_ped)?></h3>
    </div>
    <div class="modal-body">
    <p>
    <table width="1231" class="table table-bordered table-hover">
        <tr>
            <td colspan="4" align="left"><b>Pedido Nº:</b> <?=formataNumero($num_ped)?></td>
        </tr>
        <tr>
            <td align="left" colspan="6">
                <select name="formpag" id="formpag" style="width:300px;">
                    <option selected value="">Baixa Manual</option>
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
            <td width="116"><b>Crédito:</b></td>
            <td width="189">
                <input type="text" name="val_credito" id="val_credito" onclick="this.value=''" onkeypress="return(MascaraMoeda(this,'.',',',event))" 
                class="span10" style="text-align:right">
            </td>
            <td width="311">
                <input type="button" value="Inserir Crédito" class="btn btn-success" 
                onclick="inserirCredito(<?=$pedido['id_cliente']?>,document.getElementById('val_credito').value,<?=$cdpedido?>)">
            </td>
            <td width="89" style="text-align:left;<?=$stilodb?>"><b>Saldo:</b></td>
            <td width="167">
                <input type="text" name="val_saldo" id="val_saldo" onclick="this.value=''" onkeypress="return(MascaraMoeda(this,'.',',',event))" 
                class="span10" style="text-align:right;<?=$stilodb?>" value="<?=$saldo?>">
            </td>
            <td width="331">
                <input type="button" value="Debitar Crédito" class="btn btn-success" 
                onclick="baixarCredito(<?=$pedido['id_cliente']?>,document.getElementById('val_saldo').value,<?=$cdpedido?>,<?=$saldo?>)" 
                style="text-align:center;<?=$stilodb?>">
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-hover">
        <?
        if(is_array($entrada)) {
        ?>
            <tr>
                <td colspan="12"><hr></td>
			</tr>
            <tr bgcolor="#CCCCCC"> 
				<td width="47" align="center" bgcolor="#EEEEEE">Entrada.</td>
				<td width="97" align="center" bgcolor="#EEEEEE">Vencimento</td>
				<td width="112" align="center" bgcolor="#EEEEEE"><nobr>Vlr. Entrada</nobr></td>
				<td width="129" align="center" bgcolor="#EEEEEE"><nobr>Vlr. Recebido</nobr></td>
				<td width="137" align="center" bgcolor="#EEEEEE"><nobr>Troco</nobr></td>
				<td width="111" align="center" bgcolor="#EEEEEE"><nobr>Pago em</nobr></td>
				<td width="137" align="center" bgcolor="#EEEEEE"><nobr>Form.Pag</nobr></td>
				<td width="124" align="center" bgcolor="#EEEEEE">Usuário</td>
				<td width="108" align="center" bgcolor="#EEEEEE">Status</td>
				<td width="249" align="center" bgcolor="#EEEEEE" colspan="2">Operações</td>
            </tr>
			<?					
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
                        class="span10" style="direction:rtl" onclick="this.value=''" onkeypress="return(MascaraMoeda(this,'.',',',event))">
                    </nobr>    
                    </td>
					<td align="center"><?=$troco?></td>
                    <td align="center"><?=$datapag?></td>
                    <td align="center"><nobr><?=$descfpg?></nobr></td>
                    <td align="center"><?=$login?></td>
                    <td align="center"><?=$status?></td>
                    <td align="center" colspan="2">
                    <nobr>
                    <?
                    if($_SESSION["tipo_usuario"] == 1) {
                    ?>
                        <a href="javascript: void(0)" 
                        onclick="baixarEntrada(<?=$entrada['id']?>,document.getElementById('val_rec_entrada').value,'',document.getElementById('formpag').value)" 
                        style="text-decoration:none" class="btn btn-success">Baixar</a> 
                    <?
                    }
                    else {
                    ?>
                        <a href="javascript: void(0)" onclick="baixarEntrada(<?=$entrada['id']?>,document.getElementById('val_rec_entrada').value,'',document.getElementById('formpag').value)" style="text-decoration:none" class="btn btn-success">Baixar</a> 
                    <?
                    }
                    ?>
                    </nobr>
                    </td>
                </tr>
                <?
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
                        <nobr>R$ <?=number_format($valorec,2,",",".")?></nobr> 
                    </td>
					<td align="center"><?=$troco?></td>
                    <td align="center"><?=$datapag?></td>
                    <td align="center"><nobr><?=$descfpg?></nobr></td>
                    <td align="center"><?=$login?></td>
                    <td align="center"><?=$status?></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <?
                }
        ?>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <?		
        }
        ?>
        <tr bgcolor="#CCCCCC"> 
			<td width="47" align="center" bgcolor="#EEEEEE">Parc.</td>
			<td width="97" align="center" bgcolor="#EEEEEE">Vencimento</td>
			<td width="112" align="center" bgcolor="#EEEEEE"><nobr>Vlr. Parcela</nobr></td>
			<td width="129" align="center" bgcolor="#EEEEEE"><nobr>Vlr. Recebido</nobr></td>
			<td width="108" align="center" bgcolor="#EEEEEE">Troco</td>
			<td width="111" align="center" bgcolor="#EEEEEE"><nobr>Pago em</nobr></td>
			<td width="137" align="center" bgcolor="#EEEEEE"><nobr>Form.Pag</nobr></td>
			<td width="124" align="center" bgcolor="#EEEEEE">Usuário</td>
			<td width="108" align="center" bgcolor="#EEEEEE">Status</td>
			<td width="137" align="center" bgcolor="#EEEEEE"><nobr>Estorno</nobr></td>
			<td width="249" align="center" bgcolor="#EEEEEE">Operações</td>
        </tr>
        <?
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
                $local_baixa = "";
                if($p['flgstatus'] == 2) {
                    $vrdesabilitado = "readonly='readonly'";	
                    if($p['nosso_numero'] > 0) {
                        $local_baixa = "SANTANDER";
                    }
                }
                else {
                    $vrdesabilitado = "";	
                }
                $stEstorno = $p['stEstorno'] == 1 ? "Sim" : "Não"; 
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
                        <input type="text" name="val_rec" id="val_rec<?=$nparc?>" value="<?=number_format($valorec,2,",",".")?>" 
                        class="span10" style="direction:rtl" onclick="this.value=''" onkeypress="return(MascaraMoeda(this,'.',',',event))">
                    </nobr>    
                    </td>
					<td align="center"><?=$troco?></td>
                    <td align="center"><?=$datapag?></td>
                    <td align="center"><nobr><?=$descfpg?></nobr></td>
                    <td align="center"><?=$login?></td>
                    <td align="center"><?=$status?></td>
                    <td align="center"><?=$stEstorno?></td>
                    <td align="center">
                    <?
                    if($_SESSION["tipo_usuario"] == 1) {
                    ?>
                    <nobr>
                        <a href="javascript: void(0)" 
                        onclick="baixarParcela(<?=$p['id']?>,document.getElementById('val_rec<?=$nparc?>').value,'',document.getElementById('formpag').value,'<?=$nparc?>')" 
                        style="text-decoration:none" class="btn btn-success">Baixar</a> 
                    </nobr>    
                    <?
                    }
                    else {
                    ?>
                    <nobr>
                        <a href="javascript: void(0)" onclick="baixarParcela(<?=$p['id']?>,document.getElementById('val_rec<?=$nparc?>').value,'',document.getElementById('formpag').value,'<?=$nparc?>')" style="text-decoration:none" class="btn btn-success">Baixar</a> 
                    </nobr>    
                    <?
                    }
                    ?>
                    </td>
                </tr>
                <?
                }
                else {
				$troco = $valorec - $p['valor_parcela'];
				$troco = $troco > 0 ? number_format($troco,2,",",".") : "";	
                ?>
                <tr>
                    <td align="center" style="color:#030"><?=$numparcela?></td>
                    <td align="center" style="color:#030"><?=$_util->dataMySql2Php($p['vencimento'])?></td>
                    <td align="center" style="color:#030">R$ <?=number_format($p['valor_parcela'],2,",",".")?></td>
                    <td align="center" style="color:#030">
                        R$ <?=number_format($valorec,2,",",".")?> 
                    </td>
                    <td align="center" style="color:#030"><?=$troco?></td>
                    <td align="center" style="color:#030"><?=$datapag?></td>
                    <td align="center" style="color:#030"><nobr><?=$descfpg?></nobr></td>
                    <td align="center" style="color:#030"><?=$login?></td>
                    <td align="center" style="color:#030"><?=$status?></td>
                    <td align="center" style="color:#030"><?=$stEstorno?></td>
                    <td align="center" style="color:#030"></td>
                </tr>
                <?
                }
            $nparc++;
            }
        }
        ?>
        <tr>
            <td colspan="12" align="center" bgcolor="#EEEEEE">
                <!--<a href="javascript: void(0)" onclick="confImprimirBoleto(<?=$nparc?>)" style="text-decoration:none">imprimir</a>-->    
                <input type="hidden" name="numparcelas" id="numparcelas" value="<?=$nparc?>">                 	
                <input type="hidden" name="cdparcelas" id="cdparcelas">                 	
            </td>
        </tr>
    </table>
	</p>  
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCloseModal">Fechar</button>
	</div>
</div>    