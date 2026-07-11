<?php
session_start();
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.pedido.php');
require_once($lib.'classes/class.logs.php');

$_class    	= new pedido($dbase);
$_produto  	= new produto($dbase);
$_logs    	= new logs($dbase);
;

$cdcli 		= $_POST["idcliente"];
$id	        = $_POST["id"];
$produto	= $_produto->get($id);

echo json_encode($produto);
