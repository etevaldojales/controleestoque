<?php
include("config_inicio.php");
require_once($lib.'classes/class.cotacao.php');
require_once($lib.'classes/class.produto.php');

$_class    	= new cotacao($dbase);
$_produto  	= new produto($dbase);
;

$tags 		= $_POST['tags'];
$where		= "where codigo in ('$tags')";
$ordem 		= "order by id desc";
$cotacoes	= $_class->getList($where,$ordem);
$marcai		= $_produto->getMarca($cotacoes[1]['id_marca']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel1">Estoque - <?=$cotacoes[1]['codigo']?> - <?=$marcai?></h3>
    </div>
    <div class="modal-body">
    <p>
    
    <table class="table table-bordered table-hover">
        <tr>
            <td width="9%" height="37" class="hidden-phone"><strong>Data</strong></td>
            <td width="20%" class="hidden-phone"><strong>Local</strong></td>
            <td width="9%" class="hidden-phone"><strong>Preço</strong></td>
            <td width="9%" class="hidden-phone"><strong>IPI</strong></td>
            <td width="10%" class="hidden-phone"><strong>Preço Final</strong></td>
            <td width="9%"  class="hidden-phone"><strong>MARCA</strong></td>
            <td width="22%" class="hidden-phone"><strong>OBS</strong></td>
        </tr>
        <?php
        if(is_array($cotacoes)) {
			foreach($cotacoes as $c) {
				$marca 		= $_produto->getMarca($c['id_marca']);
				$fornecedor = $_produto->getFornecedor($c['id_fornecedor']);
			?>
			<tr>
				<td><?=$_util->dataMySql2Php($c['data'])?></td>
				<td class="hidden-phone"><?=utf8_decode($fornecedor)?></td>
				<td class="hidden-phone">R$ <?=number_format($c['valor'],2,",",".")?></td>
				<td class="hidden-phone"><?=$c['ipi']?>%</td>
				<td class="hidden-phone">R$ <?=number_format($c['valor_final'],2,",",".")?></td>
				<td class="hidden-phone"><?=$marca?></td>
				<td class="hidden-phone">&nbsp;</td>
				<td width="12%" class="hidden-phone">&nbsp;</td>
			</tr>
			<?php
			}
		}
		else {
		?>
        <tr>
            <td class="hidden-phone" colspan="8">Não há cotação cadastrada para esse produto</td>
        </tr>
        <?php
		}
		?>
    </table>
    </p>
    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
</div>
