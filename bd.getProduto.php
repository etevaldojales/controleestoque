<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.utilidades.php');

$_util 	= new utilidades;
$_class = new produto($dbase);
$id  	= $_POST['id'];

$dados 	= $_class->get($id);
$qtd 	= $_class->getEstoque($id);
$qtde	= $_class->getEstoqueMinimo($id);
if (count($dados) > 0) {
$response = [
    'dados' => [
        'id' => $dados['id'],
        'id_fornecedor' => $dados['id_fornecedor'],
        'id_marca' => $dados['id_marca'],
        'id_categoria' => $dados['id_categoria'],
        'nome' => $dados['nome'],
        'valor_compra' => number_format($dados['valor_compra'], 2, ",", "."),
        'valor' => number_format($dados['valor'], 2, ",", "."),
        'codigo' => $dados['codigo'],
        'quantidade' => $qtd,
        'estoque' => $qtde,
        'local' => $dados['local_estoque'],
        'unidade' => $dados['unidade'],
        'imagem' => $dados['imagem'] ?? null
    ]
];
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
}
