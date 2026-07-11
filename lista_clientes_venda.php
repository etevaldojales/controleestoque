<?php
include("config_inicio.php");
require_once($lib.'classes/class.pedido.php');
require_once($lib.'classes/class.utilidades.php');

$_class    	= new pedido($dbase);
$_util    	= new utilidades;

$parametro	= isset($_POST['parametro']) ? $_POST['parametro'] : '';
$data		= isset($_POST['data']) ? $_POST['data'] : '';
$dataf		= isset($_POST['dataf']) ? $_POST['dataf'] : '';

$where 		= "where p.status_pedido = 2 ";
if($parametro != '') {
	$where .= " and c.nome like '%$parametro%' ";	
}
if($data != '') {
	$where .= " and p.data_pedido >= '$data' ";	
}
if($dataf != '') {
	$where .= " and p.data_pedido <= '$dataf' ";	
}
//echo $where;
$ordem		= 'order by p.id desc';
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

function formataNumero($num) {
	while(strlen($num) < 5) {
		$num = '0'.$num; 		
	}
	return $num;
}

?>
<table width="543" class="table table-striped table-bordered" id="sample_1">
    <tr>
        <td width="83">DATA</td>
        <td width="298" class="hidden-phone">CLIENTE</td>
        <td width="100" class="hidden-phone">Nº PEDIDO</td>
        <td width="146" class="hidden-phone">OPÇÕES</td>
    </tr>
    <?php
    if(is_array($dados)) {
		foreach($dados as $d) {
		?>
		<tr class="odd gradeX">
			<td><span class="hidden-phone"><?=$_util->dataMySql2Php($d['data_pedido'])?></span></td>
			<td class="hidden-phone"><?=$d['cliente']?></td>
			<td class="hidden-phone"><?=formataNumero($d['numero_pedido'])?></td>
			<td class="center hidden-phone">
            	<nobr>
                <a href="vendas_realizadas_detalhe.php?idcliente=<?=$d['id_cliente']?>&idpedido=<?=$d['id']?>" class="btn btn-success">
                    <i class="icon-share icon-black"></i> Visualizar Pedido
                </a>
                &nbsp;&nbsp;
                <a onclick="exibirParcelas(<?=$d['id']?>)" class="btn btn-success" data-toggle="modal" href="#myModal1">
                    <i class="icon-share icon-black"></i> Visuzalizar Parcelas
                </a>
                </nobr>
			</td>  
		</tr>
		<?php
		}
	}
	else {
	?>
    <tr class="odd gradeX">
        <td class="hidden-phone" colspan="3">NÃO HA VENDA CADASTRADA</td>
    </tr>
    <?php
	}
	?>
</table>


<!--MODAL COTAÇÃO-->
<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
</div>
<!--MODAL COTAÇÃO FIM  -->

