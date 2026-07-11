<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.estoque.php');

$_class = new estoque($dbase);
$id  	= $_POST['id'];

$qtd	= $_class->getQuantidadeAcumulado($id);
$estmin	 = $_class->getEstoqueMinimo($id);

$qtd 	= $qtd > 0 ? $qtd : 0;
$xml = "\n";
$xml .= "\n";
$xml .= "<root>\n";
$xml .= "	<dados>\n";
$xml .= "		<qtd>".$qtd."</qtd>\n";
$xml .= "		<estmin>".$estmin."</estmin>\n";
$xml .= "	</dados>\n";
$xml .= "</root>\n";
Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
