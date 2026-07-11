<?php
include("config_inicio.php");
require_once($lib."classes/class.utilidades.php");
require_once($lib."classes/class.parcela.php");

$_util	 	= new utilidades();
$_class 	= new parcela($dbase);

$dataI		= $_POST['datai'] != "" ? $_util->dataPhp2MySql($_POST['datai']) : "";
$dataF		= $_POST['dataf'] != "" ? $_util->dataPhp2MySql($_POST['dataf']) : "";
$dados = $_class->getRelParc($dataI,$dataF);
?>
<div class="linhas">
<table width="90%" cellpadding="2" cellspacing="2" background="0">
	<tr bgcolor="#CCCCCC">
    	<td width="34%" align="center" style="line-height: 25px; font-size: 12px;"><b>Cliente</b></td>
    	<td width="9%" align="center" style="line-height: 25px; font-size: 12px;"><b><nobr>Data Baixa</nobr></b></td>
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b><nobr>Data Vencimento</nobr></b></td>
    	<td width="11%" align="center" style="line-height: 25px; font-size: 12px;"><b><nobr>Valor Parcela</nobr></b></td>
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b><nobr>Valor Pago</nobr></b></td>
    	<td width="8%" align="center" style="line-height: 25px; font-size: 12px;"><b><nobr>Form. Pgto</nobr></b></td>
    	<td width="7%" align="center" style="line-height: 25px; font-size: 12px;"><b>Recibo</b></td>
    	<td width="11%" align="center" style="line-height: 25px; font-size: 12px;"><b>Usuário</b></td>
    </tr>
    <?php
    if(is_array($dados)) {
		echo "<script>document.getElementById('impr').style.display = '';</script>";
		$i = 1;
		$total = 0;
		foreach($dados as $d) {
			$i%2 == 0?$corfundo = "#CCCCCC":$corfundo = "#FFFFFF";
			$total += $d['valor_pag'];
		?>
		<tr bgcolor="<?=$corfundo?>">
			<td align="ldft" style="line-height: 25px; font-size: 12px;">
				<?=$d['nome']?>
			</td>
			<td align="center" style="line-height: 25px; font-size: 12px;">
				<?=$_util->dataMySql2Php($d['data_pgto'])?>
			</td>
			<td align="center" style="line-height: 25px; font-size: 12px;">
				<?=$_util->dataMySql2Php($d['vencimento'])?>
			</td>
			<td align="right" style="line-height: 25px; font-size: 12px;">
            	<nobr>R$ <?=number_format($d['valor_parcela'],2,",",".")?></nobr>
			</td>
			<td align="right" style="line-height: 25px; font-size: 12px;">
            	<nobr>R$ <?=number_format($d['valor_pag'],2,",",".")?></nobr>
			</td>
			<td align="center" style="line-height: 25px; font-size: 12px;">
				<?=$d['formapg']?>
			</td>
			<td align="center" style="line-height: 25px; font-size: 12px;">
				<?=$d['recibo']?>
			</td>
			<td align="center" style="line-height: 25px; font-size: 12px;">
				<nobr><?=$d['usuario']?></nobr>
			</td>
		</tr>
		<?php    
		$i++;
		}
		?>
		<tr>
        	<td colspan="7" align="right"><b>Total:</b></td>
        	<td align="right"><nobr>R$ <?=number_format($total,2,",",".")?></nobr></td>
        </tr>
		<?php
	}
	else {
	?>
    <script>document.getElementById('impr').style.display = 'none';</script>
	<tr>
    	<td colspan="6" align="center"><b>NÃO HÁ PARCELA BAIXADA</b></td>
    </tr>
	<?php	
	}
	?>
</table>   
