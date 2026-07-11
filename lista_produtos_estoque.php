<?php
include("config_inicio.php");
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.categoria.php');

$_class    	= new produto($dbase);
;
$_categoria	= new categoria($dbase);

$parametro	= isset($_POST['parametro']) ? $_POST['parametro'] : "";
$filtro		= isset($_POST['filtro']) ? $_POST['filtro'] : "";

$where 		= "where p.stativo = 1";
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
elseif($filtro == 6 && $parametro != '') {
	$where .= " and e.num_nf = $parametro ";	
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
$dados 		= $_class->getListEsp($where,$limit,$ordem);
?>
<table class="table table-striped table-bordered" id="sample_1">
    <thead>
     <tr>
       <td align="center">QTD</td>
       <td class="hidden-phone" align="center">PRODUTO</td>
       <td class="hidden-phone" align="center">REFERÊNCIA</td>
       <td class="hidden-phone" align="center">MARCA</td>
       <td class="hidden-phone" align="center">PRAT.</td>
       <td class="hidden-phone" align="center">FORNECEDOR</td>
       <td class="hidden-phone" align="center">CATEGORIA</td>
       <td class="hidden-phone" align="center">VALOR COMPRA</td>
       <td class="hidden-phone" align="center">VALOR VENDA</td>
     </tr>
    </thead>
    <tbody>
    <?php
	if(is_array($dados)) {
		foreach($dados as $d) {
		$categoria = $_categoria->get($d['id_categoria']);
		$marca	 = $_class->getMarca($d['id_marca']);  
		$forn	 = $_class->getFornecedor($d['id_fornecedor']);  
        if($filtro == 6) {
            $qtd	 = $_class->getEstoqueEntrada($parametro, $d['id']);
        }
        else {
            $qtd	 = $_class->getEstoque($d['id']);
        }
		
		$estmin	 = $_class->getEstoqueMinimo($d['id']);
		$cor 	 = ($qtd <= $estmin) ? "#CD0000" : "";	
		$titulo	 = ($qtd <= $estmin && $qtd > 0) ? "Esse Produto está no estque mínimo \nEstoque mínimo desse produto: ".$estmin : "";	
		?>
        <tr class="odd gradeX" style="color:<?=$cor?>" title="<?=$titulo?>">
            <td><?=$qtd?></td>
            <td class="hidden-phone"><?=$d['nome']?></td>
            <td class="hidden-phone"><?=$d['codigo']?></td>
            <td class="hidden-phone"><?=$marca?></td>
            <td class="hidden-phone"><?=$d['local_estoque']?></td>
            <td class="hidden-phone"><?=$forn?></td>
            <td class="hidden-phone"><?=$categoria['descricao']?></td>
            <td class="hidden-phone"style="text-align: right;">R$ <?=number_format($d['valor_compra'],2,",",".")?></td>
            <td class="hidden-phone" style="text-align: right;">R$ <?=number_format($d['valor'],2,",",".")?></td>
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
<div align="center">
<?php
if($paginas > 1) {
    include("paginacao.php");
}
?>
</div>
