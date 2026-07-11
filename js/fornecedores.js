// JavaScript Document
var pagina;

function listar(pag) {
	pagina = pag;
	include('lista_fornecedores.php','pagina='+pag,'lista');	
}

function paginar(pag) {
	pagina = pag;
	include('lista_fornecedores.php','pagina='+pag,'lista');	
}

function pesquisar() {
	var val 	= document.getElementById('parametro').value;
	include('lista_fornecedores.php','parametro='+val,'lista');	
}

function valida() {
	var nome 	= document.getElementById('nmfornecedor');
	
	if(nome.value == 0) {
		showToast('Por favor preencha o campo Fornecedor', 'warning');
		return nome.focus();
	}
	else {
		xhSend('bd.insereFornecedor.php','frmCadForn',validaRe);
	}
}

function validaRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			obj = resposta.getElementsByTagName('retorno');

			// verifica o campo mensagem do XML, se for 1 é que inseriu OK, caso contrário, é erro.
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
			{
				//document.getElementById('load').style.display = 'none';
				showToast('Dados salvos com sucesso!', 'success');
				limpacampos();
				listar(pagina);
			}
			else if(obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 2) {
				showToast('Fornecedor já cadastrado', 'warning');
				limpacampos();
			}
			else {
				showToast('Falha ao salvar dados', 'error');	
			}
		}
	}
}

function limpacampos() {
	document.getElementById('frmCadForn').reset();	
	document.getElementById('id').value = 0;
	document.getElementById('btnSalva').innerHTML = '<i class="icon-ok"></i> Cadastrar';
}

function editar(id) {
	executar('bd.getFornecedor.php','id='+id,editarRe);
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
				/* Variáveis do Formulário */
				var id				= document.getElementById('id');
				var nome			= document.getElementById('nmfornecedor');
				
				/* Variáveis do XML */
				var Xid				= obj[0].getElementsByTagName('id')[0].firstChild;
				var Xnome			= obj[0].getElementsByTagName('nome')[0].firstChild;
				
				id.value			= Xid.nodeValue;
				nome.value 			= (Xnome != null?unescape(Xnome.nodeValue):'');
				
				document.getElementById('btnSalva').innerHTML = '<i class="icon-ok"></i> Alterar';
			}
			else { showToast('Falha ao editar Fornecedor', 'error'); }
		}
		else { 
		showToast('Falha de XML', 'error'); 
		}
	}
}

function excluir(id) {
	customConfirm('Deseja realmente excluir esse registro?', function() {
		executar('bd.excluiFornecedor.php','id='+id,excluirRe);	
	});
}

function excluirRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			obj = resposta.getElementsByTagName('retorno');
			if (obj[0].firstChild) 
			{
				if (obj[0].firstChild.nodeValue == '1') 
				{
					showToast('Registro excluído com sucesso!', 'success');
					listar(pagina);					
				}
				else
				{
					showToast('Houve um erro ao excluir dados', 'error');	
				}
			}
		}
	}
}

function limparCombo(combo,inicio)
{
	var tamanho=combo.options.length;
	for (i=tamanho-1;i>=inicio;i--)
		combo.remove(i) ;
}

function addCombo(valor,texto,combo) {
	var opcao = new Option(texto, valor);
    combo.options[combo.length] = opcao;
}

