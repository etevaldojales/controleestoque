<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.categoria.php');
$_util 	= new utilidades;
$_class = new categoria($dbase);
$dados  = $_class->getAll();
echo json_encode($dados);