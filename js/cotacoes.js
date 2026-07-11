// JavaScript Document
var pagina;
function listar(pag) {
	pagina = pag;
	include('lista_cotacoes.php','pagina='+pag,'lista');	
}

function paginar(pag) {
	pagina = pag;
	include('lista_cotacoes.php','pagina='+pag,'lista');	
}

function pesquisar() {
	var val 	= document.getElementById('parametro').value;
	var tipo 	= document.getElementById('tipo').value;
	include('lista_cotacoes.php','parametro='+val+'&tipo='+tipo,'lista');	
}

function validar() {
	var fornecedor 	= document.getElementById('fornecedor');	
	var marca 		= document.getElementById('marca');	
	var codigo 	= document.getElementById('codigo');	
	var valor 		= document.getElementById('valor');	
	var ipi 		= document.getElementById('ipi');	
	var categoria	= document.getElementById('categoria');	
	
	if(!valor.value) {
		alert('Por favor insira o Valor');
		return valor.focus();
	}
	else if(!fornecedor.value) {
		alert('Por favor selecione o Fornecedor');
		return fornecedor.focus();
	}
	else if(!ipi.value) {
		alert('Por favor selecione o IPI');
		return ipi.focus();
	}
	else if(!marca.value) {
		alert('Por favor selecione a Marca');
		return marca.focus();
	}
	else if(!codigo.value) {
		alert('Por insira a codigo');
		return codigo.focus();
	}
	else if(!categoria.value) {
		alert('Por favor selecione a Categoria');
		return categoria.focus();
	}
	xhSend('bd.insereCotacao.php','frmCotacao',validarRe);
	
}

function validarRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			obj = resposta.getElementsByTagName('retorno');

			// verifica o campo mensagem do XML, se for 1 � que inseriu OK, caso contr�rio, � erro.
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
			{
				//document.getElementById('load').style.display = 'none';
				alert('Dados salvos com sucesso!');
				limpacampos();
				listar(pagina);
			}
			else {
				alert('Falha ao salvar dados');	
			}
		}
	}
}

function limpacampos() {
	document.getElementById('frmCotacao').reset();
	$(".chzn-select").chosen();
	$("#fornecedor").val("");
	$("#fornecedor").trigger("liszt:updated");

	$(".chzn-select").chosen();
	$("#marca").val("");
	$("#marca").trigger("liszt:updated");

	$(".chzn-select").chosen();
	$("#categoria").val("");
	$("#categoria").trigger("liszt:updated");

	$(".chzn-select").chosen();
	$("#ipi").val("");
	$("#ipi").trigger("liszt:updated");
}

function veirificarEstoque(cod) {
	executar('verificar_estoque.php','id='+cod,veirificarEstoqueRe);	
}

function veirificarEstoqueRe()
{
	if (xhReq.readyState == 4)
	{
		resposta = xhReq.responseXML;
		if (resposta)
		{
			obj = resposta.getElementsByTagName('dados');
			if (obj.length >= 1)
			{
				/* Vari�veis do Formul�rio */
				var qtd			= document.getElementById('qtdacumulada');
				var Xqtd		= obj[0].getElementsByTagName('qtd')[0].firstChild;
				qtd.value 		= (Xqtd != null?unescape(Xqtd.nodeValue):'');
			}
			else { alert('Falha'); }
		}
		else { 
		alert('Falha de xml'); 
		}
	}
}

function calcularValor(val) {
	var ipi 	= parseInt(val);
	var valor 	= parseFloat(document.getElementById('valor').value);
	var valorf 	= ((valor * ipi) / 100) + valor;
	document.getElementById('valorf').value = number_format(valorf,2,',','.');
}

function editar(id) {
	executar('bd.getCotacao.php','id='+id,editarRe);
}

function editarRe()
{
	if (xhReq.readyState == 4)
	{
		resposta = xhReq.responseXML;
		if (resposta)
		{
			obj = resposta.getElementsByTagName('dados');
			if (obj.length >= 1)
			{
				/* Vari�veis do Formul�rio */
				var id			= document.getElementById('id');
				var fornecedor	= document.getElementById('fornecedor');
				var marca 		= document.getElementById('marca');
				var categoria	= document.getElementById('categoria');
				var data		= document.getElementById('data');
				var codigo	= document.getElementById('codigo');
				var observacao	= document.getElementById('observacao');
				var valor		= document.getElementById('valor');
				var ipi			= document.getElementById('ipi');
				var valorf		= document.getElementById('valorf');
				/* Vari�veis do XML */
				var Xid				= obj[0].getElementsByTagName('id')[0].firstChild;
				var Xfornecedor		= obj[0].getElementsByTagName('fornecedor')[0].firstChild;
				var Xmarca			= obj[0].getElementsByTagName('marca')[0].firstChild;
				var Xcategoria		= obj[0].getElementsByTagName('categoria')[0].firstChild;
				var Xdata			= obj[0].getElementsByTagName('data')[0].firstChild;
				var Xcodigo		= obj[0].getElementsByTagName('codigo')[0].firstChild;
				var Xobservacao		= obj[0].getElementsByTagName('observacao')[0].firstChild;
				var Xvalor			= obj[0].getElementsByTagName('valor')[0].firstChild;
				var Xipi			= obj[0].getElementsByTagName('ipi')[0].firstChild;
				var Xvalorf			= obj[0].getElementsByTagName('valorf')[0].firstChild;
				
				id.value			= Xid.nodeValue;
				fornecedor.value 	= (Xfornecedor 	!= null?unescape(Xfornecedor.nodeValue):'');
				marca.value 		= (Xmarca 		!= null?unescape(Xmarca.nodeValue):'');
				categoria.value 	= (Xcategoria 	!= null?unescape(Xcategoria.nodeValue):'');
				data.value 			= (Xdata 		!= null?unescape(Xdata.nodeValue):'');
				codigo.value 	= (Xcodigo	!= null?unescape(Xcodigo.nodeValue):'');
				observacao.value 	= (Xobservacao	!= null?unescape(Xobservacao.nodeValue):'');
				valor.value 		= (Xvalor		!= null?unescape(Xvalor.nodeValue):'');
				valorf.value 		= (Xvalorf		!= null?unescape(Xvalorf.nodeValue):'');
				ipi.value 			= (Xipi			!= null?unescape(Xipi.nodeValue):'');
				
				$(".chzn-select").chosen();
				$("#fornecedor").val(fornecedor.value);
				$("#fornecedor").trigger("liszt:updated");
			
				$(".chzn-select").chosen();
				$("#marca").val(marca.value);
				$("#marca").trigger("liszt:updated");
			
				$(".chzn-select").chosen();
				$("#categoria").val(categoria.value);
				$("#categoria").trigger("liszt:updated");
			
				$(".chzn-select").chosen();
				$("#ipi").val(ipi.value);
				$("#ipi").trigger("liszt:updated");
				
				document.getElementById('btnCad').innerHTML = 'Alterar';
			}
			else { alert('Falha ao editar Marca'); }
		}
		else { 
		alert('Falha de xml'); 
		}
	}
}
