<?php
session_start();
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.pedido.php');
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.cliente.php');
require_once($lib.'classes/class.logs.php');
require_once($lib.'classes/class.estoque.php');

$_class    	= new pedido($dbase);
$_cliente  	= new cliente($dbase);
$_produto  	= new produto($dbase);
$_logs    	= new logs($dbase);
$_estoque  	= new estoque($dbase);
;

$idpedido	= $_POST["id"];
// 
if(empty($idpedido)) {
	echo json_encode(0); // Retorna 0 se o ID do pedido não for válido
	exit;
}
$obs   		= $_POST["observacao"];
$valor 		= $_POST["valor"];
$valorc 	= $_POST["valorcusto"];
$valorv 	= $_POST["valorvenda"];
$data		= date("Y-m-d");//$_POST["data"];
$formpg		= $_POST["formpag"];

$_SESSION["codpedido"] = $idpedido;

$ret		= $_class->concluirPedido($idpedido,$obs,$valor,$valorc,$valorv, $data, $formpg);

$msg 		= $ret == true ? 1 : 0;
$itens 		= $_class->getItens($idpedido);
$pedido		= $_class->get($idpedido);
$data_pedido = date_format(date_create($pedido['data_pedido']), 'd/m/Y');
if (!$pedido) {
    echo json_encode(0); // Retorna 0 se o pedido não for encontrado
    exit;
}
$cliente	= $_cliente->get($pedido['id_cliente']);
$mensagem 	 = $_SESSION["nome_usuario"]." -  CADASTROU O PEDIDO NUMERO: ".$pedido['numero_pedido']."| CLIENTE: ".$cliente['nome']."| DATA DO PEDIDO: ".$data_pedido."| VALOR DO PEDIDO: ".number_format($pedido['valor'],2,",",".")."| PRODUTOS: ";	

if(is_array($itens)) {
	foreach($itens as $i) {
		$produto = $_produto->get($i['id_produto']);			
		$mensagem .= $produto['codigo']."(".$i['quantidade']."), ";
		$qtdacum = ($_estoque->getQuantidadeAcumulado($i['id_produto']) - $i['quantidade']);
		$ret = $_estoque->insert($i['id_produto'],0,$i['quantidade'],$qtdacum, $data, 0, 0);
	}
}
$res = $_logs->salvaLog($mensagem); 
echo json_encode($msg);
