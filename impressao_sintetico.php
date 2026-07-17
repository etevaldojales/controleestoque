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
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Imprimir Relatório Sintético</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        h2, h4 {
            margin: 0 0 10px 0;
        }
        .header {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .filter-info {
            font-size: 13px;
            margin-bottom: 20px;
            color: #666;
        }
        .kpi-container {
            display: flex;
            margin-bottom: 25px;
        }
        .kpi-card {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            text-align: center;
            margin-right: 15px;
            background-color: #fafafa;
        }
        .kpi-card:last-child {
            margin-right: 0;
        }
        .kpi-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 5px;
        }
        .kpi-value {
            font-size: 20px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            font-size: 12px;
        }
        th {
            background-color: #eaeaea;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        @media print {
            body {
                margin: 0;
            }
            .kpi-card {
                border: 1px solid #000;
            }
            th {
                background-color: #eaeaea !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Relatório Sintético de Vendas</h2>
    </div>
    
    <div class="filter-info">
        <strong>Período:</strong> <?= htmlspecialchars($_POST['datai']) ?> à <?= htmlspecialchars($_POST['dataf']) ?>
        <?php if ($formapg): ?>
            <br><strong>Forma de Pagamento:</strong> 
            <?php
            $sqlFpgName = "SELECT descricao FROM tblformapagamento WHERE id = ? LIMIT 1";
            $rsFpgName = $dbase->query($sqlFpgName, array($formapg));
            if ($rsFpgName && !$rsFpgName->EOF) {
                echo htmlspecialchars($rsFpgName->fields['descricao']);
            } else {
                echo "Selecionada";
            }
            ?>
        <?php else: ?>
            <br><strong>Forma de Pagamento:</strong> Todas
        <?php endif; ?>
    </div>

    <?php if (count($dadosFpg) == 0): ?>
        <p style="text-align: center; font-weight: bold;">Nenhum registro encontrado para este período.</p>
    <?php else: ?>
        <div class="kpi-container">
            <div class="kpi-card">
                <div class="kpi-title">Total Vendido</div>
                <div class="kpi-value" style="color: #27ae60;">R$ <?= number_format($totalGeralValor, 2, ",", ".") ?></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">Total Custo</div>
                <div class="kpi-value" style="color: #c0392b;">R$ <?= number_format($totalGeralCusto, 2, ",", ".") ?></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">Lucro Total</div>
                <div class="kpi-value" style="color: #2980b9;">R$ <?= number_format($totalGeralLucro, 2, ",", ".") ?></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">Qtd. Vendas</div>
                <div class="kpi-value" style="color: #7f8c8d;"><?= $totalGeralQtd ?></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">Ticket Médio</div>
                <div class="kpi-value" style="color: #8e44ad;">R$ <?= number_format($ticketMedioGeral, 2, ",", ".") ?></div>
            </div>
        </div>

        <h4 style="border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">Resumo por Forma de Pagamento</h4>
        <table>
            <thead>
                <tr>
                    <th>Forma de Pagamento</th>
                    <th class="text-center" style="width: 10%;">Qtd. Vendas</th>
                    <th class="text-right" style="width: 15%;">Total Vendido</th>
                    <th class="text-right" style="width: 15%;">Total Custo</th>
                    <th class="text-right" style="width: 15%;">Lucro Total</th>
                    <th class="text-right" style="width: 15%;">Ticket Médio</th>
                    <th class="text-right" style="width: 12%;">Participação (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dadosFpg as $d): 
                    $part = $totalGeralValor > 0 ? ($d['total'] / $totalGeralValor * 100) : 0;
                    $tm = $d['qtd'] > 0 ? ($d['total'] / $d['qtd']) : 0;
                    $lucro = $d['total'] - $d['total_custo'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($d['forma_pgto']) ?></td>
                    <td class="text-center"><?= $d['qtd'] ?></td>
                    <td class="text-right">R$ <?= number_format($d['total'], 2, ",", ".") ?></td>
                    <td class="text-right">R$ <?= number_format($d['total_custo'], 2, ",", ".") ?></td>
                    <td class="text-right" style="color: <?= $lucro >= 0 ? '#27ae60' : '#c0392b' ?>;">R$ <?= number_format($lucro, 2, ",", ".") ?></td>
                    <td class="text-right">R$ <?= number_format($tm, 2, ",", ".") ?></td>
                    <td class="text-right"><?= number_format($part, 2, ",", ".") ?>%</td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td>TOTAL GERAL</td>
                    <td class="text-center"><?= $totalGeralQtd ?></td>
                    <td class="text-right">R$ <?= number_format($totalGeralValor, 2, ",", ".") ?></td>
                    <td class="text-right">R$ <?= number_format($totalGeralCusto, 2, ",", ".") ?></td>
                    <td class="text-right" style="color: <?= $totalGeralLucro >= 0 ? '#27ae60' : '#c0392b' ?>;">R$ <?= number_format($totalGeralLucro, 2, ",", ".") ?></td>
                    <td class="text-right">R$ <?= number_format($ticketMedioGeral, 2, ",", ".") ?></td>
                    <td class="text-right">100,00%</td>
                </tr>
            </tbody>
        </table>

        <h4 style="border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">Resumo Diário</h4>
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 25%;">Data</th>
                    <th class="text-center" style="width: 15%;">Qtd. Vendas</th>
                    <th class="text-right" style="width: 20%;">Total Vendido</th>
                    <th class="text-right" style="width: 20%;">Total Custo</th>
                    <th class="text-right" style="width: 20%;">Lucro Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dadosDia as $d): 
                    $lucroDia = $d['total'] - $d['total_custo'];
                ?>
                <tr>
                    <td class="text-center"><?= $_util->dataMySql2Php($d['dia']) ?></td>
                    <td class="text-center"><?= $d['qtd'] ?></td>
                    <td class="text-right">R$ <?= number_format($d['total'], 2, ",", ".") ?></td>
                    <td class="text-right">R$ <?= number_format($d['total_custo'], 2, ",", ".") ?></td>
                    <td class="text-right" style="color: <?= $lucroDia >= 0 ? '#27ae60' : '#c0392b' ?>;">R$ <?= number_format($lucroDia, 2, ",", ".") ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td class="text-center">TOTAL GERAL</td>
                    <td class="text-center"><?= $totalGeralQtd ?></td>
                    <td class="text-right">R$ <?= number_format($totalGeralValor, 2, ",", ".") ?></td>
                    <td class="text-right">R$ <?= number_format($totalGeralCusto, 2, ",", ".") ?></td>
                    <td class="text-right" style="color: <?= $totalGeralLucro >= 0 ? '#27ae60' : '#c0392b' ?>;">R$ <?= number_format($totalGeralLucro, 2, ",", ".") ?></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

    <script>
        window.print();
    </script>
</body>
</html>
