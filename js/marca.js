// JavaScript Document
var pagina;
function listar(pag) {
	pagina = pag;
	include('lista_marcas.php','pagina='+pag,'lista');	
}

function paginar(pag) {
	pagina = pag;
	include('lista_marcas.php','pagina='+pag,'lista');	
}

function pesquisar() {
	var val 	= document.getElementById('parametro').value;
	var status  = document.getElementById('ativo').checked == true ? 1 : 0;
	include('lista_marcas.php','parametro='+val+'&status='+status,'lista');	
}


function validar() {
	var marca 	= document.getElementById('marca');	
	if(!marca.value) {
		showToast('Por favor insira a Marca', 'warning');
		return marca.focus();
	}
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'bd.insereMarca.php',
		data: $('#frmMarca').serialize(),
		success: function(response) {
			if(response == 1) {
				showToast('Marca cadastrada com sucesso!', 'success');
				limpacampos();
				listar(pagina);
			} else if(response == 2) {
				showToast('Marca já cadastrada no sistema!', 'warning');
				limpacampos();
				listar(pagina);
			} else if(response == 3) {
				showToast('Marca alterada com sucesso!', 'success');
				limpacampos();
				listar(pagina);
			} else {
				showToast('Houve um erro ao cadastrar/alterar a Marca', 'error');
			}
		},
		error: function(XHR, textStatus, errorThrown) {
			showToast('Erro na requisição AJAX', 'error');
			for(var i in XHR) {
				if(i != 'channel') console.log(i + ': ' + XHR[i]);
			}
		}
	});
	//xhSend('bd.insereMarca.php','frmMarca',validarRe);
	
}



function editar(id) {
	executar('bd.getMarca.php','id='+id,editarRe);
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
				var nome		= document.getElementById('marca');
				/* Vari�veis do XML */
				var Xid				= obj[0].getElementsByTagName('id')[0].firstChild;
				var Xnome			= obj[0].getElementsByTagName('nome')[0].firstChild;
				
				id.value			= Xid.nodeValue;
				nome.value 			= (Xnome != null?unescape(Xnome.nodeValue):'');
				
				document.getElementById('btnCad').innerHTML = 'Alterar';
			}
			else { showToast('Falha ao editar Marca', 'error'); }
		}
		else { 
		showToast('Falha de XML', 'error'); 
		}
	}
}

function excluir(id) {
	customConfirm('Deseja realmente excluir esse registro?', function() {
		executar('bd.excluiMarca.php','id='+id,excluirRe);	
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
					showToast('Não é possível excluir essa marca, existe registro relacionado a ela', 'warning');	
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
	document.getElementById('frmMarca').reset();
	document.getElementById('id').value = 0;
	document.getElementById('btnCad').innerHTML = 'Cadastrar';
}
