<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.produto.php');
$_class = new produto($dbase);
$codigo = $_POST['codigo'];
$existe = $_class->codigoExiste($codigo);  
echo json_encode(['exists' => $existe]); 
