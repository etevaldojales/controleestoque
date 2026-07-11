<?php
include("config_inicio.php");
require_once($lib."classes/class.utilidades.php");
require_once($lib."classes/class.parcela.php");

$_util	 	= new utilidades();
$_class 	= new parcela($dbase);

$dataI		= $_POST['datai'] != "" ? $_util->dataPhp2MySql($_POST['datai']) : "";
$dataF		= $_POST['dataf'] != "" ? $_util->dataPhp2MySql($_POST['dataf']) : "";
$dados = $_class->getRelPrev($dataI,$dataF);
?>
<div class="linhas" id="produtos_servicos_edicao">
<table width="100%" cellpadding="2" cellspacing="2" background="0">
	<tr bgcolor="#CCCCCC">
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b><nobr>Data Venc.</nobr></b></td>
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b>Qtd</b></td>
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b>Entrada</b></td>
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b>Dinheiro</b></td>
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b>Boleto</b></td>
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b><nobr>Cartão Crédito</nobr></b></td>
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b><nobr>Cartão Dédito</nobr></b></td>
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b>Pagueseguro</b></td>
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b>Cheque</b></td>
    	<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b><nobr>Valor Total</nobr></b></td>
    </tr>
    <?php
    if(is_array($dados)) {
		echo "<script>document.getElementById('impr').style.display = '';</script>";
		$i = 1;
		$total = 0;
		$stotal = 0;
		foreach($dados as $d) {
			$stotal = ($d['vrDinheiro'] + $d['vrBoleto'] + $d['vrCartao'] + $d['vrPagueseguro'] + $d['vrCheque'] + $d['vrDebito'] + $d['vrEntrada']);
			$total += $stotal;
			$qtd = $d['qtd'] < 10 ? "0".$d['qtd'] : $d['qtd'];
			$i%2 == 0?$corfundo = "#CCCCCC":$corfundo = "#FFFFFF";
		?>
		<tr bgcolor="<?=$corfundo?>">
			<td align="center" style="line-height: 25px; font-size: 12px;">
				<?=$_util->dataMySql2Php($d['vencimento'])?>
			</td>
			<td align="center" style="line-height: 25px; font-size: 12px;">
            	<?=$qtd?>
			</td>
			<td align="right" style="line-height: 25px; font-size: 12px;">
            	<nobr>R$ <?=number_format($d['vrEntrada'],2,",",".")?></nobr>
			</td>
			<td align="right" style="line-height: 25px; font-size: 12px;">
            	<nobr>R$ <?=number_format($d['vrDinheiro'],2,",",".")?></nobr>
			</td>
			<td align="right" style="line-height: 25px; font-size: 12px;">
            	<nobr>R$ <?=number_format($d['vrBoleto'],2,",",".")?></nobr>
			</td>
			<td align="right" style="line-height: 25px; font-size: 12px;">
            	<nobr>R$ <?=number_format($d['vrCartao'],2,",",".")?></nobr>
			</td>
			<td align="right" style="line-height: 25px; font-size: 12px;">
            	<nobr>R$ <?=number_format($d['vrDebito'],2,",",".")?></nobr>
			</td>
			<td align="right" style="line-height: 25px; font-size: 12px;">
            	<nobr>R$ <?=number_format($d['vrPagueseguro'],2,",",".")?></nobr>
			</td>
			<td align="right" style="line-height: 25px; font-size: 12px;">
            	<nobr>R$ <?=number_format($d['vrCheque'],2,",",".")?></nobr>
			</td>
			<td align="right" style="line-height: 25px; font-size: 12px;">
            	<nobr>R$ <?=number_format($stotal,2,",",".")?></nobr>
			</td>
		</tr>
		<?php
		$i++;
		}
		$arr = $_class->getJurosMulta($dataI,$dataF);
		$vrJuros = floatval($arr['vrJuros'] ?? 0);
		$vrMulta = floatval($arr['vrMulta'] ?? 0);
		$vrTotal = $total + ($vrJuros + $vrMulta);
		?>
        <tr>
        	<td colspan="10"><hr></td>
        </tr>
        <tr>
            <td colspan="10" align="right">
            Periodo <?=$_POST['datai']?> a <?=$_POST['dataf']?>:  R$ <?=number_format($total,2,",",".")?>
            </td>
        </tr>
        <tr>
            <td colspan="10" align="right">
            Juros: R$ <?=number_format($vrJuros,2,",",".")?>
            </td>
        </tr>
        <tr>
            <td colspan="10" align="right">
            Multa:  R$ <?=number_format($vrMulta,2,",",".")?>
            </td>
        </tr>
        <tr>
            <td colspan="10" align="right">
            Total R$ <?=number_format($vrTotal,2,",",".")?>
            </td>
        </tr>
    <?php    
	}
	else {
	?>
    <script>document.getElementById('impr').style.display = 'none';</script>
	<tr>
    	<td colspan="10" align="center"><b>NÃO HÁ PREVISÃO DE RECEITA PARA O PERÍODO INFORMADO</b></td>
    </tr>
	<?php	
	}
	?>
</table>   
