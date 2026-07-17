<?php
include("config_inicio.php");
require_once($lib . "classes/class.utilidades.php");

$_util = new utilidades();

$datai = $_POST['datai'] != "" ? $_util->dataPhp2MySql($_POST['datai']) : "";
$dataf = $_POST['dataf'] != "" ? $_util->dataPhp2MySql($_POST['dataf']) : "";
$formapg = $_POST['formapg'] != "" ? $_POST['formapg'] : "";

$where_parc = "where p.status_pedido = 2 and parc.flgstatus = 2 ";
if ($datai && $dataf) {
    $where_parc .= "and p.data_pedido BETWEEN '$datai 00:00:00' AND '$dataf 23:59:59' ";
} else {
    if ($datai) {
        $where_parc .= "and p.data_pedido >= '$datai 00:00:00' ";
    }
    if ($dataf) {
        $where_parc .= "and p.data_pedido <= '$dataf 23:59:59' ";
    }
}
if ($formapg) {
    $where_parc .= "and parc.id_forma_pag = '$formapg' ";
}

// 1. Grouped by Payment Method
$sqlFpg = "SELECT fpg.descricao as forma_pgto, count(distinct p.id) as qtd, sum(parc.valor_pag) as total, sum(p.valor_custo * (parc.valor_pag / IF(p.valor > 0, p.valor, 1))) as total_custo ";
$sqlFpg .= "FROM tblparcela parc ";
$sqlFpg .= "INNER JOIN tblpedido p ON p.id = parc.id_pedido ";
$sqlFpg .= "INNER JOIN tblformapagamento fpg ON fpg.id = parc.id_forma_pag ";
$sqlFpg .= "$where_parc ";
$sqlFpg .= "GROUP BY parc.id_forma_pag, fpg.descricao ";
$sqlFpg .= "ORDER BY total DESC";
$rsFpg = $dbase->query($sqlFpg);

$dadosFpg = array();
$totalGeralValor = 0;
$totalGeralCusto = 0;
$totalGeralQtd = 0;

if ($rsFpg) {
    while (!$rsFpg->EOF) {
        $dadosFpg[] = array(
            'forma_pgto' => $rsFpg->fields['forma_pgto'],
            'qtd' => intval($rsFpg->fields['qtd']),
            'total' => floatval($rsFpg->fields['total']),
            'total_custo' => floatval($rsFpg->fields['total_custo'])
        );
        $totalGeralValor += floatval($rsFpg->fields['total']);
        $totalGeralCusto += floatval($rsFpg->fields['total_custo']);
        $totalGeralQtd += intval($rsFpg->fields['qtd']);
        $rsFpg->MoveNext();
    }
}

$totalGeralLucro = $totalGeralValor - $totalGeralCusto;
$ticketMedioGeral = $totalGeralQtd > 0 ? ($totalGeralValor / $totalGeralQtd) : 0;

// 2. Grouped by Date (Daily Summary)
$sqlDia = "SELECT DATE(p.data_pedido) as dia, count(distinct p.id) as qtd, sum(parc.valor_pag) as total, sum(p.valor_custo * (parc.valor_pag / IF(p.valor > 0, p.valor, 1))) as total_custo ";
$sqlDia .= "FROM tblparcela parc ";
$sqlDia .= "INNER JOIN tblpedido p ON p.id = parc.id_pedido ";
$sqlDia .= "$where_parc ";
$sqlDia .= "GROUP BY DATE(p.data_pedido) ";
$sqlDia .= "ORDER BY dia ASC";
$rsDia = $dbase->query($sqlDia);

$dadosDia = array();
if ($rsDia) {
    while (!$rsDia->EOF) {
        $dadosDia[] = array(
            'dia' => $rsDia->fields['dia'],
            'qtd' => intval($rsDia->fields['qtd']),
            'total' => floatval($rsDia->fields['total']),
            'total_custo' => floatval($rsDia->fields['total_custo'])
        );
        $rsDia->MoveNext();
    }
}
?>

<?php if (count($dadosFpg) == 0): ?>
    <script>
        document.getElementById('impr').style.display = 'none';
    </script>
    <div class="alert alert-warning" style="text-align: center; font-weight: bold; margin-top: 20px; font-size: 14px;">
        NÃO HÁ VENDAS PARA O PERÍODO CONSULTADO
    </div>
