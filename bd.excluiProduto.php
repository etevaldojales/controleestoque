<?php
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new produto($dbase);
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
			$mensagem 	 = $_SESSION["nome_usuario"]." -  EXCLUIU O PRODUTO ".$dados['nome'];		
			$_logs->salvaLog($mensagem); 
			$exclui = $_class->delete($dados['id']);
			$exclui2 = $_class->deleteEstoque($dados['id']);
			
			$msg = ($exclui == true && $exclui2 == true) ? 1 : 0;
			
			// -------------------------------------------------------------------- FIM EXCLUI DADOS--------------------------------------------------
		}
	}
}
catch(Exception $e) {
 	echo "Exceção pega: ",  $e->getMessage(), "\n";		
	$msg = 0;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['retorno' => $msg]);
//else { echo 'b'; }
