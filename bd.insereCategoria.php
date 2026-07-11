<?php
session_start();
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.utilidades.php');
$util = new utilidades();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$util->validate_csrf_token()) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'CSRF token invalid']);
    exit;
}
require_once($lib.'classes/class.categoria.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new categoria($dbase);
$_logs    	= new logs($dbase);
;

$descricao   = isset($_POST['categoria']) ? $_POST['categoria'] : "";
$cod		 = $_POST["id"];
	
if ($cod == 0)
{ // insere
	$mensagem 	 = $_SESSION["nome_usuario"]." -  CADASTROU A CATEGORIA: ".$descricao;		
	if($_class->verificaCadastro($descricao)) {
		$ret = $_class->insert($descricao);
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
	$mensagem 	 = $_SESSION["nome_usuario"]." -  ALTEROU A CATEGORIA DE: ".$dados['descricao']." PARA ".$descricao;		
	$ret = $_class->update($cod,$descricao);
	$res = $_logs->salvaLog($mensagem); 
	$msg = $ret == true ? 2 : 0;
}
echo json_encode($msg);
