<?php
error_reporting(0);
ini_set('display_errors', '0');
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.marca.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new marca($dbase);
$_logs    	= new logs($dbase);
;
$cod		= $_POST['id']; 
$dados 		= $_class->get($cod);

try {
	if($_class->verificaRelacionamento($cod) == false) {
		$msg = 2;	
	}
	else {
		if(is_array($dados)) {
			// --------------------------------------------------------------------EXCLUI DADOS ----------------------------------------------------
			$dados = $_class->get($cod);
			$mensagem 	 = $_SESSION["nome_usuario"]." -  EXCLUIU A MARCA ".$dados['descricao'];		
			$_logs->salvaLog($mensagem); 
			$exclui = $_class->delete($dados['id']);
			
			$msg = $exclui == true ? 1 : 0;
			
			// -------------------------------------------------------------------- FIM EXCLUI DADOS--------------------------------------------------
		}
	}
}
catch(Exception $e) {
 	echo "Exceção pega: ",  $e->getMessage(), "\n";		
	$msg = 0;
}

$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>".$msg."</retorno>\n";
$xml .= "</root>\n";

Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
//else { echo 'b'; }
?>