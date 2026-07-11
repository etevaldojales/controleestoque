<?php
error_reporting(E_ALL ^ E_NOTICE);
$lib = "../lib/";
require_once($lib."classes/verifica_session.php");
require_once($lib."classes/config.php");
require_once($lib."classes/class.secoes.php");
require_once($lib."classes/class.usuario.php");
require_once($lib."classes/class.parcela.php");
require_once($lib."classes/class.pedido.php");
require_once($lib."classes/class.cliente.php");
require_once($lib."classes/class.uf.php");
require_once($lib."classes/class.utilidades.php");
require_once($lib."classes/class.bancos.php");

if(!$_SESSION["usuario"]) {
	header("Location: index.html");
}
$_bancos 	= new bancos;
$_parcela 	= new parcela();
$_pedido 	= new pedido();
$_cliente 	= new cliente();
$_util	 	= new utilidades();

$banco 		= $_bancos->get(1);
$cod 		= $_SESSION["codigo_boleto"]; // codigo da parcela
$numparc	= intval($_GET["numparc"]);
$numparc	= $numparc < 10 ? "0".$numparc : $numparc;

$parcela 	= $_parcela->get($cod);
$pedido 	= $_pedido->get($parcela['id_pedido']);
$cliente 	= $_cliente->get($pedido['id_cliente']);
$cidade		= "Fortaleza";
$uf 		= "Ce";
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa                |
// |                                                                      |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>         |
// | Desenvolvimento Boleto Santander-Banespa : Fabio R. Lenharo                |
// +----------------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE

$dias_de_prazo_para_pagamento = 2; // dois dias apos a data de vencimento
$taxa_boleto = 2.50;
//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 

$dtatual = date("Y/m/d");
$dias_atraso = diffData($parcela['vencimento'],$dtatual);
if($dias_atraso > 0) {
	$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
	$valor_atualizado = calcularJuros($parcela['valor_parcela'],$dias_atraso);	
	$valor_cobrado = number_format($valor_atualizado,2,",",""); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
	$valor_cobrado = str_replace(",", ".",$valor_cobrado);
	$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
}
else {
	$data_venc = $_util->dataMySql2Php($parcela['vencimento']);  // Prazo de X dias OU informe data: "13/04/2006"; 
	$valor_cobrado = number_format($parcela['valor_parcela'],2,",",""); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
	$valor_cobrado = str_replace(",", ".",$valor_cobrado);
	$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
}
$vrnossonumero = $parcela['nosso_numero'];
$dadosboleto["nosso_numero"] = $vrnossonumero;  // Nosso numero sem o DV - REGRA: Máximo de 7 caracteres!
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = utf8_decode($cliente['nome'])." ".utf8_decode($cliente['snome']);
$dadosboleto["endereco1"] = utf8_decode($cliente['endereco']);
$dadosboleto["endereco2"] = utf8_decode($cidade)." - ".utf8_decode($uf);
// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "LOJA - DEMO";
$dadosboleto["demonstrativo2"] = "Contrato<br> - R$ ".number_format($taxa_boleto, 2, ',', '');
//$dadosboleto["demonstrativo3"] = "";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Receber até 30 dias após o vencimento";
$dadosboleto["instrucoes3"] = "- Juros de 10% ao mês";
$dadosboleto["instrucoes4"] = "- www.sualoja.com.br";
$dadosboleto["instrucoes4"] .= "<br><br> - Parcela Nº: ".$numparc;

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";

// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS PERSONALIZADOS - SANTANDER BANESPA
$dadosboleto["codigo_cliente"] = "6117546"; // Código do Cliente (PSK) (Somente 7 digitos)
$dadosboleto["ponto_venda"] = "4279-0"; // Ponto de Venda = Agencia
$dadosboleto["carteira"] = "102";  // Cobrança Simples - SEM Registro
$dadosboleto["carteira_descricao"] = "COBRANÇA SIMPLES - CSR";  // Descrição da Carteira

// SEUS DADOS
$dadosboleto["identificacao"] = "LOJA - DEMO";
$dadosboleto["cpf_cnpj"] = "99999999999999";
$dadosboleto["endereco"] = "Rua Humberto Lomeu, 3159 - Granja Portugal";
$dadosboleto["cidade_uf"] = "Fortaleza - CE ";
$dadosboleto["cedente"] = "LOJA DEMO  - PRODUTOS E ACESSÓRIOS LTDA";

// NÃO ALTERAR!

//include("include/funcoes_bb.php"); 
//include("include/layout_bb.php");
include($banco['funcao']); 
include($banco['layout']);

function diffData($data_inicial,$data_final) { // formato Y/m/d
	// Usa a função strtotime() e pega o timestamp das duas datas:
	$time_inicial = strtotime($data_inicial);
	$time_final = strtotime($data_final);
	// Calcula a diferença de segundos entre as duas datas:
	$diferenca = $time_final - $time_inicial; // 19522800 segundos
	// Calcula a diferença de dias
	$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
	// Exibe uma mensagem de resultado:
	return $dias;
}

function calcularJuros($valor_parcela,$dias_atraso) {
	$valor_multa = number_format((($valor_parcela * 2) / 100),2);
	//$perc_juros  = number_format(((10/30) / 100),2);
	$perc_juros  = (10/30);
	$valor_juros = number_format((($valor_parcela * $perc_juros) / 100),2);
	$valor_juros = ($valor_juros * $dias_atraso);
	$retorno	 = $valor_parcela + $valor_multa + $valor_juros;
	return $retorno;
}

function formataNumero($num) {
	while(strlen($num) < 5) {
		$num = '0'.$num; 		
	}
	return $num;
}
?>