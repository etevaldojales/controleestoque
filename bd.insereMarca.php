<?php
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.marca.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new marca($dbase);
$_logs    	= new logs($dbase);
;

$descricao   = isset($_POST['marca']) ? $_POST['marca'] : "";
$cod		 = $_POST["id"];
	
if ($cod == 0)
{ // insere
	$mensagem 	 = $_SESSION["nome_usuario"]." -  CADASTROU A MARCA: ".$descricao;		
	if($_class->verifica($descricao)) {
		$ret = $_class->insert($descricao);
		$_logs->salvaLog($mensagem); 
		$msg = 1;
	}
	else {
		$msg = 2;	
	}
}
else 
{ // sem arquivo ou com erro no upload
	$dados = $_class->get($cod);
	$mensagem 	 = $_SESSION["nome_usuario"]." -  ALTEROU A MARCA DE: ".$dados['descricao']." PARA ".$descricao;		
	$ret = $_class->update($cod,$descricao);
	$res = $_logs->salvaLog($mensagem); 
	$msg = 3;
}
echo json_encode($msg);
