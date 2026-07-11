<?php
include("config_inicio.php");
//$_SESSION["codigo_boleto"] = explode(",",$_POST["id"]);	
$_SESSION["codigo_boleto"] = $_POST["id"];	

$msg = 1;
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "		<mensagem>".$msg."</mensagem>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>";
Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;

