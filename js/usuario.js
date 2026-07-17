// JavaScript Document
var pagina;

function parseXMLResponse(xhr) {
	var xml = xhr.responseXML;
	if (!xml && xhr.responseText) {
		var text = xhr.responseText;
		var rootIndex = text.indexOf('<root>');
		if (rootIndex !== -1) {
			text = text.substring(rootIndex);
		}
		try {
			xml = $.parseXML(text);
		} catch (e) {
			console.error("Failed to parse XML: ", e);
		}
	}
	return xml;
}

function listar(pag) {
	pagina = pag;
	include('lista_usuarios.php','pagina='+pag,'lista');	
}

function paginar(pag) {
	pagina = pag;
	include('lista_usuarios.php','pagina='+pag,'lista');	
}

function pesquisar(val) {
	include('lista_usuarios.php','parametro='+val,'lista');	
}


function valida() {
	var nome 	= document.getElementById('nome_usu');
	var login 	= document.getElementById('login_usu');
	var senha 	= document.getElementById('senha_usu');
	var id 		= document.getElementById('id').value;	
	if(!nome.value) {
		showToast('Por favor preencha o campo Nome do Usuário', 'warning');
		return nome.focus();
	}
	if(!login.value) {
		showToast('Por favor preencha o campo Login do Usuário', 'warning');
		return login.focus();
	}
	if(!senha.value && id == 0) {
		showToast('Por favor preencha o campo Senha do Usuário', 'warning');
		return senha.focus();
	}
	else {
		//document.getElementById('load').style.display = '';
		xhSend('bd.insereUsuario.php','frmUsu',validaRe);
	}
}

function validaRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = parseXMLResponse(xhReq);
			if (resposta)
			{
				obj = resposta.getElementsByTagName('retorno');

				// verifica o campo mensagem do XML, se for 1 é que inseriu OK, caso contrário, é erro.
				if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
				{
					showToast('Dados salvos com sucesso!', 'success');
					limpacampos();
					listar(pagina);
				}
				else if(obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 2) {
					showToast('Usuário já cadastrado', 'warning');
					limpacampos();
				}
				else {
					showToast('Falha ao salvar dados', 'error');	
				}
			}
			else
			{
				showToast('Falha ao processar resposta do servidor', 'error');
			}
		}
	}
}

function limpacampos() {
	document.getElementById('frmUsu').reset();	
	//document.getElementById('btnExclui').style.display = 'none';
	document.getElementById('btnSalva').innerHTML = "<i class='icon-save'></i> Salvar";
	document.getElementById('dvpermissoes').innerHTML = '';
	document.getElementById('dvpermissoes').style.display = 'none';
	document.getElementById('id').value = 0;
}

function editar(id) {
	executar('bd.getUsuario.php','id='+id,editarRe);
}

function editarRe()
{
	if (xhReq.readyState == 4)
	{
		resposta = parseXMLResponse(xhReq);
		console.log(xhReq.responseText);
		if (resposta)
		{
			obj = resposta.getElementsByTagName('dados');
			if (obj.length >= '1')
			{
				/* Variï¿½veis do Formulï¿½rio */
				var id			= document.getElementById('id');
				var nome		= document.getElementById('nome_usu');
				var login		= document.getElementById('login_usu');
				var email		= document.getElementById('email_usu');
				var fone		= document.getElementById('fone_usu');
				var tipo		= document.getElementById('tipo_usu');
				/* Variï¿½veis do XML */
				var Xid			= obj[0].getElementsByTagName('id')[0].firstChild;
				var Xnome		= obj[0].getElementsByTagName('nome')[0].firstChild;
				var Xlogin		= obj[0].getElementsByTagName('login')[0].firstChild;
				var Xemail		= obj[0].getElementsByTagName('email')[0].firstChild;
				var Xfone		= obj[0].getElementsByTagName('fone')[0].firstChild;
				var Xtipo		= obj[0].getElementsByTagName('tipo')[0].firstChild;
				
				id.value		= Xid.nodeValue;
				nome.value 		= (Xnome != null?unescape(Xnome.nodeValue):'');
				login.value 	= (Xlogin != null?unescape(Xlogin.nodeValue):'');
				email.value 	= (Xemail != null?unescape(Xemail.nodeValue):'');
				fone.value 		= (Xfone != null?unescape(Xfone.nodeValue):'');
				tipo.value 		= (Xtipo != null?unescape(Xtipo.nodeValue):'');
				document.getElementById('btnSalva').innerHTML = "<i class='icon-save'></i> Salvar";
				listarPermissoes(id.value);
			}
			else { showToast('Falha ao editar usuário', 'error'); }
		}
		else { 
		showToast('Falha de XML', 'error'); 
		}
	}
}

function excluir(id) {
	customConfirm('Deseja realmente excluir esse registro?', function() {
		executar('bd.excluiUsuario.php','id='+id,excluirRe);	
	});
}

function excluirRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = parseXMLResponse(xhReq);
			if (resposta)
			{
				obj = resposta.getElementsByTagName('retorno');
				if (obj[0] && obj[0].firstChild) 
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
			else
			{
				showToast('Falha ao processar resposta do servidor', 'error');
			}
		}
	}
}

function excluirImagem(id) {
	customConfirm('Deseja realmente excluir essa foto?', function() {
		executar('excluirImagemUsuario.php','id='+id,excluirImagemRe);	
	});
}

function excluirImagemRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = parseXMLResponse(xhReq);
			if (resposta)
			{
				obj = resposta.getElementsByTagName('retorno');
				if (obj[0] && obj[0].firstChild) 
				{
					if (obj[0].firstChild.nodeValue == '1') 
					{
						showToast('Foto excluída com sucesso!', 'success');
						editar(document.getElementById('id').value);
					}
					else
					{
						showToast('Houve um erro ao excluir dados', 'error');	
					}
				}
			}
			else
			{
				showToast('Falha ao processar resposta do servidor', 'error');
			}
		}
	}
}

function cadastrarPermissoes() {
	if(document.getElementById('id').value == 0) {
		showToast('Por favor selecione um usuário', 'warning');
		return false;
	}
	//document.getElementById('loadperm').style.display = '';
	xhSend('cadastroPermissoes.php','frmPerm',cadastrarPermissoesRe);
}

function cadastrarPermissoesRe() {
	if (xhReq.readyState == 4)
	{
		retorno = parseXMLResponse(xhReq);
		console.log(xhReq.responseText);
		// se o retorno for um XML, entï¿½o comeï¿½a a agir.
		if (retorno != null)
		{
			obj = retorno.getElementsByTagName('retorno');
			// verifica o campo mensagem do XML, se for 1 ï¿½ que inseriu OK, caso contrï¿½rio, ï¿½ erro.
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
			{
				showToast('Dados cadastrados com sucesso!', 'success');
				setTimeout(function() {
					location.href = 'usuario.php';
				}, 1500);
			}
			else { 
				showToast('Falha ao cadastrar dados', 'error'); 
			}
			document.getElementById('loadperm').style.display = 'none';
		}
		else { 
			showToast('Falha ao cadastrar dados', 'error'); 
		}
	}
}

function listarPermissoes() {
	document.getElementById('dvpermissoes').style.display = '';
	var id = document.getElementById('id').value;
	include('lista_permissoes.php','id='+id,'dvpermissoes');	
}
