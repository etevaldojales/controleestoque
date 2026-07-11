<?php
session_start();
$lib = 'lib/';
require_once($lib.'classes/class.utilidades.php');
$util = new utilidades();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$util->validate_csrf_token()) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'CSRF token invalid']);
    exit;
}

// Sanitize inputs
$codigo = strip_tags($_POST['codigo'] ?? '');
$nome = trim(strip_tags($_POST['nome'] ?? ''));
$marca = (int) ($_POST['marca'] ?? 0);
$forn = (int) ($_POST['fornecedor'] ?? 0);
$categoria = (int) ($_POST['categoria'] ?? 0);
$valorc = str_replace(['.', ','], ['','.'], $_POST['valor_compra'] ?? '0');
$valor = str_replace(['.', ','], ['','.'], $_POST['valor'] ?? '0');
$cod = (int) ($_POST['id'] ?? 0);
$data = date('Y-m-d');
$qtd = (float) ($_POST['qtd'] ?? 0);
$estqmin = (float) ($_POST['estqmin'] ?? 0);
$vlocal = trim(strip_tags($_POST['local'] ?? ''));
$unidade = trim(strip_tags($_POST['unidade'] ?? ''));
$num_nf = (int) ($_POST['num_nf'] ?? 0);

require_once($lib.'classes/config.php');
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.estoque.php');
require_once($lib.'classes/class.logs.php');

$_class = new produto($dbase);
$_estoque = new estoque($dbase);
$_logs = new logs($dbase);


$imagem = '';
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/produtos/';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0755, true);
    }
    $fileTmpPath = $_FILES['imagem']['tmp_name'];
    $fileName = basename($_FILES['imagem']['name']);
    $fileName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $fileName); // sanitize filename
    $destPath = $uploadDir . $fileName;

    // To avoid overwriting existing files, add a timestamp prefix if file exists
    if (file_exists($destPath)) {
        $fileName = time() . '_' . $fileName;
        $destPath = $uploadDir . $fileName;
    }

    if (@move_uploaded_file($fileTmpPath, $destPath)) {
        $imagem = $fileName;
    } else {
        // Handle upload error if needed
        $imagem = '';
    }
}

$nome_usuario = $_SESSION["nome_usuario"] ?? 'Sistema';

if ($cod == 0)
{ // insere
	if($_class->verifica($nome)) {
		$cod = $_class->insert($forn,$marca,$categoria,$nome,$valorc,$valor,$codigo,$data,$vlocal,$unidade,$imagem);
		if($cod > 0) {
			$ret = $_estoque->insert($cod, $qtd, 0, $qtd, $data, $estqmin, $num_nf); 	
		}
		$mensagem 	 = $nome_usuario." -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: ".$nome.", QUANTIDADE: ".$qtd;		
		$res = $_logs->salvaLog($mensagem); 
        $msg = 1;
	}
	else {
		$msg = 2;	
	}
}
else 
{ // altera
	$dados = $_class->get($cod);
	$mensagem 	 = $nome_usuario." -  ALTEROU O PRODUTO DE: ".($dados['nome'] ?? '')." PARA ".$nome;	
	$ret = $_class->update($cod,$forn,$marca,$categoria,$nome,$valorc,$valor,$codigo,$vlocal,$unidade,$imagem);
	
	$ret = $_estoque->updateEstouqeMinimo($cod,$estqmin);
	$res = $_logs->salvaLog($mensagem); 
    $msg = 1;
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode((int)$msg);
