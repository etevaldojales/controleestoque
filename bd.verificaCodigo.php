<?php
session_start();
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.produto.php');

$_class = new produto($dbase);

$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';

$response = ['exists' => false];

if ($codigo !== '') {
    // Check if the code exists in the database
    if ($_class->codigoExiste($codigo)) {
        $response['exists'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($response);

