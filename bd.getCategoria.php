<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.categoria.php');

$_util 	= new utilidades;
$_class = new categoria($dbase);
$id  	= $_POST['id'];

$dados 		= $_class->get($id);
if (count($dados) > 0) {
$xml = "\n";
$xml .= "\n";
$xml .= "<root>\n";
$xml .= "	<dados>\n";
$xml .= "		<id>".$dados['id']."</id>\n";
$xml .= "		<nome>".$_util->codificaSqlAjax($dados['descricao'])."</nome>\n";
$xml .= "	</dados>\n";
$xml .= "</root>\n";
Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
}
