<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.cliente.php');
require_once($lib.'classes/class.utilidades.php');

$_util 	= new utilidades;
$_class = new cliente($dbase);
$id  	= $_POST['id'];

$dados 		= $_class->get($id);
echo json_encode($dados);