<?php
include("config_inicio.php");
require_once($lib.'classes/class.estoque.php');
require_once($lib.'classes/class.utilidades.php');

$_class    	= new estoque($dbase);
$_util	 	= new utilidades();

$parametro	= isset($_POST['parametro']) ? $_POST['parametro'] : '';

$where 		= "where 1 = 1";
if($parametro != '') {
	$where .= " and p.nome like '%$parametro%' ";	
}
$ordem		= 'order by p.codigo, e.id desc';
$total    	= $_class->countRec($where);
$num      	= 10;
$paginas  	= ceil($total/$num);
$pag      	= isset($_POST["pagina"]) ? $_POST["pagina"] : 1;
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
<link rel="stylesheet" type="text/css" href="css/estilo.css" />
<table class="table table-striped table-bordered" id="sample_1" width="100%">
    <tr>
        <td width="79" class="hidden-phone" style="text-align:center">DATA</td>
		<td class="hidden-phone" style="text-align:center"><nobr>Nº NF</nobr></td>
        <td width="632" class="hidden-phone" style="text-align:center">PRODUTO</td>
        <td width="214" class="hidden-phone" style="text-align:center">ENTRADA</td>
        <td width="137" class="hidden-phone" style="text-align:center">SAÍDA</td>
        <td width="149" class="hidden-phone" style="text-align:center">ACUMULADO</td>
    </tr>
    <?php
    if(is_array($dados)) {
		foreach($dados as $d) {
			$nf = $d['num_nf'] == 0 ? "-" : $d['num_nf'];
		?>
		<tr class="odd gradeX">
			<td class="hidden-phone" style="text-align:center"><?=$_util->dataMySql2Php($d['data_cad'])?></td>
			<td class="hidden-phone" style="text-align:center"><?=$nf?></td>
			<td class="hidden-phone"><?=$d['nome']?></td>
			<td class="hidden-phone" style="text-align:center"><?=$d['qtdentrada']?></td>
			<td class="hidden-phone" style="text-align:center"><?=$d['qtdsaida']?></td>
			<td class="hidden-phone" style="text-align:center"><?=$d['qtdacumulado']?></td>
		</tr>
		<?php
		}
	}
	else {
	?>
    <tr class="odd gradeX">
        <td class="hidden-phone" colspan="5" align="center"><h5><nobr>Não há produto cadastrado</nobr></h5></td>
    </tr>
    <?
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
