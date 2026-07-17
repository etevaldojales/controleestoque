<?php
$lib = 'lib/';
require_once($lib . 'classes/config.php');
require_once($lib . 'classes/class.empresa.php');
require_once($lib . 'classes/class.logs.php');
require_once($lib . 'classes/class.utilidades.php');

$_class = new empresa($dbase);
$_logs = new logs($dbase);
$_util = new utilidades();

$nome = $_POST["nome"];
$endereco = $_POST["endereco"];
$telefone = $_POST["telefone"];
$email = $_POST["email"];
$cod = isset($_POST["id"]) ? $_POST["id"] : 0;

$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

function uploadFile($fileInputName, $uploadDir) {
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] == UPLOAD_ERR_OK) {
        $tmpName = $_FILES[$fileInputName]['tmp_name'];
        $fileName = basename($_FILES[$fileInputName]['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
        if (in_array($fileExt, $allowedExts)) {
            $newFileName = uniqid($fileInputName . '_') . '.' . $fileExt;
            $destPath = $uploadDir . $newFileName;
            if (move_uploaded_file($tmpName, $destPath)) {
                return $destPath;
            }
        }
    }
    return null;
}

$logoPath = uploadFile('logo', $uploadDir);
$qrcodePath = uploadFile('qrcode', $uploadDir);

if ($cod == 0) { // insert
    if ($_class->verificaCadastro($nome)) {
        $ret = $_class->insert(
            $nome,
            $endereco,
            $email,
            $telefone,
            $logoPath,
            $qrcodePath
        );
        $mensagem = $_SESSION["nome_usuario"] . " - CADASTROU A EMPRESA: " . $nome;
        $res = $_logs->salvaLog($mensagem);
        $msg = $ret ? 1 : 0;
    } else {
        $msg = 2; // duplicate
    }
} else { // update
    $dados = $_class->get($cod);
    $ret = $_class->update(
        $cod,
        $nome,
        $endereco,
        $email,
        $telefone,
        $logoPath,
        $qrcodePath
    );
    $mensagem = $_SESSION["nome_usuario"] . " - ALTEROU A EMPRESA DE: " . $dados['nome'] . " PARA " . $nome;
    $res = $_logs->salvaLog($mensagem);
    $msg = $ret ? 1 : 0;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($msg);

