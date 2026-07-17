<?php
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
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.pedido.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new pedido($dbase);
$_produto  	= new produto($dbase);
$_logs    	= new logs($dbase);
;

$cdcli 		= $_POST["idcliente"];
$cdprod   	= $_POST["idproduto"];
$produto	= $_produto->get($cdprod);
$usu 		= $_SESSION["usuario"];

// verificar pedido do cliente em aberto
$pedido 	= $_class->getPedido($cdcli);
if(is_array($pedido)) {
	//carregar o id do pedido
	$idpedido = $pedido['id'];
}
else {
	//cadastrar pedido para o cliente
	$numpedido 	= $_class->getUltimoNumeroPedido();
	$data 		= date("Y/m/d");
	$idpedido 	= $_class->insert($cdcli,$numpedido,$data,0,0,0,1,'', $usu);
}

// veerificar se o item ja foi cadastrado para o pedido
if($_class->verificarItem($cdprod, $idpedido)) {
	// inserir itenm para o pedido
	$qtd = 1;
	$ret = $_class->insertItem($cdprod,$idpedido,$qtd,$produto['valor_compra'],$produto['valor'],$produto['valor']);
	$msg = $ret == true ? 1 : 0;
}
else {
	$msg = 2;
}
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "	<mensagem>".$msg."</mensagem>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>\n";

Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
