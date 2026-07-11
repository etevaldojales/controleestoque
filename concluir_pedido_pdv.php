<?php
include("config_inicio.php");
require_once($lib . "classes/class.pedido.php");
require_once($lib . "classes/class.parcela.php");
require_once($lib . "classes/class.utilidades.php");
require_once($lib . 'classes/class.logs.php');

$_util = new utilidades();
$_class = new pedido($dbase);
$_parcela = new parcela($dbase);
$_logs = new logs($dbase);

$codpedido = $_POST["id"];
$pedido = $_class->get($codpedido);
$obs = $_POST["obs"];
$formpag = $_POST["formpag"];
$numparc = $_POST["numparc"];
$primvenc = $numparc > 1 ? addDiasData(date('Y/m/d'), 1) : date('Y/m/d');
$total = $pedido['valor'];
$recibo = "";
$data = date("Y-m-d");
$entrada = $_class->getEntrada($codpedido);
 

// alterar pedido
$altera = $_class->update($codpedido, $pedido['id_cliente'], $pedido['numero_pedido'], date('Y/m/d'), $primvenc, $numparc, $formpag, $pedido['valor_custo'], $pedido['valor_venda'], $pedido['valor'], 2, $_util->codificaAjaxSql($obs));
$dados = $_class->get($codpedido);
$mensagem = $_SESSION["nome_usuario"] . " -  CADASTROU PEDIDO Nº: " . $dados['numero_pedido'] . ", FORMA DE PAGAMENTO:" . $_class->getFormaPagamento($formpag) . ", CLIENTE: " . $_class->getCliente($codpedido) . ", VALOR DE CUSTO: R$ " . number_format($pedido['valor_custo'], 2, ",", ".") . "VALOR DO PEDIDO: R$ " . number_format($pedido['valor'], 2, ",", ".");
//$res = $_logs->salvaLog($mensagem); 

// fim contrato
$total = $total - $entrada;

// insere parcelas
if ($codpedido > 0) {
	$valparc = number_format(($total / $numparc), 2);
	$valparc = str_replace(",", "", $valparc);
	$stotal = 0;
	$nossonum = $_parcela->getUltimoNossoNumero();
	$msg = $_parcela->insert($codpedido, $valparc, $_util->dataPhp2MySql($primvenc), 0, '', 0, 0, 0, 1, $_SESSION["usuario"], $formpag, $nossonum);
	$stotal = $stotal + $valparc;
	for ($n = 1; $n <= ($numparc - 1); $n++) {
		$proxvenc = $n == 1 ? addDiasData($primvenc, $n) : addDiasData($proxvenc, $n);
		$nossonum = $_parcela->getUltimoNossoNumero();
		if ($n < ($numparc - 1)) {
			$msg = $_parcela->insert($codpedido, $valparc, $_util->dataPhp2MySql($proxvenc), 0, '', 0, 0, 0, 1, $_SESSION["usuario"], $formpag, $nossonum);
			$stotal = $stotal + $valparc;
		} else {
			$valparc = ($total - $stotal);
			$msg = $_parcela->insert($codpedido, $valparc, $_util->dataPhp2MySql($proxvenc), 0, '', 0, 0, 0, 1, $_SESSION["usuario"], $formpag, $nossonum);
		}
	}

	$parcela = $_parcela->getParcela($codpedido);
	$ret = $_parcela->update($parcela['id'], $parcela['id_pedido'], $parcela['valor_parcela'], $parcela['vencimento'], $parcela['valor_parcela'], $data, $parcela['valor_parcela'], 0, 0, 2, $_SESSION["usuario"], $recibo, $formapg);
	$mensagem = $_SESSION["nome_usuario"] . " -  DEU BAIXA NA PARCELA DE VENCIMENTO: " . $_util->dataMySql2Php($parcela['vencimento']) . ", NO VALOR DE: " . number_format($parcela['valor_parcela'], 2, ",", ".") . ", FORMA DE PAGAMENTO: " . $_class->getFormaPagamento($parcela['id_forma_pag']) . ", CLIENTE: " . $_parcela->getCliente($codpedido);
	$res = $_logs->salvaLog($mensagem);

}
// fim insere parcelas

$msg = 1;

$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "		<mensagem>" . $msg . "</mensagem>\n";
$xml .= "		<codpedido>" . $codpedido . "</codpedido>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>";
Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;

function addDiasData($dat, $n)
{
	$data = explode("/", $dat);
	$dia = $data[0];
	$mes = $data[1];
	$ano = $data[2];
	//$dataFinal = mktime(24*$dias, 0, 0, $mes, $dia, $ano);
	if ($mes < 12) {
		$pmes = $mes + 1;
		$pmes = $pmes < 10 ? "0" . $pmes : $pmes;
		$dataFinal = $dia . '/' . $pmes . '/' . $ano;
	} else {
		$pmes = "01";
		$ano = $ano + 1;
		$dataFinal = $dia . '/' . $pmes . '/' . $ano;
	}
	//$dataFormatada = date('Y/m/d',$dataFinal);		
	return $dataFinal;
}
