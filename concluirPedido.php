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
$obs   		= $_POST["observacao"];
$valor 		= $_POST["valor"];
$valorc 	= $_POST["valorcusto"];
$valorv 	= $_POST["valorvenda"];
$data		= $_POST["data"];
$_SESSION["codpedido"] = $idpedido;

$ret		= $_class->concluirPedido($idpedido,$obs,$valor,$valorc,$valorv,$_util->dataPhp2MySql($data));
$msg 		= $ret == true ? 1 : 0;
$itens 		= $_class->getItens($idpedido);
$pedido		= $_class->get($idpedido);
$cliente	= $_cliente->get($pedido['id_cliente']);
$mensagem 	 = $_SESSION["nome_usuario"]." -  CADASTROU O PEDIDO NUMERO: ".$pedido['numero_pedido']."| CLIENTE: ".$cliente['nome']."| DATA DO PEDIDO: ".$_util->dataMySql2Php($pedido['data_pedido'])."| VALOR DO PEDIDO: ".number_format($pedido['valor'],2,",",".")."| PRODUTOS: ";	
if(is_array($itens)) {
	foreach($itens as $i) {
		$produto = $_produto->get($i['id_produto']);			
		$mensagem .= $produto['codigo']."(".$i['quantidade']."), ";
		$qtdacum = ($_estoque->getQuantidadeAcumulado($i['id_produto']) - $i['quantidade']);
		$ret = $_estoque->insert($i['id_produto'],0,$i['quantidade'],$qtdacum, $_util->dataPhp2MySql($data), 0, 0);
	}
}
$res = $_logs->salvaLog($mensagem); 
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "	<mensagem>".$msg."</mensagem>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>\n";

Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
