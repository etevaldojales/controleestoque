<?php
include("config_inicio.php");
require_once($lib.'classes/class.pedido.php');

$_class    	= new pedido($dbase);
;

$datai		= $_POST['datai'] != "" ? $_util->dataPhp2MySql($_POST['datai']) : "";
$dataf		= $_POST['dataf'] != "" ? $_util->dataPhp2MySql($_POST['dataf']) : "";
$formapg	= $_POST['formapg'] != "" ? $_POST['formapg'] : "";

$where 		= "where p.status_pedido = 2 ";
if($datai && $dataf) {
	$where .= "and p.data_pedido BETWEEN '$datai 00:00:00' AND '$dataf 23:59:59' ";
} else {
	if($datai) {
		$where .= "and p.data_pedido >= '$datai 00:00:00' ";	
	}
	if($dataf) {
		$where .= "and p.data_pedido <= '$dataf 23:59:59' ";	
	}
}
if($formapg) {
	$where .= "and p.id_formapag = '$formapg' ";
}
$ordem		= 'order by p.data_pedido';
$dados 		= $_class->getList($where,'',$ordem);
$exibirImp = is_array($dados) ? "" : "none";
?>

<strong>VENDAS</strong><i class="btn icon-print" id="btnImp" onClick="imprimirRelatório('lista_pedidos')" style="margin-left:435px; display: <?=$exibirImp?>; margin-top: -15px;"> <b>Imprimir</b></i><br>
Período: de <?=$_POST['datai']?> à <?=$_POST['dataf']?> 
<table class="table table-striped table-bordered" id="sample_1">
    <tr>
		<td>DATA</td>
		<td class="hidden-phone">FORMA PGTO</td>
        <td class="hidden-phone">CUSTO</td>
        <td class="hidden-phone">LUCRO</td>
		<td class="hidden-phone">VENDA</td>
    </tr>
    <?php
    if(is_array($dados)) {
		$totallucro = 0;
		$totalcusto = 0;
		$totalvenda = 0;
		foreach($dados as $d) {
			$lucro = $d['valor_venda'] - $d['valor_custo'];  	
			$totalcusto += $d['valor_custo'];
			$totallucro += $lucro;
			$totalvenda += $d['valor_venda'];
		?>
		<tr class="odd gradeX">
			<td><?=$_util->dataMySql2Php($d['data_pedido'])?></td>
			<td class="hidden-phone"><?=$d['forma_pgto']?></td>
			<td class="hidden-phone">R$ <?=number_format($d['valor_custo'],2,",",".")?></td>
			<td class="hidden-phone">R$ <?=number_format($lucro,2,",",".")?></td>
			<td class="hidden-phone">R$ <?=number_format($d['valor_venda'],2,",",".")?></td>
		</tr>
		<?php
		}
	}
	else {
	?>
	<tr class="odd gradeX">
		<td class="hidden-phone" colspan="3">NÃO HÁ PEDIDO CADASTRADO</td>
	</tr>
	<?php
	}
	?>
</table>
<div class="space10"></div>
<?php
if(is_array($dados)) {
?>
<table class="table table-hover invoice-input">
    <tr>
        <th>Período: de <?=$_POST['datai']?> à <?=$_POST['dataf']?></th>
    </tr>
    <tr>
        <td><strong>Custo:</strong> R$ <?=number_format($totalcusto,2,",",".")?></td>
    </tr>
    <tr>
        <td><strong>Lucro:</strong> R$ <?=number_format($totallucro,2,",",".")?></td>
    </tr>
    <tr>
        <td><strong>Venda:</strong> R$ <?=number_format($totalvenda,2,",",".")?></td>
    </tr>

</table>
<?php
}
?>
<script>
pesquisarProdutos();
</script>