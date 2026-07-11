<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.usuario.php');

$_util 	= new utilidades;
$_class = new usuario($dbase);
$id  	= $_POST['id'];

$dados 		= $_class->get($id);
if (count($dados) > 0) {
	$xml = "\n";
	$xml .= "\n";
	$xml .= "<root>\n";
	$xml .= "	<dados>\n";
	$xml .= "		<id>".$dados['id_usuario']."</id>\n";
	$xml .= "		<nome>".$_util->codificaSqlAjax($dados['nome'])."</nome>\n";
	$xml .= "		<login>".$dados['login']."</login>\n";
	$xml .= "		<email>".$dados['email']."</email>\n";
	$xml .= "		<fone>".$dados['telefone']."</fone>\n";
	$xml .= "		<tipo>".$dados['tipo']."</tipo>\n";
	$xml .= "		<foto>".$dados['foto']."</foto>\n";
	$xml .= "	</dados>\n";
	$xml .= "</root>\n";
	Header("Content-type: application/xml; charset=iso-8859-1");
	echo $xml;
}
?>