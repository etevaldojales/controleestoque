<?php
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.pedido.php');

$_class    	= new pedido($dbase);
;

$cditem		= $_POST["iditem"];
$item		= $_class->getItem($cditem);
if($ipi == 0) {
	$nvalor		= ($item['valor_unitario'] * $item['quantidade']);
}
else {
	$nvalor		= ($item['valor_unitario'] * $item['quantidade']);
	$nvalor		+= ($nvalor * ($ipi/100));													
}
$ret		= $_class->alterarIpi($cditem,$ipi,$nvalor);
$msg 		= $ret == true ? 1 : 0;
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "	<mensagem>".$msg."</mensagem>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>\n";

Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
?>