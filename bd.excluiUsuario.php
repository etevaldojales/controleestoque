<?
include("config_inicio.php");
require_once($lib.'classes/class.logs.php');

$_class    	= new usuario($dbase);
;
$_logs		= new logs($dbase);

$cod		= $_POST['id']; 
$dados 		= $_class->get($cod);

try {
	if(is_array($dados)) {
		// --------------------------------------------------------------------EXCLUI DADOS ----------------------------------------------------
		$mensagem 	= $_SESSION["nome_usuario"]." -  EXCLUIU O USUARIO ".$dados['nome'];		
		$exclui 	= $_class->delete($dados['id_usuario']);
		$_logs->salvaLog($mensagem); 
		$msg 		= $exclui == true ? 1 : 0;
		
		// -------------------------------------------------------------------- FIM EXCLUI DADOS--------------------------------------------------
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