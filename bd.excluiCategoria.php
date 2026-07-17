<?
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.utilidades.php');
$util = new utilidades();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$util->validate_csrf_token()) {
    header('Content-Type: application/xml; charset=iso-8859-1');
    $xml = "<root><retorno><erro>CSRF token invalid</erro></retorno></root>";
    echo $xml;
    exit;
}
require_once($lib.'classes/class.categoria.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new categoria($dbase);
$_logs    	= new logs($dbase);
;
$cod		= $_POST['id']; 
$dados 		= $_class->get($cod);


try {
	
	if($_class->verifica($cod) == false) {
		$msg = 2;	
	}
	else {
		if(is_array($dados)) {
			// --------------------------------------------------------------------EXCLUI DADOS ----------------------------------------------------
			$dados = $_class->get($cod);
			$mensagem 	 = $_SESSION["nome_usuario"]." -  EXCLUIU A CATEGORIA: ".$dados['descricao'];		
			$res = $_logs->salvaLog($mensagem); 
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