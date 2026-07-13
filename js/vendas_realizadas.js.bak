// JavaScript Document
var pagina;
var cdpedido;

function listar(pag) {
	pagina = pag;
	include('lista_clientes_venda.php','pagina='+pag,'lista');	
}

function paginar(pag) {
	pagina = pag;
	include('lista_clientes_venda.php','pagina='+pag,'lista');	
}

function pesquisar() {
	var val 	= document.getElementById('parametro').value;
	var data 	= document.getElementById('data').value;
	var dataf 	= document.getElementById('dataf').value;
	if (!validarDatas(data, dataf)) return;
	include('lista_clientes_venda.php','parametro='+val+'&data='+data+'&dataf='+dataf,'lista');	
}

function pesquisarPorNome() {
	var val 	= document.getElementById('parametro').value;
	document.getElementById('data').value = '';
	document.getElementById('dataf').value = '';
	include('lista_clientes_venda.php','parametro='+val,'lista');	
}

function pesquisarAll() {
	include('lista_clientes_venda.php','','lista');	
}

function listarDetalhes(id) {
	include('lista_detalhe.php','id='+id,'lista_detalhe');	
}

function pesquisarDetalhe() {
	var val 	= document.getElementById('filtro').value;
	var id 		= document.getElementById('idpedido').value;
	include('lista_detalhe.php','filtro='+val+'&id='+id,'lista_detalhe');	
}

function exibirParcelas(id) {
	include('baixamodal.php','id='+id,'myModal1');
}

function imprimirBoleto(id,numparc) {
	numeroparcela = numparc;
	executar('config_boleto.php','id='+id,imprimirBoletoRe);
}

function imprimirBoletoRe()
{
	if (xhReq.readyState == 4)
	{
		retorno = xhReq.responseXML;
		// se o retorno for um XML, entÃ£o comeÃ§a a agir.
		if (retorno != null)
		{
			obj = retorno.getElementsByTagName('retorno');
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == '1')
			{
				window.open("boleto/boleto.php?numparc="+numeroparcela,"boleto","toolbar=no, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=710, height=800");				
			}
		}
	}
}

function baixarParcela(id,valrec,recibo,forma,numparc) {
	nparc = numparc;
	cdparcela = id;
	if(!forma) {
		alert('Por favor selecione a forma de pagamento da parcela');
		return false;
	}
	if(!valrec) {
		alert('Por favor insira o valor recebido da parcela');
		return false;
	}
	executar('bd.baixa.php','id='+id+'&valor='+valrec+'&recibo='+recibo+'&formapag='+forma,baixarParcelaRe);	
}

function baixarParcelaRe()
{
	if (xhReq.readyState == 4)
	{
		retorno = xhReq.responseXML;
		// se o retorno for um XML, entÃ£o comeÃ§a a agir.
		if (retorno != null)
		{
			obj = retorno.getElementsByTagName('retorno');
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == '1')
			{
				alert('Operacao realizada com sucesso!');
				//location.href = modulocont+'contratos.php';
				exibirBaixas(obj[0].getElementsByTagName("pedido")[0].firstChild.nodeValue);
				//setTimeout('imprimirRecibo()',500);
			}
			else { 
				alert('Falha ao inserir dados'); 
			}
		}
		else { 
			alert('Falha ao inserir dados'); 
		}
	}
}

function exibirBaixas(id) {
	include('baixamodal.php','id='+id,'myModal1');
}

function imprimirRecibo() {
	customConfirm('Deseja imprimir o Recibo?', function() {
		var url = 'recibopdf.php?codigo='+cdparcela+'&numero_parcela='+nparc;
		window.open(url,'_blank');		
	});
}

function baixarEntrada(id,valrec,recibo,forma) {
	if(!forma) {
		alert('Por favor selecione a forma de pagamento da entrada');
		return false;
	}
	if(!valrec) {
		alert('Por favor insira o valor recebido da entrada');
		return false;
	}
	executar('bd.baixa_entrada.php','id='+id+'&valor='+valrec+'&recibo='+recibo+'&formapag='+forma,baixarEntradaRe);	
}

