<?php
include("config_inicio.php");
require_once($lib."classes/class.pedido.php");
require_once($lib."classes/class.utilidades.php");
require_once($lib.'classes/class.logs.php');

$_util	 	= new utilidades();
$_class 	= new pedido($dbase); 
$_logs    	= new logs($dbase);

$formpg		= $_POST["formpgentrada"];
$datapg 	= $_POST["dtentrada"] != "" ? $_util->dataPhp2MySql($_POST["dtentrada"]) : "";
$valor 		= $_POST["valor_entrada"];
$valor		= str_replace(".","",$valor);
$valor		= str_replace(",",".",$valor);
$recibo		= $_POST["recibo"];
$cod 		= $_POST["codigo"];

//$hoje 		= date("Y/m/d");
if(comparaData($datapg)) {
	$valor_pag = $valor;
	$data_pgto = $datapg;
	$valor_rec = $valor;
	$flgstatus = 2;
}
else {
	$valor_pag = 0;
	$data_pgto = '';
	$valor_rec = 0;
	$flgstatus = 1;
}
$cdEntrada  = $_class->verificaEntrada($cod);
if($cdEntrada == 0) { 
	$res		= $_class->inserirEntrada($_SESSION["usuario"],$cod,$formpg,$valor,$datapg,$valor_pag,$data_pgto,$valor_rec,0,0,$flgstatus,$recibo);
	$mensagem 	 = $_SESSION["nome_usuario"]." -  RECEBEU ENTRADA NO VALOR DE: ".number_format($valor,2,",",".").", FORMA DE PAGAMENTO: ".$_class->getFormaPagamento($formpg).", CLIENTE: ".$_class->getCliente($idpedido);		
	$res = $_logs->salvaLog($mensagem); 
	
}
else {
	$res		= $_contrato->alteraEntrada($cdEntrada,$_SESSION["usuario"],$cod,$formpg,$valor,$datapg,$valor_pag,$data_pgto,$valor_rec,0,0,$flgstatus,$recibo);
	$mensagem 	 = $_SESSION["nome_usuario"]." -  RECEBEU ENTRADA NO VALOR DE: ".number_format($valor,2,",",".").", FORMA DE PAGAMENTO: ".$_class->getFormaPagamento($formpg).", CLIENTE: ".$_class->getCliente($idpedido);		
	$res = $_logs->salvaLog($mensagem); 
}
$stotal 	= $_class->getValorPedido($cod); // retorna valor pedido somando os valores dos itens do pedido
$total 		= $total - $valor;
$res = $_logs->salvaLog($mensagem); 

// XML que será retornado
$xml = "\n";
$xml .= "\n";
$xml .= "<root>\n";
$xml .= "	<dados>\n";
$xml .= "		<entrada>".number_format($valor,2,",",".")."</entrada>\n";
$xml .= "		<total>".number_format($total,2,",",".")."</total>\n";
$xml .= "		<subtotal>".number_format($stotal,2,",",".")."</subtotal>\n";
$xml .= "	</dados>\n";
$xml .= "</root>\n"; 
Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;

function comparaData($data) {
	$dt_atual		= date("Y-m-d"); // data atual
	$timestamp_dt_atual 	= strtotime($dt_atual); // converte para timestamp Unix
	 
	$dt_pag		= $data; // data de expiração do anúncio
	$timestamp_dt_pag	= strtotime($dt_pag); // converte para timestamp Unix
	 
	// data atual é maior que a data de expiração
	if ($timestamp_dt_atual == $timestamp_dt_pag) { // true
	  return true;
	}
	else {// false
	  return false;	
	}
}	
