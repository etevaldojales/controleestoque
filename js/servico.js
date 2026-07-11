// JavaScript Document
var pagina;
var id;
var valorc;
var qtd;
var valor;

function listar(pag) {
	pagina = pag;
	include('lista_produtos_venda.php','pagina='+pag,'lista');	
}

function paginar(pag) {
	pagina = pag;
	include('lista_produtos_venda.php','pagina='+pag,'lista');	
}

function pesquisar() {
	var val 	= document.getElementById('parametro').value;
	var filtro 	= document.getElementById('filtro').value;
	include('lista_produtos_venda.php','parametro='+val+'&filtro='+filtro,'lista');	
}

function pesquisarPNome(val) {
	var filtro 	= 1;
	include('lista_produtos_venda.php','parametro='+val+'&filtro='+filtro,'lista');	
}

function carregarItens() {
	var cli = document.getElementById('cliente').value;
	include('itens_servico.php','idcliente='+cli,'itens');
}


function excluirItem(id) {
	customConfirm('Deseja realmente excluir esse item?', function() {
		executar('bd.excluiItem.php','id='+id,excluirItemRe);	
	});
}

function excluirItemRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			obj = resposta.getElementsByTagName('retorno');
			if (obj[0].firstChild) 
			{
				if (obj[0].firstChild.nodeValue == 1) 
				{
					carregarItens();
				}
				else 
				{
					alert('Houve um erro ao excluir item');	
				}
			}
		}
	}
}

function adicionarItem(idproduto) {
	var cli = document.getElementById('cliente').value;
	if(!cli) {
		alert('Seelecione o Cliente');
		return false;
	}
	else {
		executar('adicionar_item.php','idcliente='+cli+'&idproduto='+idproduto,adicionarItemRe);	
	}
}

function adicionarItemRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			obj = resposta.getElementsByTagName('retorno');

			// verifica o campo mensagem do XML, se for 1 Ã© que inseriu OK, caso contrÃ¡rio, Ã© erro.
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
			{
				alert('Item incluido com sucesso!');
				carregarItens();
			}
			else if(obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 2) {
				alert('Item jÃ¡ cadastrado nesse pedido');
			}
			else {
				alert('Falha ao cadastrar item');	
			}
		}
	}
}

function addServico(idpedido,valor,descricao) {
	if(!descricao) {
		alert('Por favor insira a Descricao do Servico');
		return document.getElementById('descricao').focus();
	}
	else if(!valor) {
		alert('Por favor insira o Valor do Servico');
		return document.getElementById('valor_servico').focus();
	}
	executar('adicionar_servico.php','idpedido='+idpedido+'&descricao='+descricao+'&valor='+valor,addServicoRe);	
}

function addServicoRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			obj = resposta.getElementsByTagName('retorno');

			// verifica o campo mensagem do XML, se for 1 Ã© que inseriu OK, caso contrÃ¡rio, Ã© erro.
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
			{
				carregarItens();
			}
			else {
				alert('Falha ao cadastrar servico');	
			}
		}
	}
}


function capturarQtd(event, iditem, qtd) {  
	var keynum;  
	if(window.event) { //IE  
		keynum = event.keyCode  
	} else if(event.which) { // Netscape/Firefox/Opera AQUI ESTAVA O PEQUENINO ERRO ao invÃ©s de "e." Ã© "event."  
		keynum = event.which  
	}  
	if( keynum==13 ) { <!-- 13 Ã© o cÃ³digo do Enter --> AQUI TAMBEM  
		alterarQuantidadeItem(iditem, qtd);  
	}  
} 

function alterarQuantidadeItem(iditem, qtd) {
	executar('alterarQuantidade.php','iditem='+iditem+'&quantidade='+qtd,alterarQuantidadeItemRe);	
}

function alterarQuantidadeItemRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			obj = resposta.getElementsByTagName('retorno');

			// verifica o campo mensagem do XML, se for 1 Ã© que inseriu OK, caso contrÃ¡rio, Ã© erro.
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
			{
				carregarItens();
			}
			else {
				alert('Falha ao alterar quantidade');	
			}
		}
	}
}

