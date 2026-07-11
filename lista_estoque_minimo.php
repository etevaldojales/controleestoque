<?php
include("config_inicio.php");
require_once($lib . "classes/class.utilidades.php");
require_once($lib . "classes/class.produto.php");

$_util = new utilidades();
$_class = new produto($dbase);


$dados = $_class->getListEstoqueMinimo();
?>
<div class="linhas" id="produtos_servicos_edicao">
	<table width="100%" cellpadding="2" cellspacing="2" background="0">
		<tr bgcolor="#CCCCCC">
			<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b>
					<nobr>Produto</nobr>
				</b></td>
			<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b>Saldo em Estoque</b></td>
			<td width="10%" align="center" style="line-height: 25px; font-size: 12px;"><b>Estoque mínimo</b></td>
		</tr>
		<?php
		if (is_array($dados)) {
			echo "<script>document.getElementById('impr').style.display = '';</script>";
			$i = 1;
			foreach ($dados as $d) {
				if ($d['saldo'] <= $d['estoque_minimo']) {
					$cor = "red";
					$msg = "Estoque mínimo";
				} else {
					$cor = "green";
					$msg = "Estoque normal";
				}
				$qtd_saldo = $d['saldo'] < 10 ? "0" . $d['saldo'] : $d['saldo'];
				$qtd_estoque_minimo = $d['estoque_minimo'] < 10 ? "0" . $d['estoque_minimo'] : $d['estoque_minimo'];

				$i % 2 == 0 ? $corfundo = "#CCCCCC" : $corfundo = "#FFFFFF";
				?>
				<tr bgcolor="<?= $corfundo ?>" title="<?=$msg?>">
					<td align="left" style="line-height: 25px; font-size: 12px; color: <?=$cor?>">
						<?= $d['nome'] ?>
					</td>
					<td align="center" style="line-height: 25px; font-size: 12px; color: <?=$cor?>">
						<?= $qtd_saldo ?>
					</td>
					<td align="right" style="line-height: 25px; font-size: 12px; color: <?=$cor?>">
						<?= $qtd_estoque_minimo ?>
					</td>
				</tr>
				<?php
				$i++;
			}
			?>
		<?php
		} else {
			?>
			<script>document.getElementById('impr').style.display = 'none';</script>
			<tr>
				<td colspan="3" align="center"><b>NÃO HÁ PRODUTO EM ESTOQUE MÍNIMO</b></td>
			</tr>
		<?php
		}
		?>
	</table>