<?php
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.cliente.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new cliente($dbase);
$_logs    	= new logs($dbase);
;

$id 		= $_POST["id"];
$valor   	= $_POST["valor"];
$valor   	= str_replace(".","",$valor);
$valor   	= str_replace(",",".",$valor);

$saldo		= $_class->getSaldo($id);
$saldo 		-= $valor;
$hoje		= date("Y/m/d"); 
$dados 		= $_class->get($id);

$ret = $_class->movimentaCredito($id,$valor,$saldo,$hoje,2);
$mensagem  = $_SESSION["nome_usuario"]." -  DEBITOU CREDITO NO VALOR DE: ".number_format($valor,2,",",".").", CLIENTE: ".$dados['nome'];		
$res = $_logs->salvaLog($mensagem); 

$msg = $ret == true ? 1 : 0;
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<dados>\n";
$xml .= "	<mensagem>".$msg."</mensagem>\n";
$xml .= "	</dados>\n";
$xml .= "</root>\n";

Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
?>