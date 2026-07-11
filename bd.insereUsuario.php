<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.usuario.php');


$_class    	= new usuario($dbase);
;

$nome      	= $_POST["nome_usu"];
$email     	= $_POST["email_usu"];
$fone     	= $_POST["fone_usu"];
$login     	= $_POST["login_usu"];
$senha     	= $_POST["senha_usu"] != "" ? md5($_POST["senha_usu"]) : "";
$tipo     	= $_POST["tipo_usu"];
$id			= $_POST["id"];

if($id == 0) {
	if($_class->verifica($_util->codificaAjaxSql($nome))) {
			$ret = $_class->insert($nome,$login,$senha,$email,$fone,'',1,$tipo);
			$msg = $ret == true ? 1 : 0;
	}
	else {
		$msg = 2;	
	}
}
else {
	$ret = $_class->update($id,$nome,$login,$senha,$email,$fone,'',1,$tipo);
	$msg = $ret == true ? 1 : 0;
}
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "	<mensagem>".$msg."</mensagem>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>\n";

Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
