// JavaScript Document
var pagina;
function listar(pag) {
	pagina = pag;
	include('lista_categorias.php','pagina='+pag,'lista');	
}

function paginar(pag) {
	pagina = pag;
	include('lista_categorias.php','pagina='+pag,'lista');	
}

function pesquisar() {
	var val 	= document.getElementById('parametro').value;
	var status  = document.getElementById('ativo').checked == true ? 1 : 0;
	include('lista_categorias.php','parametro='+val+'&status='+status,'lista');	
}


function validar() {
	var categoria 	= document.getElementById('categoria');	
	if(!categoria.value) {
		alert('Por favor insira a Categoria');
		return categoria.focus();
	}
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'bd.insereCategoria.php',
		data: $('#frmCategoria').serialize(),
		success: function(retorno) {
			if(retorno == 1) {
				alert('Categoria cadastrada com sucesso!');
				limpacampos();
				listar(pagina);
			} else if(retorno == 2) {
				alert('Categoria alterada com sucesso!');
				limpacampos();
				listar(pagina);
			} else {
				alert('Houve um erro ao cadastrar/alterar a Categoria');
			}
		},
		error: function(XHR, textStatus, errorThrown) {
			alert('Erro na requisição AJAX');
			for(var i in XHR) {
				if(i != 'channel') console.log(i + ' : ' + XHR[i]);
			}
		}
	});
	//xhSend('bd.insereCategoria.php','frmCategoria',validarRe);
	
}



function editar(id) {
	executar('bd.getCategoria.php','id='+id,editarRe);
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
				var nome		= document.getElementById('categoria');
				/* Vari�veis do XML */
				var Xid				= obj[0].getElementsByTagName('id')[0].firstChild;
				var Xnome			= obj[0].getElementsByTagName('nome')[0].firstChild;
				
				id.value			= Xid.nodeValue;
				nome.value 			= (Xnome != null?unescape(Xnome.nodeValue):'');
				
				document.getElementById('btnCad').innerHTML = 'Alterar';
			}
			else { alert('Falha ao editar Categoria'); }
		}
		else { 
		alert('Falha de xml'); 
		}
	}
}

function excluir(id) {
	customConfirm('Deseja realmente excluir esse registro?', function() {
		var token = $('input[name="csrf_token"]').val();
		executar('bd.excluiCategoria.php','id='+id+'&csrf_token='+token,excluirRe);	
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
					alert('Registro excluido com sucesso!');
					listar(pagina);					
				}
				else if(obj[0].firstChild.nodeValue == 2)
				{
					alert('N�o � poss�vel excluir essa categoria, existe registro relacionado a ela');	
				}
				else 
				{
					alert('Houve um erro ao excluir dados');	
				}
			}
		}
	}
}

function limpacampos() {
	document.getElementById('frmCategoria').reset();
	document.getElementById('id').value = 0;
	document.getElementById('btnCad').innerHTML = 'Cadastrar';
}