function capturarIpi(event, iditem, ipi) {  
	var keynum;  
	if(window.event) { //IE  
		keynum = event.keyCode  
	} else if(event.which) { // Netscape/Firefox/Opera AQUI ESTAVA O PEQUENINO ERRO ao invÃ©s de "e." Ã© "event."  
		keynum = event.which  
	}  
	if( keynum==13 ) { <!-- 13 Ã© o cÃ³digo do Enter --> AQUI TAMBEM  
		alterarIpiItem(iditem, ipi);  
	}  
} 

function alterarIpiItem(iditem, ipi) {
	executar('alterarIpiItem.php','iditem='+iditem+'&ipi='+ipi,alterarIpiItemRe);	
}

function alterarIpiItemRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			obj = resposta.getElementsByTagName('retorno');

			// verifica o campo mensagem do XML, se for 1 Ã© que inseriu OK, caso contrÃ¡rio, Ã© erro.
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
			{
				carregarItens();
			}
			else {
				alert('Falha ao alterar ipi');	
			}
		}
	}
}

function concluirPedido(id,valor,valorc,valorv) {
	var obs = document.getElementById('obs').value;
	var data = document.getElementById('data').value;
	executar('concluirPedido.php','id='+id+'&observacao='+obs+'&valor='+valor+'&valorcusto='+valorc+'&valorvenda='+valorv+'&data='+data,concluirPedidoRe);
}

function concluirPedidoRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			obj = resposta.getElementsByTagName('retorno');

			// verifica o campo mensagem do XML, se for 1 Ã© que inseriu OK, caso contrÃ¡rio, Ã© erro.
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
			{
				alert('Pedido concluÃ­do com sucesso!');
				//location.href = 'vendas.php';
				location.href = 'formapagamento.php';
			}
			else {
				alert('Falha ao concluir opedido');	
			}
		}
	}
}

function validar() {
	var formpg 	= document.getElementById('formpag').value;
	var numparc = document.getElementById('numparc').value;
	var pvenc 	= document.getElementById('primvenc').value;
	if(!formpg) {
		alert('Por favor selecione a forma de pagamento do pedido');
		return document.getElementById('formpag').focus();
	}
	else if(!numparc) {
		alert('Por favor selecione o numero de parcelas do pedido');
		return document.getElementById('numparc').focus();
	}
	else if(pvenc == '') {
		alert('Por favor seelecione a data do primeiro vencimento do pedido');	
		return document.getElementById('primvenc').focus();
	}
	document.getElementById('btnCad').style.display = 'none';
	document.getElementById('btnEtrada').style.display = 'none';
	xhSend('concluir_pedido.php','frmFormPag', validarRe);
}

function validarRe()
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
				exibirBaixasCadastro(obj[0].getElementsByTagName("codpedido")[0].firstChild.nodeValue);
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

function exibirFormEntrada(cdpedido) {
	include('form_entrada.php','codigo='+cdpedido,'myModal1');
}

function validarEntrada() {
	var formpg 	= document.getElementById('formpgentrada');	
	var datapg 	= document.getElementById('dtentrada');	
	var valpg 	= document.getElementById('valor_entrada');	
	var valrec 	= document.getElementById('recibo_entrada');	
	var codigo  = document.getElementById('codpedido').value;
	if(!formpg.value) {
		alert('Por favor selecione a Forma de Pagamento da Entrada');
		return formpg.focus();
	}
	if(!datapg.value) {
		alert('Por favor informe a data do pagamento da Entrada');
		return datapg.focus();
	}
	if(!valpg.value) {
		alert('Por favor informe o valor da Entrada');
		return valpg.focus();
	}
	executar('insereEntrada.php','formpgentrada='+formpg.value+'&dtentrada='+datapg.value+'&valor_entrada='+valpg.value+'&recibo='+valrec.value+'&codigo='+codigo,validarEntradaRe);
}

