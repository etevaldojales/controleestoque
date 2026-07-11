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
	var status  = document.getElementById('ativo').checked == true ? 1 : 0;
	include('lista_fornecedores.php','parametro='+val+'&status='+status,'lista');	
}


function validar() {
	var fornecedor 	= document.getElementById('fornecedor');	
	if(!fornecedor.value) {
		showToast('Por favor preencha o campo Nome do Fornecedor', 'warning');
		return fornecedor.focus();
	}
	$.ajax({
		type: 'POST',
		url: 'bd.insereFornecedor.php',
		data: $('#frmFornecedor').serialize(),
		success: function(retorno) {
			if(retorno == 1) {
				showToast('Fornecedor cadastrado com sucesso!', 'success');
				limpacampos();
				listar(pagina);
			} else if(retorno == 2) {
				showToast('Fornecedor alterado com sucesso!', 'success');
				limpacampos();
				listar(pagina);
			} else {
				showToast('Houve um erro ao cadastrar/alterar o Fornecedor', 'error');
			}
		},
		error: function(XHR, textStatus, errorThrown) {
			showToast('Houve um erro ao processar a requisição', 'error');
			for(var i in XHR) {
				if(i != 'channel') console.log(i + ' : ' + XHR[i]);
			}
		}
	});
	
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
				/* Vari�veis do Formul�rio */
				var id			= document.getElementById('id');
				var nome		= document.getElementById('fornecedor');
				/* Vari�veis do XML */
				var Xid				= obj[0].getElementsByTagName('id')[0].firstChild;
				var Xnome			= obj[0].getElementsByTagName('nome')[0].firstChild;
				
				id.value			= Xid.nodeValue;
				nome.value 			= (Xnome != null?unescape(Xnome.nodeValue):'');
				
				document.getElementById('btnCad').innerHTML = 'Alterar';
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
				if (obj[0].firstChild.nodeValue == 1) 
				{
					showToast('Registro excluído com sucesso!', 'success');
					listar(pagina);					
				}
				else if(obj[0].firstChild.nodeValue == 2)
				{
					showToast('Não é possível excluir esse fornecedor, existe registro relacionado a ele', 'warning');	
				}
				else 
				{
					showToast('Houve um erro ao excluir dados', 'error');	
				}
			}
		}
	}
}

function limpacampos() {
	document.getElementById('frmFornecedor').reset();
	document.getElementById('id').value = 0;
	document.getElementById('btnCad').innerHTML = 'Cadastrar';
}
