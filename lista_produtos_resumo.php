<?php
include("config_inicio.php");
require_once($lib.'classes/class.pedido.php');
require_once($lib.'classes/class.produto.php');

$_class    	= new pedido($dbase);
;

$datai		= $_POST['datai'] != "" ? $_util->dataPhp2MySql($_POST['datai']) : "";
$dataf		= $_POST['dataf'] != "" ? $_util->dataPhp2MySql($_POST['dataf']) : "";;

$dados 		= $_class->getItensMaisVendidos($datai, $dataf);
?>
<strong>PRODUTOS</strong><br>
Período: de <?=$_POST['datai']?> à <?=$_POST['dataf']?>
<table class="table table-striped table-bordered" id="sample_1">
    <tr>
        <td class="hidden-phone">QTD</td>
        <td class="hidden-phone">PRODUTO</td>
        <td class="hidden-phone">MARCA</td>
        <td class="hidden-phone">VALOR UNITÁRIO</td>
    </tr>
    <?php
    if(is_array($dados)) {
		foreach($dados as $d) {
		?>
		<tr class="odd gradeX">
			<td class="hidden-phone"><?=round($d['qtd'], 2)?></td>
			<td class="hidden-phone"><?=$d['produto']?></td>
			<td class="hidden-phone"><?=$d['marca']?></td>
			<td class="hidden-phone">R$ <?=number_format($d['valor'],2,",",".")?></td>
		</tr>
		<?php
		}
	}
	else {
	?>
	<tr class="odd gradeX">
		<td class="hidden-phone" colspan="4">NÃO HÁ PRODUTO VENDIDO </td>
	</tr>
	<?php
	}
	?>
</table>
