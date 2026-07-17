<?php
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.pedido.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new pedido($dbase);
$_produto  	= new produto($dbase);
$_logs    	= new logs($dbase);

$cdcli 		= $_POST["idcliente"];
$codigo	    = $_POST["codigo"];
$produto	= $_produto->getBycodigo($codigo);

echo json_encode($produto);
