<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');    
require_once($lib.'classes/class.fornecedor.php');
$_class = new fornecedor($dbase);
$dados  = $_class->getAll();
echo json_encode($dados);

