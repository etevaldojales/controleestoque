<?php
session_start();
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.categoria.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new categoria($dbase);
$_logs    	= new logs($dbase);
;

$descricao   = $_POST["nmcategoria"];
$cod         = 0;
$msg         = array('status' => 0);
	
if ($cod == 0)
{ // insere
	$mensagem 	 = $_SESSION["nome_usuario"]." -  CADASTROU A CATEGORIA: ".$descricao;		
	if($_class->verificaCadastro($_util->codificaAjaxSql($descricao))) {
		$ret = $_class->insert($_util->codificaAjaxSql($descricao));
		if ($ret !== false) {
			$insert_id = $dbase->Insert_ID();
			$_logs->salvaLog($mensagem); 
			$msg = array('status' => 1, 'id' => $insert_id);
		}
	}
	else {
		$msg = array('status' => 2);	
	}
}

echo json_encode($msg);