<?php
include("config_inicio.php");
require_once($lib.'classes/class.cliente.php');
require_once($lib.'classes/class.categoria.php');

$_class    	= new cliente($dbase);
;

$parametro	= isset($_POST['parametro']) ? $_POST['parametro'] : '';
$status	 	= isset($_POST['status']) ? $_POST['status'] : 0;


$where 		= "where 1 = 1";
if($parametro != '') {
	$where .= " and nome like '%$parametro%' ";	
}
if($status == 1) {
	$where .= " and stativo = 1 ";	
}
else if($status == 2) {
	$where .= " and stativo = 0 ";	
}

$ordem		= 'order by nome';
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
<table width="1239" class="table table-striped table-bordered" id="sample_1">
    <tr>
        <td width="245" class="hidden-phone">NOME</td>
        <td width="420" class="hidden-phone">ENDEREÇO</td>
        <td width="161" class="hidden-phone">TELEFONE</td>
        <td width="253" class="hidden-phone">E-MAIL</td>
        <td width="136" class="hidden-phone" align="center">OPÇÕES</td>
    </tr>
    <?php
    if(is_array($dados)) {
		foreach($dados as $d) {
		?>
		<tr class="odd gradeX">
			<td class="hidden-phone"><?=$d['nome']?></td>
			<td class="hidden-phone"><?=$d['endereco']?></td>                           
			<td class="hidden-phone"><?=$d['telefone']?></td>
			<td class="hidden-phone"><?=$d['email']?></td>
			<td class="center hidden-phone">
                <nobr>
                <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips" onClick="editar(<?=$d['id']?>)">
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
        <td class="hidden-phone" colspan="5">NÃO HÁ CLIENTE CADASTRADO</td>
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
