<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.empresa.php');

$_util 	= new utilidades;
$_class = new empresa($dbase);
$id  	= $_POST['id'];

$dados 		= $_class->get($id);

echo json_encode($dados);
