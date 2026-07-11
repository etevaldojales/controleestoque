<?php
include("config_inicio.php");
require_once($lib.'classes/class.produto.php');

$_class    	= new produto($dbase);
;

$parametro	= $_POST['parametro'] ?? '';
$filtro		= $_POST['filtro'] ?? '';

$where 		= "where 1 = 1";
if($filtro == 1 && $parametro != '') {
	$where .= " and p.nome like '%$parametro%' ";	
}
elseif($filtro == 2 && $parametro != '') {
	$where .= " and p.codigo like '%$parametro%' ";	
}
elseif($filtro == 3 && $parametro != '') {
	$where .= " and m.descricao like '%$parametro%' ";	
}
elseif($filtro == 4 && $parametro != '') {
	$where .= " and f.descricao like '%$parametro%' ";	
}
$ordem		= 'order by p.id';
$total    	= $_class->countRec($where);
$num      	= 10;
$paginas  	= ceil($total/$num);
$pag      	= isset($_POST["pagina"]) && $_POST["pagina"] != "" ? $_POST["pagina"] : 1;
$inicio   	= ($pag * $num) - $num; 
$limit   	= "LIMIT $inicio,$num"; 

$prox = $pag + 1;
$ant = $pag - 1;
$ultima_pag = ceil($total / $num);
$penultima = $ultima_pag - 1;	
$adjacentes = 2;
$dados 		= $_class->getList($where,$limit,$ordem);
?>
<table width="984" class="table table-striped table-bordered" id="sample_1">
    <tr>
        <td width="88">ESTOQUE</td>
        <td width="104" class="hidden-phone">NOME</td>
        <td width="104" class="hidden-phone">REFERÊNCIA</td>
        <td width="109" class="hidden-phone">MARCA</td>
        <td width="163" class="hidden-phone">FORNECEDOR</td>
        <!--<td width="126" class="hidden-phone"><nobr>PREÇO COMPRA</nobr></td>-->
        <td width="113" class="hidden-phone"><nobr>PREÇO FINAL</nobr></td>
        <td width="84" class="hidden-phone">OPÇÕES</td>
    </tr>
    <?php
    if(is_array($dados)) {
		foreach($dados as $d) {
		$marca	 = $_class->getMarca($d['id_marca']);  
		$forn	 = $_class->getFornecedor($d['id_fornecedor']);  
		$qtd	 = $_class->getEstoque($d['id']);
		$estmin	 = $_class->getEstoqueMinimo($d['id']);
		$classe	 = ($qtd <= $estmin) ? "btn btn-warning" : "btn btn-success";	
		$titulo	 = ($qtd <= $estmin && $qtd > 0) ? "Esse Produto está no estque mínimo \nEstoque mínimo desse produto: ".$estmin : "";	
		?>
		<tr class="odd gradeX" title="<?=$titulo?>">
			<td><?=$qtd?></td>
			<td class="hidden-phone"><?=$d['nome']?></td>
			<td class="hidden-phone"><?=$d['codigo']?></td>
			<td class="hidden-phone"><?=$marca?></td>
			<td class="hidden-phone"><?=$forn?></td>
			<!--<td class="hidden-phone">R$ <?=number_format($d['valor_compra'],2,",",".")?></td>-->
			<td class="hidden-phone">R$ <?=number_format($d['valor'],2,",",".")?></td>
			<td class="center hidden-phone">
			<?php
            if($qtd > 0) {
			?>            
                <nobr>
                <a href="javascript: void(0)" class="<?=$classe?>" onClick="adicionarItem(<?=$d['id']?>)"><i class="icon-shopping-cart"></i> Adicionar</a>
                </nobr>
            <?php
			}
			?>    
			</td>     
		</tr>
		<?php
		}
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
