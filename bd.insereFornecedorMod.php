<?php
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.fornecedor.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new fornecedor($dbase);
$_logs    	= new logs($dbase);
;

$descricao   = isset($_POST["nmfornecedor"]) ? $_POST["nmfornecedor"] : '';
$cod         = 0;
$msg         = array('status' => 0);
	
if ($cod == 0)
{ // insere
	$mensagem 	 = $_SESSION["nome_usuario"]." -  CADASTROU O FORNECEDOR: ".$descricao;		
	if($_class->verifica($_util->codificaAjaxSql($descricao))) {
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
