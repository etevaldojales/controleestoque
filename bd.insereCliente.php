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
require_once($lib.'classes/class.cliente.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new cliente($dbase);
$_logs    	= new logs($dbase);

$nome 		= $_POST["nome"];
$email   	= $_POST["email"];
$fone   	= $_POST["fone"];
$endereco	= $_POST["endereco"];
$stativo	= 1; //$_POST["stativo"];
$cod		= $_POST["id"];



if ($cod == 0)
{ // insere
	if($_class->verifica($util->codificaAjaxSql($nome))) {
		$ret = $_class->insert($nome,$fone,$email,$endereco,$stativo);
		if($ret) {
			$mensagem 	 = $_SESSION["nome_usuario"]." -  CADASTROU O CLIENTE: ".$nome.", ENDERE�O: ".$endereco.", TELEFONE: ".$fone.", EMAIL: ".$email;		
			$res = $_logs->salvaLog($mensagem); 
		}
		$msg = 1;
	}
	else {
		$msg = 2;	
	}
}
else 
{ // sem arquivo ou com erro no upload
	$dados = $_class->get($cod);
	$mensagem 	 = $_SESSION["nome_usuario"]." -  ALTEROU O CLIENTE: ".$dados['nome'].". DADOS ANTERIORES: NOME: ".$dados['nome'].", EMAIL: ".$dados['email'].", TELEFONE: ".$dados['telefone'].", ENDEREÇO: ".$dados['endereco']." DADOS ATUAIS: NOME: ".$nome.", EMAIL: ".$email.", TELEFONE: ".$fone.", ENDEREÇO: ".$endereco;	
	$ret = $_class->update($cod,$nome,$fone,$email,$endereco,$stativo);
	$_logs->salvaLog($mensagem); 
	$msg = 1;
}
if($msg != 2) {
	$msg = $ret == true ? 1 : 0;
}
echo json_encode($msg);