function validarEntradaRe()
{
	if (xhReq.readyState == 4)
	{
		resposta = xhReq.responseXML;
		if (resposta)
		{
			obj = resposta.getElementsByTagName('dados');
			if (obj.length >= '1')
			{
				var Xentrada	= obj[0].getElementsByTagName('entrada')[0].firstChild;
				var Xtotal		= obj[0].getElementsByTagName('total')[0].firstChild;
				var Xstotal		= obj[0].getElementsByTagName('subtotal')[0].firstChild;
				alert('Entrada cadastrada com sucesso!');
				document.getElementById('btnCloseModal').click();
				//setTotal(Xtotal.nodeValue,Xstotal.nodeValue,Xcredito.nodeValue,Xentrada.nodeValue);
			}
			else { alert('Falha'); }
		}
		else { alert('Falha'); }
	}
}

function exibirBaixasCadastro(id) {

	document.getElementById('parcelas').style.display = '';
	include('baixa_cadastro.php','id='+id,'parcelas');
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
	include('baixa.php','id='+id,'parcelas');
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

function excluirParcela(id) {
	customConfirm('deseja realmente excluir essa Parcela?', function() {
		executar('exclui_parcela.php','id='+id,excluirParcelaRe);	
	});
}

function excluirParcelaRe()
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
				alert('Parcela excluida com sucesso!');
				//location.href = modulocont+'contratos.php';
				exibirBaixas(obj[0].getElementsByTagName("pedido")[0].firstChild.nodeValue);
			}
			else { 
				alert('Falha ao excluir dados'); 
			}
		}
		else { 
			alert('Falha ao excluir dados'); 
		}
	}

}

function estornarParcela(id) {
	include('estornoparcela.php','id='+id,'myModal1');		
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

function finalizarPedido() {
	alert('Pedido concluÃ­do com sucesso!')
	location.href = 'vendas.php';
}

function alterarValorVenda(idItem,valorcItem,qtdItem,valorItem) {
	executar('alterarValorVenda.php','id='+idItem+'&valor='+valorItem+'&valor_compra='+valorcItem+'&quantidade='+qtdItem,alterarValorVendaRe);	
}

function alterarValorVendaRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			obj = resposta.getElementsByTagName('retorno');
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
			{
				alert('Valor alterado com sucesso!');
				if(document.getElementById('btnCloseModal')) {
					document.getElementById('btnCloseModal').click();
				}
				carregarItens();
			}
			else if(obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 2) {
				alert('O valor de venda nÃ£o pode ser menor ou igual ao valor de compra');
				if(document.getElementById('btnCloseModal')) {
					document.getElementById('btnCloseModal').click();
				}
				carregarItens();
			}
			else {
				alert('Falha ao alterar valor');	
			}
		}
	}
}

function showCalculadora(idItem,valorcItem,qtdItem,valorItem) {
	this.id = idItem;
	this.valorc = valorcItem;
	this.qtd = qtdItem;
	this.valor = valorItem
	include('calculadora_itens.php','valor='+valorItem,'myModal1');	
}

function calcular() {
	var perc 	= document.getElementById('percentual');
	var valorc 	= this.valor;
	var opcao	= document.getElementById('opc1').checked == true ? 1 : 2; // 1 - Acrescimo; 2 - Desconto  
	if(!perc.value) {
		alert('Preencha o campo Percentual');
		return document.getElementById('percentual').focus();
	}
	executar('calcular.php','valor='+valorc+'&percentual='+perc.value+'&opcao='+opcao,calcularRe);
}

function calcularRe()
{
	if (xhReq.readyState == 4)
	{
		resposta = xhReq.responseXML;
		if (resposta)
		{
			obj = resposta.getElementsByTagName('dados');
			if (obj.length >= 1)
			{
				/* VariÃ¡veis do FormulÃ¡rio */
				var nvalor;
				var Xvalor	= obj[0].getElementsByTagName('valor')[0].firstChild;
				nvalor 		= (Xvalor != null?unescape(Xvalor.nodeValue):'');
				alterarValorVenda(id,valorc,qtd,nvalor);
			}
			else { alert('Falha ao calcular'); }
		}
		else { 
		alert('Falha de xml'); 
		}
	}
}

