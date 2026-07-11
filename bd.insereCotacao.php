<?php
session_start();
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.cotacao.php');
require_once($lib.'classes/class.fornecedor.php');
require_once($lib.'classes/class.marca.php');
require_once($lib.'classes/class.categoria.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new cotacao($dbase);
$_forn    	= new fornecedor($dbase);
$_marca    	= new marca($dbase);
$_cat    	= new categoria($dbase);
$_logs    	= new logs($dbase);
;

$fornecedor	= $_POST["fornecedor"];
$marca		= $_POST["marca"];
$codigo	= $_POST["codigo"];
$valor		= str_replace(".","",$_POST["valor"]);
$valor		= str_replace(",",".",$valor);
$ipi		= $_POST["ipi"];
$valorf		= str_replace(".","",$_POST["valorf"]);
$valorf		= str_replace(",",".",$valorf);
$categoria	= $_POST["categoria"];
$data		= date("Y/m/d");	
$observacao = $_POST["observacao"];
$cod			= $_POST["id"];

if($cod == 0) {
	$ret = $_class->insert($fornecedor,$marca,$categoria,$_SESSION["usuario"],$_util->codificaAjaxSql($codigo),$ipi,$data,$valor,$valorf,$_util->codificaAjaxSql($observacao));
	if($ret) {
		$forn	= $_forn->get($fornecedor);
		$dmarca	= $_marca->get($marca);
		$dcat	= $_cat->get($categoria);
		$mensagem 	 = $_SESSION["nome_usuario"]." -  CADASTROU COTACAO - FORNECEDOR".$forn['descricao'].", VALOR: ".number_format($valor).", IPI: ".$ipi."%, ";
		$mensagem .= "MARCA: ".$dmarca['descricao'].", VALOR FINAL:".number_format($valorf).", codigo: ".$codigo.", CATEGORIA: ".$dcat['descricao'].", ";
		$mensagem .= "OBSERVAÇÕES: ".$observacao.", DATA: ".date("d/m/Y");		
	}
}
else {
	$ret = $_class->update($cod,$fornecedor,$marca,$categoria,$_SESSION["usuario"],$_util->codificaAjaxSql($codigo),$ipi,$data,$valor,$valorf,$_util->codificaAjaxSql($observacao));
	if($ret) {
		$mensagem 	 = $_SESSION["nome_usuario"]." -  ALETROU COTACAO - FORNECEDOR".$forn['descricao'].", VALOR: ".number_format($valor).", IPI: ".$ipi."%, ";
		$mensagem .= "MARCA: ".$dmarca['descricao'].", VALOR FINAL:".number_format($valorf).", codigo: ".$codigo.", CATEGORIA: ".$dcat['descricao'].", ";
		$mensagem .= "OBSERVAÇÕES: ".$observacao.", DATA: ".date("d/m/Y");		
	}
}
$res = $_logs->salvaLog($mensagem); 
$msg = $ret == true ? 1 : 0;	
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "	<mensagem>".$msg."</mensagem>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>\n";

Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
