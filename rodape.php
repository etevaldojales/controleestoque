<?php
$nome_loja = "";
$ano = date("Y");
if (file_exists("config_inicio.php")) {
	require_once("config_inicio.php");
	require_once($lib . 'classes/class.empresa.php');
	$_class = new empresa($dbase);
	$emp = $_class->get(1);

	if (!empty($emp['nome'])) {
		$nome_loja = htmlspecialchars($emp['nome']);
	}

	if (isset($emp['ano_fundacao'])) {
		$ano = date("Y") . " - " . $emp['ano_fundacao'];
	}
}

if (empty($nome_loja)) {
	$nome_loja = "LOJA - DEMO";
}
?>

<div id="footer">
	<?php echo $nome_loja; ?><br>© Copyright
	<?php echo $ano; ?> Jales Tecnologia
</div>