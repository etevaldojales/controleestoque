<?php
include("config_inicio.php");
require_once($lib.'classes/class.logs.php');

$_class    	= new logs($dbase);
;

$datai		= $_POST['datai'] != "" ? $_util->dataPhp2MySql($_POST['datai']) : "";
$dataf		= $_POST['dataf'] != "" ? $_util->dataPhp2MySql($_POST['dataf']) : "";;

$where 		= "where 1 = 1";
if($datai) {
	$where .= " and data >= '$datai' ";	
}
if($dataf) {
	$where .= " and data <= '$dataf' ";	
}
$ordem		= 'order by data desc, id desc';
$total    	= $_class->countRec($where);
$num      	= 10;
$paginas  	= ceil($total/$num);
$pag      	= $_POST["pagina"] != "" ? $_POST["pagina"] : 1;
$inicio   	= ($pag * $num) - $num; 
$limit   	= "LIMIT $inicio,$num"; 

$prox = $pag + 1;
$ant = $pag - 1;
$ultima_pag = ceil($total / $num);
$penultima = $ultima_pag - 1;	
$adjacentes = 2;
$dados 		= $_class->getList($where,$limit,$ordem);
?>
<div class="space10"></div>
<table class="table table-hover invoice-input">
<?php
if(is_array($dados)) {
	foreach($dados as $d) {
	?>
    <tr>
        <td height="37">
            <strong><?=$_util->dataMySql2Php($d['data'])?></strong> - <strong>USUÁRIO: <?=$d['mensagem']?>
        </td>
    </tr>
	<?php
	}
}
else {
?>
<tr>
	<td height="37">
		NÃO HA REGITRO CADASTRADO
	</td>
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

