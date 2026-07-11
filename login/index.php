<?php
$lib = '../lib/';
require_once($lib . "classes/config.php");

// Rate limiting: max 5 attempts per 15 min
$login_attempts = $_SESSION['login_attempts'] ?? 0;
$lockout_time = $_SESSION['lockout_time'] ?? 0;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit;
}

require_once($lib . "classes/class.utilidades.php");

$util = new utilidades();

if (!$util->validate_csrf_token()) {
    echo json_encode(['success' => false, 'error' => 'Invalid CSRF token.']);
    exit;
}

if ($login_attempts >= 5 && time() - $lockout_time < 900) {
    echo json_encode(['success' => false, 'error' => 'Too many failed attempts. Try again in 15 minutes.']);
    exit;
}

$login = trim(htmlspecialchars($_POST["login_usu"] ?? '', ENT_QUOTES, 'UTF-8'));
$senha = md5(trim($_POST["senha"] ?? ''));  // Hash to match DB MD5

if (empty($login) || empty($senha)) {
    echo json_encode(['success' => false, 'error' => 'Login and password required.']);
    exit;
}

require_once($lib . "classes/class.usuario.php");

$_usuario = new usuario($dbase);
$validado = $_usuario->verificaLogin($login, $senha);

if (is_array($validado) && $validado['ativo'] == 1) {
    // Reset attempts
    $_SESSION['login_attempts'] = 0;
    // Set session
    $_SESSION["usuario"] = $validado['id_usuario'];
    $_SESSION["nome_usuario"] = $validado['nome'];
    $_SESSION["foto_usuario"] = $validado['foto'] ?? '';
    $_SESSION["tipo_usuario"] = $validado['tipo_usuario'];
    echo json_encode(['success' => true, 'redirect' => 'index.php']);
    exit;
} else {
    $login_attempts++;
    $_SESSION['login_attempts'] = $login_attempts;
    $_SESSION['lockout_time'] = time();
    echo json_encode(['success' => false, 'error' => 'Invalid login or password.']);
    exit;
}
?>

