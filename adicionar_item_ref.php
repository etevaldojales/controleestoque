<?php
session_start();
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.pedido.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new pedido($dbase);
$_produto  	= new produto($dbase);
$_logs    	= new logs($dbase);


if (!isset($_SESSION['usuario'])) {
    echo json_encode(3); // Usuário não logado
    exit;
}

$id_usuario = $_SESSION['usuario'];

$cdcli = !empty($_POST["idcliente"]) ? intval($_POST["idcliente"]) : $_class->getClientePdv();
$codigo		= $_POST["codigo"];
$peso 		= $_POST["peso"];
$qtd 		= $_POST["qtd"];
$qtd_peso   = $qtd > 0 ? $qtd : $peso;
$valor_total = 0;

if(empty($cdcli) || empty($codigo)) {
	echo json_encode(0); // Retorna 0 se os dados não forem válidos
	exit;
}

$produto	= $_produto->getBycodigo($codigo);

if(!$produto) {
	echo json_encode(0); // Retorna 0 se o produto não for encontrado
	exit;
}

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
	$idpedido 	= $_class->insert($cdcli,$numpedido,$data,0,0,0,1,'',$id_usuario);
}

// veerificar se o item ja foi cadastrado para o pedido

if($_class->verificarItem($produto['id'], $idpedido)) {
	$valor_venda = floatval(str_replace(',', '.', str_replace('.', '', $produto['valor'])));
	$valor_total = $valor_venda * floatval($qtd_peso);
	// inserir itenm para o pedido
	$ret = $_class->insertItem($produto['id'],$idpedido,$qtd_peso,$produto['valor_compra'],$valor_venda, $valor_total);
	$msg = $ret == true ? 1 : 0;
}
else {
	$msg = 2;
}

echo json_encode($msg);
