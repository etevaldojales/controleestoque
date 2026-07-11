<?php
include("config_inicio.php");
$_secoes 	= new secoes($dbase);
$codusu		= $_POST["usuario"];
$sec 		= $_POST['chksecao'];

$retus 		= $_secoes->deleteUsuSecao($codusu);
$retusb		= $_secoes->deleteUsuSubSecao($codusu);
$cont = count($sec);
for($i=0;$i<$cont;$i++) {
	if($sec[$i] != "") {
		$dados 	= explode("_",$sec[$i]);
		$res 	= $_secoes->insertUsuSecao($codusu,$dados[0]); 
		$resb 	= $_secoes->insertUsuSubSecao($codusu,$dados[0],$dados[1]); 
		$msg = 1;
	}
}
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "		<mensagem>".$msg."</mensagem>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>";
Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;

