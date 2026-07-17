<?php
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.pedido.php');
require_once($lib.'classes/class.estoque.php');

$_class    	= new pedido($dbase);
;
$_estoque 	= new estoque($dbase);

$cditem		= $_POST["id"];
$valor   	= $_POST["valor"];
$valor   	= str_replace(".","",$valor);
$valor   	= str_replace(",",".",$valor);
$valorc		= $_POST["valor_compra"];
$item  		= $_class->getItem($cditem);

if($valor > $valorc) {
	$valort	= $item['quantidade'] * $valor;
	$ret		= $_class->alterarValorVenda($cditem,$valor,$valort);
	$msg 		= $ret == true ? 1 : 0;
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
?>