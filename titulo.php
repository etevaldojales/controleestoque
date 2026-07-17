<?php
$nome_loja = "";
if (file_exists("config_inicio.php")) {
    require_once("config_inicio.php");
    require_once($lib . 'classes/class.empresa.php');
    $_class = new empresa($dbase);
    $emp = $_class->get(1);

    if (!empty($emp['nome'])) {
        $nome_loja = htmlspecialchars($emp['nome']);
    }
}

if (empty($nome_loja)) {
    $nome_loja = "LOJA - DEMO";
}
?>

<title>
    <?php echo $nome_loja; ?>
</title>