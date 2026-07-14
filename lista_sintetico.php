<?php
include("config_inicio.php");
require_once($lib . "classes/class.utilidades.php");

$_util = new utilidades();

$datai = $_POST['datai'] != "" ? $_util->dataPhp2MySql($_POST['datai']) : "";
$dataf = $_POST['dataf'] != "" ? $_util->dataPhp2MySql($_POST['dataf']) : "";
$formapg = $_POST['formapg'] != "" ? $_POST['formapg'] : "";

$where = "where p.status_pedido = 2 ";
if ($datai && $dataf) {
    $where .= "and p.data_pedido BETWEEN '$datai 00:00:00' AND '$dataf 23:59:59' ";
} else {
    if ($datai) {
        $where .= "and p.data_pedido >= '$datai 00:00:00' ";
    }
    if ($dataf) {
        $where .= "and p.data_pedido <= '$dataf 23:59:59' ";
    }
}
if ($formapg) {
    $where .= "and p.id_formapag = '$formapg' ";
}

// 1. Grouped by Payment Method
$sqlFpg = "SELECT fpg.descricao as forma_pgto, count(p.id) as qtd, sum(p.valor_venda) as total ";
$sqlFpg .= "FROM tblpedido p ";
$sqlFpg .= "INNER JOIN tblformapagamento fpg ON fpg.id = p.id_formapag ";
$sqlFpg .= "$where ";
$sqlFpg .= "GROUP BY p.id_formapag, fpg.descricao ";
$sqlFpg .= "ORDER BY total DESC";
$rsFpg = $dbase->query($sqlFpg);

$dadosFpg = array();
$totalGeralValor = 0;
$totalGeralQtd = 0;

if ($rsFpg) {
    while (!$rsFpg->EOF) {
        $dadosFpg[] = array(
            'forma_pgto' => $rsFpg->fields['forma_pgto'],
            'qtd' => intval($rsFpg->fields['qtd']),
            'total' => floatval($rsFpg->fields['total'])
        );
        $totalGeralValor += floatval($rsFpg->fields['total']);
        $totalGeralQtd += intval($rsFpg->fields['qtd']);
        $rsFpg->MoveNext();
    }
}

$ticketMedioGeral = $totalGeralQtd > 0 ? ($totalGeralValor / $totalGeralQtd) : 0;

// 2. Grouped by Date (Daily Summary)
$sqlDia = "SELECT DATE(p.data_pedido) as dia, count(p.id) as qtd, sum(p.valor_venda) as total ";
$sqlDia .= "FROM tblpedido p ";
$sqlDia .= "$where ";
$sqlDia .= "GROUP BY DATE(p.data_pedido) ";
$sqlDia .= "ORDER BY dia ASC";
$rsDia = $dbase->query($sqlDia);

$dadosDia = array();
if ($rsDia) {
    while (!$rsDia->EOF) {
        $dadosDia[] = array(
            'dia' => $rsDia->fields['dia'],
            'qtd' => intval($rsDia->fields['qtd']),
            'total' => floatval($rsDia->fields['total'])
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
                <h4 style="margin: 0; color: #6c757d; font-size: 14px; text-transform: uppercase;">Qtd. Vendas</h4>
                <h2 style="color: #4d90fe; font-weight: bold; margin: 10px 0 0 0; font-size: 28px;"><?= $totalGeralQtd ?></h2>
            </div>
        </div>
        <div class="span4">
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
                <th style="text-align: center; font-size: 12px; font-weight: bold; width: 15%;">Qtd. Vendas</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold; width: 22%;">Total Vendido</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold; width: 22%;">Ticket Médio</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold; width: 18%;">Participação (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dadosFpg as $d): 
                $part = $totalGeralValor > 0 ? ($d['total'] / $totalGeralValor * 100) : 0;
                $tm = $d['qtd'] > 0 ? ($d['total'] / $d['qtd']) : 0;
            ?>
            <tr>
                <td style="font-size: 12px;"><?= htmlspecialchars($d['forma_pgto']) ?></td>
                <td style="text-align: center; font-size: 12px;"><?= $d['qtd'] ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($d['total'], 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($tm, 2, ",", ".") ?></td>
                <td style="text-align: right; font-size: 12px;"><?= number_format($part, 2, ",", ".") ?>%</td>
            </tr>
            <?php endforeach; ?>
            <tr style="font-weight: bold; background-color: #f1f3f5;">
                <td style="font-size: 12px;">TOTAL GERAL</td>
                <td style="text-align: center; font-size: 12px;"><?= $totalGeralQtd ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($totalGeralValor, 2, ",", ".") ?></td>
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
                <th style="text-align: center; font-size: 12px; font-weight: bold; width: 30%;">Data</th>
                <th style="text-align: center; font-size: 12px; font-weight: bold; width: 30%;">Qtd. Vendas</th>
                <th style="text-align: right; font-size: 12px; font-weight: bold;">Total Vendido</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dadosDia as $d): ?>
            <tr>
                <td style="text-align: center; font-size: 12px;"><?= $_util->dataMySql2Php($d['dia']) ?></td>
                <td style="text-align: center; font-size: 12px;"><?= $d['qtd'] ?></td>
                <td style="text-align: right; font-size: 12px;">R$ <?= number_format($d['total'], 2, ",", ".") ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
