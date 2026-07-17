<?
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.cliente.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new cliente($dbase);
$_logs    	= new logs($dbase);
;
$cod		= $_POST['id']; 
$dados 		= $_class->get($cod);

// Verifica se o cliente está relacionado a venda
if($_class->verificaRelacionamento($cod)) {
	try {
		if(is_array($dados)) {
			// --------------------------------------------------------------------EXCLUI DADOS ----------------------------------------------------
			$dados = $_class->get($cod);
			$mensagem 	 = $_SESSION["nome_usuario"]." -  EXCLUIU A CLIENTE ".$dados['nome'];		
			$_logs->salvaLog($mensagem); 
			$exclui = $_class->delete($dados['id']);
			
			$msg = $exclui == true ? 1 : 0;
			
			// -------------------------------------------------------------------- FIM EXCLUI DADOS--------------------------------------------------
		}
	}
	catch(Exception $e) {
		echo "Exceção pega: ",  $e->getMessage(), "\n";		
		$msg = 0;
	}
}
else {
	$msg = 2;	
}

$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>".$msg."</retorno>\n";
$xml .= "</root>\n";

Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
//else { echo 'b'; }
?>