<?php
include("config_inicio.php");
require_once($lib.'classes/class.cotacao.php');
require_once($lib.'classes/class.categoria.php');
require_once($lib.'classes/class.fornecedor.php');
require_once($lib.'classes/class.marca.php');

$_class    	= new cotacao($dbase);
$_cat    	= new categoria($dbase);
$_forn    	= new fornecedor($dbase);
$_marca    	= new marca($dbase);
;

$parametro	= $_POST['parametro'];
$tipo		= $_POST['tipo'];

$where 		= "where 1 = 1 ";
if($parametro != '' && $tipo == 1) {
	$where .= " and codigo = '$parametro' ";	
}
elseif($parametro != '' && $tipo == 2) {
	$cdcat 	= $_cat->getCategoria($parametro);
	if($cdcat) {
		$where .= "and id_categoria = ".$cdcat." ";	
	}
}
elseif($parametro != '' && $tipo == 3) {
	$cdforn 	= $_forn->getFornecedor($parametro);
	if($cdforn) {
		$where .= "and id_fornecedor = ".$cdforn." ";	
	}
}
$ordem		= 'order by data desc';
$total    	= $_class->countRec($where);
$num      	= 10;
$paginas  	= ceil($total/$num);
$pag      	= $_POST["pagina"] != "" ? $_POST["pagina"] : 1;
$inicio   	= ($pag * $num) - $num; 
$limit   	= "LIMIT $inicio,$num"; 
//$inicio 	= 0;

$prox = $pag + 1;
$ant = $pag - 1;
$ultima_pag = ceil($total / $num);
$penultima = $ultima_pag - 1;	
$adjacentes = 2;
$dados 		= $_class->getList($where,$limit,$ordem);
?>
<table class="table table-striped table-bordered" id="sample_1">
    <tr >
        <td class="hidden-phone">DATA</td>
        <td class="hidden-phone">FORNECEDOR</td>
        <td class="hidden-phone">LINHA DE PRODUTOS</td>
        <td class="hidden-phone">REFERÊNCIA</td>
        <td class="hidden-phone">MARCA</td>
        <td class="hidden-phone">PREÇO</td>
        <td class="hidden-phone">IPI</td>
        <td class="hidden-phone">PREÇO FINAL</td>
        <td class="hidden-phone">OBSERVAÇÕES</td>
        <td class="hidden-phone">&nbsp;</td>
    </tr>
    <?php
    if(is_array($dados)) {
		foreach($dados as $d) {
			$fornecedor = $_forn->get($d['id_fornecedor']);
			$categoria 	= $_cat->get($d['id_categoria']);
			$marca 		= $_marca->get($d['id_marca']);
		?>
		<tr class="odd gradeX">
			<td class="hidden-phone"><?=$_util->dataMySql2Php($d['data'])?></td>
			<td class="hidden-phone"><?=$fornecedor['descricao']?></td>
			<td class="hidden-phone"><?=$categoria['descricao']?></td>
			<td class="hidden-phone"><?=$d['codigo']?></td>
			<td class="hidden-phone"><?=$marca['descricao']?></td>
			<td class="hidden-phone">R$ <?=number_format($d['valor'],2,",",".")?></td>
			<td class="hidden-phone"><?=$d['ipi']?>%</td>
			<td class="hidden-phone">R$ <?=number_format($d['valor_final'],2,",",".")?></td>
			<td class="hidden-phone"><?=$d['observacoes']?></td>   
			<td class="center hidden-phone">
				<a href="javascript: void(0)" class="btn" onclick="editar(<?=$d['id']?>)"><i class="icon-share icon-black"></i> Editar</a>
			</td>
		</tr>
		<?php
		}
	}
	else {
	?>
    <tr class="odd gradeX">
        <td class="hidden-phone" colspan="11">Não há cotação cadastrada</td>
	</tr>
    <?php
	}
	?>
</table>
<br>
<div align="center">
<?php
if($paginas > 1) {
    include("paginacao.php");
}
?>
</div>
