<?php
include("config_inicio.php");
require_once($lib."classes/class.pedido.php");
require_once($lib."classes/class.utilidades.php");
require_once($lib.'classes/class.logs.php');

$_util	 	= new utilidades();
$_class 	= new pedido($dbase); 
$_logs    	= new logs($dbase);

$id			= $_POST["id"];	
$valor		= $_POST["valor"];
$valor		= str_replace(".","",$valor);
$valor		= str_replace(",",".",$valor);
$data		= date("Y/m/d");
$recibo		= $_POST["recibo"];
$formpg		= $_POST["formapag"];
$idpedido 	= $_class->getIdPedido($id);
$ret 		= $_class->updateEntrada($id,$valor,$data,$recibo,$formpg,$_SESSION["usuario"],2);
$mensagem 	 = $_SESSION["nome_usuario"]." -  RECEBEU ENTRADA NO VALOR DE: ".number_format($valor,2,",",".").", FORMA DE PAGAMENTO: ".$_class->getFormaPagamento($formpg).", CLIENTE: ".$_class->getCliente($idpedido);		
$res = $_logs->salvaLog($mensagem); 

$msg = $ret == true ? 1 : 0;
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "		<mensagem>".$msg."</mensagem>\n";
$xml .= "		<pedido>".$_SESSION["codpedido"]."</pedido>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>";
Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
?>
