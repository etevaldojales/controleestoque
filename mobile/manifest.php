<?php
header("Content-Type: application/json; charset=utf-8");
$lib = '../lib/';
require_once($lib . 'classes/config.php');
require_once($lib . 'classes/class.empresa.php');

$_class = new empresa($dbase);
$emp = $_class->get(1);
$nome_loja = (!empty($emp['nome'])) ? $emp['nome'] : "Controle de Estoque & PDV";

// Generate a clean short name for the PWA
$nome_loja_short = preg_replace('/[^a-zA-Z0-9]/', '', $nome_loja);
if (empty($nome_loja_short)) {
    $nome_loja_short = "PDVMobile";
}

$manifest = [
    "name" => $nome_loja . " Mobile",
    "short_name" => $nome_loja_short,
    "description" => "Sistema de Vendas e PDV Mobile - " . $nome_loja,
    "start_url" => "index.php",
    "display" => "standalone",
    "background_color" => "#1a0f0a",
    "theme_color" => "#6f3e1b",
    "orientation" => "portrait-primary",
    "icons" => [
        [
            "src" => "../img/logo.png",
            "sizes" => "192x192",
            "type" => "image/png",
            "purpose" => "any maskable"
        ]
    ]
];

echo json_encode($manifest, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
