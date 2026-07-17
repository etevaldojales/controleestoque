<?
$lib = 'lib/';
require_once($lib . 'classes/config.php');
require_once($lib . 'classes/class.empresa.php');
require_once($lib . 'classes/class.logs.php');
require_once($lib . 'classes/class.utilidades.php');

$_class = new empresa($dbase);
$_logs = new logs($dbase);
$_util = new utilidades();
$cod = $_POST['id'];
$dados = $_class->get($cod);


try {


	if (is_array($dados)) {
		// --------------------------------------------------------------------EXCLUI DADOS ----------------------------------------------------
		$dados = $_class->get($cod);
		$mensagem = $_SESSION["nome_usuario"] . " -  EXCLUIU A empresa: " . $dados['nome'];
		$res = $_logs->salvaLog($mensagem);
		$exclui = $_class->delete($dados['id']);
		$msg = $exclui == true ? 1 : 0;
		// -------------------------------------------------------------------- FIM EXCLUI DADOS--------------------------------------------------
	}

} catch (Exception $e) {
	echo "Exceção pega: ", $e->getMessage(), "\n";
	$msg = 0;
}


header('Content-Type: application/json; charset=utf-8');
echo json_encode($msg);
