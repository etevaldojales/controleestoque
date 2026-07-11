<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.pedido.php');
require_once($lib.'classes/class.cliente.php');
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.empresa.php');
require_once('ns-suite-php/src/NSSuite.php');

header('Content-Type: application/json');
session_start();

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Order ID not provided']);
    exit;
}

$orderId = intval($_POST['id']);

// 1. Fetch order data
$_pedido = new pedido($dbase);
$pedido_data = $_pedido->get($orderId);
$itens_pedido = $_pedido->getItens($orderId);

// 2. Fetch customer data
$_cliente = new cliente($dbase);
$cliente_data = $_cliente->get($pedido_data['id_cliente']);

// 3. Fetch company data (emitter)
$_empresa = new empresa($dbase);
$empresa_data = $_empresa->get(1); // Assuming company ID is 1

// 4. Construct NFe data
$nfe_data = [
    'NFe' => [
        'infNFe' => [
            'versao' => '4.00',
            'ide' => [
                'cUF' => $empresa_data['cUF'], // Company's state code
                'cNF' => rand(10000000, 99999999),
                'natOp' => 'VENDA',
                'mod' => 55,
                'serie' => 1,
                'nNF' => $orderId,
                'dhEmi' => date('Y-m-d\TH:i:sP'),
                'dhSaiEnt' => date('Y-m-d\TH:i:sP'),
                'tpNF' => 1,
                'idDest' => 1,
                'cMunFG' => $empresa_data['cMunFG'], // Company's municipality code
                'tpImp' => 1,
                'tpEmis' => 1,
                'cDV' => 2,
                'tpAmb' => 2, // 1 - Production, 2 - Homologation
                'finNFe' => 1,
                'indFinal' => 1,
                'indPres' => 1,
                'procEmi' => 0,
                'verProc' => '1.0',
            ],
            'emit' => [
                'CNPJ' => $empresa_data['cnpj'],
                'xNome' => $empresa_data['razao_social'],
                'xFant' => $empresa_data['nome_fantasia'],
                'enderEmit' => [
                    'xLgr' => $empresa_data['endereco'],
                    'nro' => $empresa_data['numero'],
                    'xBairro' => $empresa_data['bairro'],
                    'cMun' => $empresa_data['cMun'],
                    'xMun' => $empresa_data['cidade'],
                    'UF' => $empresa_data['uf'],
                    'CEP' => $empresa_data['cep'],
                    'cPais' => '1058',
                    'xPais' => 'BRASIL',
                ],
                'IE' => $empresa_data['ie'],
                'CRT' => '1', // Simples Nacional
            ],
            'dest' => [
                'CNPJ' => $cliente_data['cpf_cnpj'], // Assuming customer has cpf_cnpj field
                'xNome' => $cliente_data['nome'],
                'enderDest' => [
                    'xLgr' => $cliente_data['endereco'],
                    'nro' => $cliente_data['numero'],
                    'xBairro' => $cliente_data['bairro'],
                    'cMun' => $cliente_data['cMun'],
                    'xMun' => $cliente_data['cidade'],
                    'UF' => $cliente_data['uf'],
                    'CEP' => $cliente_data['cep'],
                    'cPais' => '1058',
                    'xPais' => 'BRASIL',
                ],
                'indIEDest' => 9,
                'email' => $cliente_data['email'],
            ],
            'det' => [],
            'total' => [
                'ICMSTot' => [
                    'vBC' => 0,
                    'vICMS' => 0,
                    'vICMSDeson' => 0,
                    'vFCP' => 0,
                    'vBCST' => 0,
                    'vST' => 0,
                    'vFCPST' => 0,
                    'vFCPSTRet' => 0,
                    'vProd' => 0,
                    'vFrete' => 0,
                    'vSeg' => 0,
                    'vDesc' => 0,
                    'vII' => 0,
                    'vIPI' => 0,
                    'vIPIDevol' => 0,
                    'vPIS' => 0,
                    'vCOFINS' => 0,
                    'vOutro' => 0,
                    'vNF' => 0,
                    'vTotTrib' => 0,
                ],
            ],
            'transp' => [
                'modFrete' => 9, // No freight
            ],
            'pag' => [
                'detPag' => [
                    [
                        'tPag' => '01', // Money
                        'vPag' => 0,
                    ],
                ],
            ],
            'infAdic' => [
                'infCpl' => 'Test Note',
            ],
        ],
    ],
];

$_produto = new produto($dbase);
$total_nf = 0;
foreach ($itens_pedido as $item) {
    $produto_data = $_produto->get($item['id_produto']);
    $vProd = $item['valor_unitario'] * $item['quantidade'];
    $total_nf += $vProd;

    $nfe_data['NFe']['infNFe']['det'][] = [
        'nItem' => $item['id'],
        'prod' => [
            'cProd' => $produto_data['codigo'],
            'cEAN' => '',
            'xProd' => $produto_data['nome'],
            'NCM' => '84713000', // Example NCM
            'CFOP' => '5102', // Example CFOP
            'uCom' => $produto_data['unidade'],
            'qCom' => $item['quantidade'],
            'vUnCom' => $item['valor_unitario'],
            'vProd' => $vProd,
            'cEANTrib' => '',
            'uTrib' => $produto_data['unidade'],
            'qTrib' => $item['quantidade'],
            'vUnTrib' => $item['valor_unitario'],
            'indTot' => 1,
        ],
        'imposto' => [
            'vTotTrib' => 0,
            'ICMS' => [
                'ICMSSN102' => [
                    'orig' => 0,
                    'CSOSN' => '102',
                ],
            ],
            'PIS' => [
                'PISNT' => [
                    'CST' => '07',
                ],
            ],
            'COFINS' => [
                'COFINSNT' => [
                    'CST' => '07',
                ],
            ],
        ],
    ];
}

$nfe_data['NFe']['infNFe']['total']['ICMSTot']['vProd'] = $total_nf;
$nfe_data['NFe']['infNFe']['total']['ICMSTot']['vNF'] = $total_nf;
$nfe_data['NFe']['infNFe']['pag']['detPag'][0]['vPag'] = $total_nf;

$conteudo = json_encode($nfe_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// 5. Set up NSSuite
$ns = new NSSuite();
// IMPORTANT: Replace 'SEU_TOKEN_AQUI' with your actual token in NSSuite.php or here
// $ns->token = 'TOKEN_DO_USUARIO'; 

// 6. Call emitirNFeSincrono
$tpConteudo = 'json';
$cnpjEmit = $empresa_data['cnpj'];
$tpDown = 'XP'; // XML and PDF
$tpAmb = '2'; // Homologation
$caminho = 'nfe_files'; // Directory to save NFe files
$exibeNaTela = false;

$response = $ns->emitirNFeSincrono($conteudo, $tpConteudo, $cnpjEmit, $tpDown, $tpAmb, $caminho, $exibeNaTela);
$response_decoded = json_decode($response, true);

// 7. Handle the response
if ($response_decoded['statusEnvio'] == 200 || $response_decoded['statusEnvio'] == -6) {
    if ($response_decoded['statusConsulta'] == 200) {
        if ($response_decoded['cStat'] == 100) {
            echo json_encode(['success' => true, 'message' => 'NFe issued successfully!', 'data' => $response_decoded]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error issuing NFe: ' . $response_decoded['motivo'], 'data' => $response_decoded]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error consulting NFe status: ' . $response_decoded['motivo'], 'data' => $response_decoded]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error sending NFe: ' . $response_decoded['motivo'], 'data' => $response_decoded]);
}
exit;
