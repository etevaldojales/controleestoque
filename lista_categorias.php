<?php
include("config_inicio.php");
require_once($lib.'classes/class.categoria.php');

$_class    	= new categoria($dbase);
;

$parametro	= isset($_POST['parametro']) ? $_POST['parametro'] : "";
$status		= isset($_POST['status']) ? $_POST['status'] : 1;

$where 		= "where stativo = ". $status;
if($parametro != '') {
	$where .= " and descricao like '%$parametro%' ";	
}
$ordem		= 'order by descricao';
$total    	= $_class->countRec($where);
$num      	= 10;
$paginas  	= ceil($total/$num);
$pag      	= isset($_POST["pagina"]) != "" ? $_POST["pagina"] : 1;
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
<table width="459" class="table table-striped table-bordered" id="sample_1">
    <tr>
        <td width="339" class="hidden-phone">CATEGORIA</td>
        <td width="108" class="hidden-phone">OPÇÕES</td>
    </tr>
    <?php
    if(is_array($dados)) {
		foreach($dados as $d) {
		?>
		<tr class="odd gradeX">
			<td class="hidden-phone"><?=$d['descricao']?></td>
			<td class="center hidden-phone" align="center">
            	<nobr>
				<button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips" onClick="editar(<?=$d['id']?>)" >
				<i class="icon-edit icon-white"></i>
				</button>
				<button data-original-title="Excluir" data-placement="left" class="btn tooltips" onClick="excluir(<?=$d['id']?>)">
				<i class="icon-remove-sign icon-white"></i>
				</button>
                </nobr>
			</td>        
		</tr>
		<?php
		}
	}
	else {
	?>
    <tr class="odd gradeX">
        <td class="hidden-phone" colspan="2">Não há categoria cadastrada</td>
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
