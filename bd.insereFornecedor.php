<?php
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.fornecedor.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new fornecedor($dbase);
$_logs    	= new logs($dbase);
;

$descricao   = isset($_POST['fornecedor']) ? $_POST['fornecedor'] : "";
$cod		 = $_POST["id"];
	
if ($cod == 0)
{ // insere
	$mensagem 	 = $_SESSION["nome_usuario"]." -  CADASTROU O FORNECEDOR: ".$descricao;		
	if($_class->verifica($_util->codificaAjaxSql($descricao))) {
		$ret = $_class->insert($_util->codificaAjaxSql($descricao));
		$res = $_logs->salvaLog($mensagem); 
		$msg = $ret == true ? 1 : 0;
	}
	else {
		$msg = 2;	
	}
}
else 
{ // sem arquivo ou com erro no upload
	$dados = $_class->get($cod);
	$mensagem 	 = $_SESSION["nome_usuario"]." -  ALTEROU O FORNECEDOR DE: ".$dados['descricao']." PARA ".$descricao;		
	$ret = $_class->update($cod,$_util->codificaAjaxSql($descricao));
	$res = $_logs->salvaLog($mensagem); 
	$msg = $ret == true ? 2 : 0;
}
echo json_encode($msg);
