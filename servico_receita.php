<?php
/**
 * Consulta dados de nota fiscal junto à Receita Federal via API.
 * 
 * Exemplo de uso:
 * $chaveNFe = '12345678901234567890123456789012345678901234';
 * $dados = consultarNotaFiscalReceita($chaveNFe);
 * if ($dados) {
 *     print_r($dados);
 * } else {
 *     echo "Erro ao consultar nota fiscal.";
 * }
 */

/**
 * Consulta nota fiscal na API da Receita Federal.
 *
 * @param string $chaveNFe Chave de acesso da nota fiscal eletrônica (44 dígitos).
 * @return array|null Dados da nota fiscal ou null em caso de erro.
 */
function consultarNotaFiscalReceita($chaveNFe) {
    // URL da API da Receita Federal (exemplo fictício, substituir pela real)
    $url = "https://api.receita.fazenda.gov.br/nfe/consulta?chave=" . urlencode($chaveNFe);

    // Configurações da requisição HTTP
    $options = [
        "http" => [
            "method" => "GET",
            "header" => "Accept: application/json\r\n"
        ]
    ];

    $context = stream_context_create($options);

    // Realiza a requisição
    $response = @file_get_contents($url, false, $context);

    if ($response === FALSE) {
        return null;
    }

    // Decodifica o JSON retornado
    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return null;
    }

    return $data;
}
/**
 * Consulta nota fiscal por número da nota.
 *
 * @param string $numeroNota Número da nota fiscal.
 * @return array Dados da nota fiscal ou mensagem de erro.
 */
function consultarNotaFiscalPorNumero($numeroNota) {
    // Atualmente, a consulta por número da nota não é suportada diretamente.
    // É necessário o uso da chave de acesso (chaveNFe) de 44 dígitos para consulta.
    return [
        'erro' => true,
        'mensagem' => 'Consulta por número da nota não suportada. Por favor, utilize a chaveNFe de 44 dígitos para consultar a nota fiscal.'
    ];
}


