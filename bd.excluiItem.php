<?php
session_start();
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.pedido.php');

$_class    	= new pedido($dbase);
;
$cod		= $_POST['id']; 
try {
	// --------------------------------------------------------------------EXCLUI DADOS ----------------------------------------------------
	$exclui = $_class->deleteItem($cod);
	$msg = $exclui == true ? 1 : 0;
	// -------------------------------------------------------------------- FIM EXCLUI DADOS--------------------------------------------------
}
catch(Exception $e) {
 	echo "Exceção pega: ",  $e->getMessage(), "\n";		
	$msg = 0;
}

echo json_encode($msg);

