<?php
include("config_inicio.php");
require_once($lib."classes/class.parcela.php");
require_once($lib."classes/class.utilidades.php");

$_util	 	= new utilidades();
$_parcela 	= new parcela($dbase); 
$cod		= $_POST["id"];
$data  		= $_POST["data"] != "" ? $_util->dataPhp2MySql($_POST["data"]) : "";
$dados		= $_parcela->get($cod);
$res		= $_parcela->updateEstorno($cod,$data,$_SESSION["usuario"]);
$msg 		= $res == true ? 1 : 0;
// XML que será retornado
$xml = "\n";
$xml .= "\n";
$xml .= "<root>\n";
		$xml .= "	<dados>\n";
		$xml .= "		<id>".$dados['id_pedido']."</id>\n";
		$xml .= "		<mensagem>".$msg."</mensagem>\n";
		$xml .= "	</dados>\n";
$xml .= "</root>\n"; 
Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
