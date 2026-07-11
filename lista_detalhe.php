<?php
include("config_inicio.php");
require_once($lib . 'classes/class.utilidades.php');
require_once($lib . 'classes/class.pedido.php');
require_once($lib . 'classes/class.produto.php');

$_class = new pedido($dbase);
$_produto = new produto($dbase);
$_util = new utilidades();

$idped = $_POST['id']; // id do pedido
$filtro = isset($_POST['filtro']) ? $_POST['filtro'] : null; // filtro para os itens do pedido
$pedido = $_class->get($idped);
$itens = $_class->getItens($idped, $filtro);
$servico = $_class->getServico($idped);
?>
<table class="table table-hover invoice-input">
	<tr>
		<th>DATA</th>
		<th>PRODUTO</th>
		<th>REFERÊNCIA</th>
		<th>MARCA</th>
		<th>QTD</th>
		<th>PREÇO UNITÁRIO</th>
		<th>PREÇO FINAL</th>
	</tr>
	<?php
	if (is_array($itens)) {
		$total = 0;
		$i = 1;
		
		foreach ($itens as $i) {
			$produto = $_produto->get($i['id_produto']);
			$marca = $_produto->getMarca($produto['id_marca']);
			$forn = $_produto->getFornecedor($produto['id_fornecedor']);
			$total += $i['valor_total'];
			?>
			<tr>
				<td><?= $_util->dataMySql2Php($pedido['data_pedido']) ?></td>
				<td><?= $produto['nome'] ?></td>
				<td><?= $produto['codigo'] ?></td>
				<td><?= $marca ?></td>
				<td><?= $i['quantidade'] ?></td>
				<td>R$ <?= number_format($i['valor_unitario'], 2, ",", ".") ?></td>
				<td>R$ <?= number_format($i['valor_total'], 2, ",", ".") ?></td>
			</tr>
		<?php
		}
		if (is_array($servico) && !empty($servico)) {
			?>
			<tr>
				<td colspan="6">
					<b>Serviço: </b><?= $servico['descricao'] ?? '' ?>
					<b style="margin-left: 200px;">Valor: </b> <?= number_format((float)($servico['valor'] ?? 0), 2, ",", ".") ?>
				</td>
			</tr>
			<?php
			$total += (float)($servico['valor'] ?? 0);
		}
		?>
		<tr>
			<td colspan="6">
				<div class="span4 invoice-block pull-right">
					<ul class="unstyled amounts">
						<li><strong>TOTAL :</strong> R$ <?= number_format($total, 2, ",", ".") ?></li>
					</ul>
				</div>
			</td>

		</tr>
	<?php
	}
	?>
</table>