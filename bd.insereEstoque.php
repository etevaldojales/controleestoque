<?php
$lib = 'lib/';
require_once($lib . 'classes/config.php');
require_once($lib . 'classes/class.estoque.php');
require_once($lib . 'classes/class.produto.php');
require_once($lib . 'classes/class.logs.php');
require_once($lib . 'classes/class.utilidades.php');

$_class = new estoque($dbase);
$_produto = new produto($dbase);
$_logs = new logs($dbase);
$_util = new utilidades();

$produto = $_POST["produto"];
$data = date("Y-m-d");
$qtdent = isset($_POST["qtdentrada"]) ? $_POST["qtdentrada"] : 0;

$qtdsaida = isset($_POST["qtdsaida"]) ? $_POST["qtdsaida"] : 0;
$qtdacum = isset($_POST["qtdacumulada"]) ? $_POST["qtdacumulada"] : 0;
$estoquemin = $_POST["estoque_minimo"];
$num_nf = $_POST["num_nf"];

$dados = $_produto->get($produto);

if ($qtdent > 0) {
	$qtdacum += $qtdent;
	$msgs = "CADASTROU ENTRADA NO ESTOQUE";
	$qtd = $qtdent;
} elseif ($qtdsaida > 0) {
	$qtdacum -= $qtdsaida;
	$msgs = "CADASTROU SAÍDA NO ESTOQUE";
	$qtd = $qtdsaida;
}
$ret = $_class->insert($produto, $qtdent, $qtdsaida, $qtdacum, $data, $estoquemin, $num_nf);
$mensagem = $_SESSION["nome_usuario"] . " -  " . $msgs . " O PRODUTO: " . $dados['codigo'] . ", QUANTIDADE: " . $qtd;
$res = $_logs->salvaLog($mensagem);
$msg = $ret == true ? 1 : 0;
echo json_encode($msg);
