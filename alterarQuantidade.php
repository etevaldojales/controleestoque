<?php
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.pedido.php');

$_class    	= new pedido($dbase);
;

$cditem		= $_POST["iditem"];
$und 		= $_POST["unidade"];
$qtd		= $_POST["quantidade"];
/*
if($und == 2) {
	echo floor($qtdorig);
	echo "<br>".$qtdorig;
	die;
	if(floor($qtdorig) != $qtdorig) { // float
		$qtd = str_replace(".","", $qtdorig);
		$qtd = ($qtd / 1000);
	}
	else {
		$qtd = ($qtdorig * 1000);	
	}
}
else {
	$qtd = $qtdorig;
}
*/
$item		= $_class->getItem($cditem);


if($item['ipi'] == 0) {
	$nvalor		= ($item['valor_unitario'] * $qtd);
}
else {
	$nvalor		= (($item['valor_unitario'] * $qtd) * ($item['ipi'] / 100));
}

$nvalorc	= ($item['valor_unitario_compra'] * $qtd);
//$qtd   		= str_replace(",","", $_POST["quantidade"]);
$ret		= $_class->alterarQuantidade($cditem,$qtd,$nvalor);
$msg 		= $ret == true ? 1 : 0;
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "	<mensagem>".$msg."</mensagem>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>\n";

Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
