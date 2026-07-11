<?php
session_start();
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.utilidades.php');
$util = new utilidades();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$util->validate_csrf_token()) {
    header('Content-Type: application/xml; charset=iso-8859-1');
    $xml = "<root><retorno><erro>CSRF token invalid</erro></retorno></root>";
    echo $xml;
    exit;
}
require_once($lib.'classes/class.pedido.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new pedido($dbase);
$_logs    	= new logs($dbase);
;

$idpedido	= $_POST["idpedido"];
$descricao 	= $_POST["descricao"];
$valor   	= $_POST["valor"];


// veerificar se o item ja foi cadastrado para o pedido
if($_class->verificarServico($idpedido)) {
	// inserir itenm para o pedido
	$ret = $_class->insertServico($idpedido,$descricao,$valor);
	$msg = $ret == true ? 1 : 0;
}
else {
	// altera serviço para o pedido
	$ret = $_class->updateServico($idpedido,$descricao,$valor);
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
?>