<?php
include("config_inicio.php");
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.utilidades.php');

$_class    	= new produto($dbase);
$_util     	= new utilidades();

$parametro	= isset($_POST['parametro']) ? $_POST['parametro'] : "";
$filtro		= isset($_POST['filtro']) ? $_POST['filtro'] : "";

$resumo 	= $_class->getResumo();

$where 		= "where p.stativo = 1 and m.stativo = 1 and f.stativo = 1 and c.stativo = 1";
if($filtro == 1 && $parametro != '') {
	$where .= " and p.nome like '%$parametro%' ";	
}
elseif($filtro == 2 && $parametro != '') {
	$where .= " and p.codigo like '%$parametro%' ";	
}
if($filtro == 3 && $parametro != '') {
	$where .= " and f.descricao like '%$parametro%' ";	
}
elseif($filtro == 4 && $parametro != '') {
	$where .= " and m.descricao like '%$parametro%' ";	
}
elseif($filtro == 5 && $parametro != '') {
	$where .= " and c.descricao like '%$parametro%' ";	
}
$ordem		= 'order by p.id';
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
<table class="table table-striped table-bordered" id="sample_1">
    <thead>
     <tr>
       <td align="center">QTD</td>
       <td class="hidden-phone" align="center">NOME</td>
       <td class="hidden-phone" align="center">REFERÊNCIA</td>
       <td class="hidden-phone" align="center">MARCA</td>
       <td class="hidden-phone" align="center">PRAT.</td>
       <td class="hidden-phone" align="center">FORNECEDOR</td>
       <td class="hidden-phone" align="center">VALOR COMPRA</td>
       <td class="hidden-phone" align="center">VALOR VENDA</td>
       <td class="hidden-phone" align="center">DATA</td>
       <td class="hidden-phone" align="center">OPÇÕES</td>
     </tr>
    </thead>
    <tbody>
    <?php
	if(!empty($dados) && isset($dados[0]['id']) && $dados[0]['id'] > 0) {
		foreach($dados as $d) {
		$marca	 = $_class->getMarca($d['id_marca']);  
		$forn	 = $_class->getFornecedor($d['id_fornecedor']);  
		$qtd	 = $_class->getEstoque($d['id']);
		?>
        <tr class="odd gradeX">
            <td><?=$qtd?></td>
            <td class="hidden-phone"><?=$d['nome']?></td>
            <td class="hidden-phone"><?=$d['codigo']?></td>
            <td class="hidden-phone"><?=$marca?></td>
            <td class="hidden-phone"><?=$d['local_estoque']?></td>
            <td class="hidden-phone"><?=$forn?></td>
            <td class="hidden-phone">R$ <?=number_format($d['valor_compra'],2,",",".")?></td>
            <td class="hidden-phone">R$ <?=number_format($d['valor'],2,",",".")?></td>
            <td class="hidden-phone"><?=$_util->dataMySql2Php($d['data_cadastro'])?></td>
            <td class="center hidden-phone">
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
            <td colspan="10" align="center"><h5>Não há produto cadastrado</h5></td>
        </tr>
		<?php
	}
	?>
    </tbody>
</table>
<br>
<?php
if(is_array($resumo)) {
	$sqtd = 0;
	$svalor = 0;
	foreach($resumo as $r) {
		$qtdi = $_class->getResumoAcumulado($r['id']);
		if($qtdi > 0) {
			$sqtd += $qtdi;
			$svalor += ($r['valor'] * $qtdi);
		}
	}
?>
<table width="100%" cellpadding="2" cellspacing="2" border="0">
<tr>
    <td width="10%"><nobr><b>Quantidade Total de Ítens:</b></nobr></td>
    <td width="90%"><?=$sqtd?> ítens</td>
</tr>
<tr>
    <td><nobr><b>Valor Total de Custo:</b></nobr></td>
    <td>R$ <?=number_format($svalor,2,",",".")?></td>
</tr>
</table>
<?php	
}
?>

<div align="center">
<?php
if($paginas > 1) {
    include("paginacao.php");
}
?>
</div>
