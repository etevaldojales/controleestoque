<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.marca.php');

$_util 	= new utilidades;
$_class = new marca($dbase);
$dados  = $_class->getAll();
echo json_encode($dados);