function baixarEntradaRe()
{
	if (xhReq.readyState == 4)
	{
		retorno = xhReq.responseXML;
		// se o retorno for um XML, entÃ£o comeÃ§a a agir.
		if (retorno != null)
		{
			obj = retorno.getElementsByTagName('retorno');
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == '1')
			{
				alert('Operacao realizada com sucesso!');
				//location.href = modulocont+'contratos.php';
				exibirBaixas(obj[0].getElementsByTagName("pedido")[0].firstChild.nodeValue);
			}
			else { 
				alert('Falha ao inserir dados'); 
			}
		}
		else { 
			alert('Falha ao inserir dados'); 
		}
	}
}

function estornarParcela(id) {
	include('estornoparcela.php','id='+id,'myModal12');		
}

function validarEstorno(id) {
	var data = document.getElementById('dtvenc');
	if(!data.value) {
		alert('Por favor preencha o campo Data de Vencimento');
		return data.focus();	
	}
	executar('processaestornoparcela.php','id='+id+'&data='+data.value,validarEstornoRe);
}

function validarEstornoRe()
{
	if (xhReq.readyState == 4)
	{
		resposta = xhReq.responseXML;
		if (resposta)
		{
			obj = resposta.getElementsByTagName('dados');
			if (obj.length >= '1')
			{
				var Xmensagem	= obj[0].getElementsByTagName('mensagem')[0].firstChild;
				var Xid		= obj[0].getElementsByTagName('id')[0].firstChild;
				if(Xmensagem.nodeValue == 1) {
					alert('Estorno da parcela realizado com sucesso!');
					document.getElementById('btnCloseModal').click();
					exibirBaixas(Xid.nodeValue);
				}
				else {
					alert('Falha ao realizar Estorno!');
				}
			}
			else { alert('Falha'); }
		}
		else { alert('Falha'); }
	}
}

function inserirCredito(id,valor,idpedido) {
	cdpedido = idpedido;
	if(!valor) {
		alert('Insira o valor do Credito');
		return document.get('val_credito').focus();
	}
	executar('bd.insere_credito.php','id='+id+'&valor='+valor,inserirCreditoRe);
}

function inserirCreditoRe()
{
	if (xhReq.readyState == 4)
	{
		resposta = xhReq.responseXML;
		if (resposta)
		{
			obj = resposta.getElementsByTagName('dados');
			if (obj.length >= '1')
			{
				var Xmensagem	= obj[0].getElementsByTagName('mensagem')[0].firstChild;
				if(Xmensagem.nodeValue == 1) {
					alert('Credito realizado com sucesso!');
					exibirBaixas(cdpedido);
				}
				else {
					alert('Falha ao realizar Credito!');
				}
			}
			else { alert('Falha'); }
		}
		else { alert('Falha'); }
	}
}

function baixarCredito(id,valor,idpedido,valorsaldo) {
	cdpedido = idpedido;
	var valor = parseInt(valor);
	var valorsaldo = parseInt(valorsaldo);
	if(!valor) {
		alert('Insira o valor do Saldo');
		return document.get('val_saldo').focus();
	}
	else if(valor > valorsaldo) {
		alert('O valor do saldo a ser debitado deve ser igual ou menor que o saldo atual.');
		exibirBaixas(cdpedido);
	}
	else {
		executar('bd.insere_debito.php','id='+id+'&valor='+valor+'&saldo='+valorsaldo,baixarCreditoRe);
	}
}

function baixarCreditoRe()
{
	if (xhReq.readyState == 4)
	{
		resposta = xhReq.responseXML;
		if (resposta)
		{
			obj = resposta.getElementsByTagName('dados');
			if (obj.length >= '1')
			{
				var Xmensagem	= obj[0].getElementsByTagName('mensagem')[0].firstChild;
				if(Xmensagem.nodeValue == 1) {
					alert('Debito realizado com sucesso!');
					exibirBaixas(cdpedido);
				}
				else {
					alert('Falha ao realizar Debito!');
				}
			}
			else { alert('Falha'); }
		}
		else { alert('Falha'); }
	}
}
