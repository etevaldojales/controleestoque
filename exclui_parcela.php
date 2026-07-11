<?php
include("config_inicio.php");
require_once($lib."classes/class.parcela.php");
require_once($lib."classes/class.pedido.php");
require_once($lib."classes/class.utilidades.php");
require_once($lib.'classes/class.logs.php');

$_util	 	= new utilidades();
$_class 	= new parcela($dbase); 
$_pedido 	= new pedido($dbase); 
$_logs    	= new logs($dbase);

$id			= $_POST["id"];	
$parcela	= $_class->get($id);
$ret 		= $_class->delete($id);
$pedido		= $_pedido->get($parcela['id_pedido']);
$numParc 	= ($pedido['num_parc'] - 1);
$ret		= $_pedido->updateNumParcela($pedido['id'],$numParc);
$mensagem 	 = $_SESSION["nome_usuario"]." -  EXCLUIU A PARCELA DO PEDIDO N� ".$pedido['numero_pedido'].", NO VALOR DE ".number_format($parcela['valor_parcela'],2,",",".").", VENCIMENTO: ".$_util->dataMySql2Php($parcela['vencimento']);
$_logs->salvaLog($mensagem); 

$msg = $ret == true ? 1 : 0;
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "		<mensagem>".$msg."</mensagem>\n";
$xml .= "		<pedido>".$pedido['id']."</pedido>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>";
Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