<?php else: ?>
    <script>
        document.getElementById('impr').style.display = 'block';
        document.getElementById('datai').value = '<?= htmlspecialchars($_POST['datai']) ?>';
        document.getElementById('dataf').value = '<?= htmlspecialchars($_POST['dataf']) ?>';
        document.getElementById('formapg_hidden').value = '<?= htmlspecialchars($_POST['formapg']) ?>';
    </script>

    <!-- KPI Summary Cards -->
    <div class="row-fluid" style="margin-top: 15px;">
        <div class="span4">
            <div class="well" style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 4px; padding: 15px; margin-bottom: 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h4 style="margin: 0; color: #6c757d; font-size: 14px; text-transform: uppercase;">Total Vendido</h4>
                <h2 style="color: #35aa47; font-weight: bold; margin: 10px 0 0 0; font-size: 28px;">R$ <?= number_format($totalGeralValor, 2, ",", ".") ?></h2>
            </div>
        </div>
        <div class="span4">
            <div class="well" style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 4px; padding: 15px; margin-bottom: 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h4 style="margin: 0; color: #6c757d; font-size: 14px; text-transform: uppercase;">Total Custo</h4>
                <h2 style="color: #d9534f; font-weight: bold; margin: 10px 0 0 0; font-size: 28px;">R$ <?= number_format($totalGeralCusto, 2, ",", ".") ?></h2>
            </div>
        </div>
        <div class="span4">
            <div class="well" style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 4px; padding: 15px; margin-bottom: 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h4 style="margin: 0; color: #6c757d; font-size: 14px; text-transform: uppercase;">Lucro Total</h4>
                <h2 style="color: #0275d8; font-weight: bold; margin: 10px 0 0 0; font-size: 28px;">R$ <?= number_format($totalGeralLucro, 2, ",", ".") ?></h2>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <div class="well" style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 4px; padding: 15px; margin-bottom: 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h4 style="margin: 0; color: #6c757d; font-size: 14px; text-transform: uppercase;">Qtd. Vendas</h4>
                <h2 style="color: #4d90fe; font-weight: bold; margin: 10px 0 0 0; font-size: 28px;"><?= $totalGeralQtd ?></h2>
            </div>
        </div>
        <div class="span6">
            <div class="well" style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 4px; padding: 15px; margin-bottom: 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h4 style="margin: 0; color: #6c757d; font-size: 14px; text-transform: uppercase;">Ticket Médio</h4>
                <h2 style="color: #852b99; font-weight: bold; margin: 10px 0 0 0; font-size: 28px;">R$ <?= number_format($ticketMedioGeral, 2, ",", ".") ?></h2>
            </div>
        </div>
    </div>

    <!-- Table 1: Payment Method Summary -->
    <h4 style="margin-top: 10px; font-weight: bold; color: #444;"><i class="icon-credit-card"></i> Resumo por Forma de Pagamento</h4>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr style="background-color: #e5e5e5;">
                <th style="font-size: 12px; font-weight: bold;">Forma de Pagamento</th>
                <th style="text-align: center; font-size: 12px; font-weight: bold; width: 10%;">Qtd. Vendas</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold; width: 15%;">Total Vendido</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold; width: 15%;">Total Custo</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold; width: 15%;">Lucro Total</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold; width: 15%;">Ticket Médio</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold; width: 12%;">Participação (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dadosFpg as $d): 
                $part = $totalGeralValor > 0 ? ($d['total'] / $totalGeralValor * 100) : 0;
                $tm = $d['qtd'] > 0 ? ($d['total'] / $d['qtd']) : 0;
                $lucro = $d['total'] - $d['total_custo'];
            ?>
            <tr>
                <td style="font-size: 12px;"><?= htmlspecialchars($d['forma_pgto']) ?></td>
                <td style="text-align: center; font-size: 12px;"><?= $d['qtd'] ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($d['total'], 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($d['total_custo'], 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px; color: <?= $lucro >= 0 ? '#27ae60' : '#d9534f' ?>;">R$ <?= number_format($lucro, 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($tm, 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px;"><?= number_format($part, 2, ",", ".") ?>%</td>
            </tr>
            <?php endforeach; ?>
            <tr style="font-weight: bold; background-color: #f1f3f5;">
                <td style="font-size: 12px;">TOTAL GERAL</td>
                <td style="text-align: center; font-size: 12px;"><?= $totalGeralQtd ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($totalGeralValor, 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($totalGeralCusto, 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px; color: <?= $totalGeralLucro >= 0 ? '#27ae60' : '#d9534f' ?>;">R$ <?= number_format($totalGeralLucro, 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($ticketMedioGeral, 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px;">100,00%</td>
            </tr>
        </tbody>
    </table>

    <!-- Table 2: Daily Timeline Summary -->
    <h4 style="margin-top: 25px; font-weight: bold; color: #444;"><i class="icon-calendar"></i> Resumo Diário</h4>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr style="background-color: #e5e5e5;">
                <th style="text-align: center; font-size: 12px; font-weight: bold; width: 25%;">Data</th>
                <th style="text-align: center; font-size: 12px; font-weight: bold; width: 15%;">Qtd. Vendas</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold; width: 20%;">Total Vendido</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold; width: 20%;">Total Custo</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold; width: 20%;">Lucro Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dadosDia as $d): 
                $lucroDia = $d['total'] - $d['total_custo'];
            ?>
            <tr>
                <td style="text-align: center; font-size: 12px;"><?= $_util->dataMySql2Php($d['dia']) ?></td>
                <td style="text-align: center; font-size: 12px;"><?= $d['qtd'] ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($d['total'], 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($d['total_custo'], 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px; color: <?= $lucroDia >= 0 ? '#27ae60' : '#d9534f' ?>;">R$ <?= number_format($lucroDia, 2, ",", ".") ?></td>
            </tr>
            <?php endforeach; ?>
            <tr style="font-weight: bold; background-color: #f1f3f5;">
                <td style="text-align: center; font-size: 12px;">TOTAL GERAL</td>
                <td style="text-align: center; font-size: 12px;"><?= $totalGeralQtd ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($totalGeralValor, 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($totalGeralCusto, 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px; color: <?= $totalGeralLucro >= 0 ? '#27ae60' : '#d9534f' ?>;">R$ <?= number_format($totalGeralLucro, 2, ",", ".") ?></td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>
