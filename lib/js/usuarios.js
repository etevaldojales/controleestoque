/*
Arquivo de funções para manipulação
*/
// mensagem de erro na funcao deleta;
var mensagem; 
function abre(pag) {
	document.getElementById('lista').innerHTML = '<div align="center"><br><img src="../imagens/icones/black_preload.gif" width="16" height="16" align="absmiddle"> Aguarde...<br></div>';
	include("adm/usuarios/lista.php",'pagina='+pag,'lista');
}

function novo() {
	var id			= 	document.getElementById('id_usuario');
	var nome		=	document.getElementById('nome');
	var email		=	document.getElementById('email');
	var ddd			=	document.getElementById('ddd');
	var telefone	=	document.getElementById('telefone');
	var login		= 	document.getElementById('login');
	var senha		= 	document.getElementById('senha');
	var senha2		= 	document.getElementById('senha2');
	if(nome.value == '') { alert('Por favor preencha o campo Nome.'); nome.focus(); return false; }
	else if(email.value == '') { alert('Por favor preencha o campo E-mail.'); email.focus(); return false; }
	else if(ddd.value == '') { alert('Por favor preencha o campo DDD.'); ddd.focus(); return false; }
	else if(telefone.value == '') { alert('Por favor preencha o campo Telefone.'); telefone.focus(); return false; }
	else if(login.value == '') { alert('Por favor preencha o campo Nome.'); login.focus(); return false; }
	else {
		if (senha.value == '' || senha2.value == '') {
			alert('Por favor preencha o campo Senha.'); senha.focus(); return false;
		}
		else if (senha.value != 'vazio' && senha2.value != 'vazio' && senha.value != senha2.value) {
			alert('Campo Senha deve ser igual ao campo Confirmação de senha.\nPara manter a senha original, deixe o campo em branco');
			return false;
		}
		document.getElementById('botao').disabled	= true;
		document.getElementById('botao').value		= 'Aguarde';
		mensagem = 'Usuário inserido/alterado com sucesso';
		xhSend('adm/usuarios/bd.altera.php','cad',novoReturn)
	}
}
function novoReturn() {
	if (xhReq.readyState == 4) {
		if (parseInt(xhReq.responseText) > 0) {
			alert(mensagem);
			mensagem = '';
			zeraCampos();
			document.getElementById('id_usuario').value = xhReq.responseText;
			document.getElementById('ListaPermissoes').innerHTML = 'Verifique a disponibilidade de login para exibir a lista de Permissões.';
		}
		else if (xhReq.responseText == 'existe') {
			alert('Este usuário já existe. \nEscolha outro e clique em Verifique Disponibilidade');
		}
		else {
			mensagem = '';
			alert('Houve um erro na edição/inclusão deste usuário.\nPor favor tente novamente');
		}
	}
}
function edita(id) {
	document.getElementById('verificaRetorno').innerHTML = 'Para alterar a senha deste usuário preencha os campos abaixo:';
	document.getElementById('cadastroFim').style.display = '';
	executar("adm/usuarios/bd.get.php",'id='+id,editaopen);
}

function deleta(id,nome) {
	customConfirm('Tem certeza que deseja excluir "'+nome+'" do cadastro?', function() {
		mensagem = 'Destinatário excluído com sucesso';
		executar("adm/usuarios/bd.delete.php",'id='+id,zeraCampos);
	});
}

function zeraCampos() {
	if(xhReq.readyState==4){
		if (mensagem) {
			alert(mensagem);
		}
		var id			= 	document.getElementById('id_usuario');
		var nome		=	document.getElementById('nome');
		var email		=	document.getElementById('email');
		var ddd			=	document.getElementById('ddd');
		var telefone	=	document.getElementById('telefone');
		var login		= 	document.getElementById('login');
		var senha		= 	document.getElementById('senha');
		var senha2		= 	document.getElementById('senha2');
		nome.value			= '';
		email.value			= '';
		ddd.value			= '';
		telefone.value		= '';
		login.value			= '';
		senha.value			= '';
		senha2.value		= '';
		document.getElementById('status').checked	= true;
		document.getElementById('admin').checked	= false;
		document.getElementById('botao').value		= 'Cadastrar';
		document.getElementById('botao').disabled	= false;
		document.getElementById('cadastroFim').style.display = 'none';
		document.getElementById('verificaRetorno').innerHTML = '';
		setTimeout('abre(1)',500);
		mensagem = "";
	}
	else return;
}


/*
Função que pega os dados via ajax e preenche formulario sem dar refresh.
Codifica o texto enviado ao banco que deve ser lido com a funcao unhtmlentities
da classe utilidades.

*/
function editaopen() {
	if(xhReq.readyState==4){ 
		resposta= xhReq.responseXML;
		if (resposta) {
			obj				= 	resposta.getElementsByTagName('usuario');
			var id			= 	document.getElementById('id_usuario');
			var nome		=	document.getElementById('nome');
			var email		=	document.getElementById('email');
			var ddd			=	document.getElementById('ddd');
			var telefone	=	document.getElementById('telefone');
			var login		= 	document.getElementById('login');
			var senha		= 	document.getElementById('senha');
			var senha2		= 	document.getElementById('senha2');
			id.value			= obj[0].getElementsByTagName('id_usuario')[0].firstChild.nodeValue;
			nome.value			= obj[0].getElementsByTagName('nome')[0].firstChild.nodeValue;
			email.value			= obj[0].getElementsByTagName('email')[0].firstChild.nodeValue;
			ddd.value			= obj[0].getElementsByTagName('telefone')[0].firstChild.nodeValue.substr(0,2);
			telefone.value		= obj[0].getElementsByTagName('telefone')[0].firstChild.nodeValue.substr(2);
			login.value			= obj[0].getElementsByTagName('login')[0].firstChild.nodeValue;
			senha.value			= 'vazio';
			senha2.value		= 'vazio';
			if (obj[0].getElementsByTagName('ativo')[0].firstChild.nodeValue == 0) { document.getElementById('status').checked = false; }
			else document.getElementById('status').checked = true;
			if (obj[0].getElementsByTagName('admin')[0].firstChild.nodeValue == 0) { document.getElementById('admin').checked = false; }
			else document.getElementById('admin').checked = true;
			document.getElementById('botao').value		= 'Alterar';
			abrePermissao(obj[0].getElementsByTagName('id_usuario')[0].firstChild.nodeValue);
		}
		else {
			alert('Erro na edição deste usuário.\nTente novamente mais tarde;');	
		}
	}
}
function buscardest() {
	var nome = document.getElementById('busca_nome');
	var dia = document.getElementById('busca_dia');
	var mes = 	document.getElementById('busca_mes');
	var ano = 	document.getElementById('busca_ano');
	var sexo = 	document.getElementById('busca_sexo');
	var gruposbusca = 	document.getElementById('busca_grupobusca')
	var busca = document.getElementById('busca_btbusca');
/*	var cor = '#e2e2e1';
	nome.readOnly = true;
	nome.style.background = cor;
	dia.readOnly = true;
	dia.style.background  = cor;
	mes.readOnly = true;
	mes.style.background  = cor;
	ano.readOnly = true;
	ano.style.background  = cor;
	sexo.readOnly = true;
	sexo.style.background  = cor;
	gruposbusca.readOnly = true;
	gruposbusca.style.background  = cor;
	busca.disabled = true;
*/
	xhSend('adm/newsletter/bd.buscaDetalhada.destinatario.php','buscar',incluiBusca);
}
function incluiBusca() {
		if (xhReq.readyState == 4) {
			document.getElementById('lista').innerHTML = xhReq.responseText;
		}
	}
function abredestinatariobusca(parametros) {
	document.getElementById('lista').innerHTML = '<div align="center"><br><img src="../imagens/icones/black_preload.gif" width="16" height="16" align="absmiddle"> Aguarde carregamento dos Destinat&aacute;rios.<br></div>';
	include("adm/newsletter/bd.buscaDetalhada.destinatario.php",parametros,'lista');
}
function resetBusca() {
	var nome = document.getElementById('busca_nome');
	var dia = document.getElementById('busca_dia');
	var mes = 	document.getElementById('busca_mes');
	var ano = 	document.getElementById('busca_ano');
	var sexo = 	document.getElementById('busca_sexo');
	var grupobusca = 	document.getElementById('busca_grupobusca');
//	var grupos = 	document.getElementById('grupos')
	var busca = document.getElementById('busca_btbusca');
	var cor = '';
	nome.readOnly = false;
	nome.style.background = cor;
	dia.readOnly = false;
	dia.style.background  = cor;
	mes.readOnly = false;
	mes.style.background  = cor;
	ano.readOnly = false;
	ano.style.background  = cor;
	sexo.readOnly = false;
	sexo.style.background  = cor;
	grupobusca.readOnly = false;
	grupobusca.style.background  = cor;
	busca.disabled = false;
}
function deletadestinatarioBusca(id,nome) {
	customConfirm('Tem certeza que deseja excluir "'+nome+'" do cadastro?', function() {
		mensagem = 'Destinatário excluído com sucesso';
		executar("adm/usuarios/bd.delete.usuarios.php",'id='+id,zeraCampos);
	});
}

function zeraCamposBusca() {
	if(xhReq.readyState==4){
		if (mensagem) {
			alert(mensagem);
		}
		// zera campos e seta o id com o retorno do readystate.
		document.getElementById('nome').value		= '';
		document.getElementById('id_usuario').value			= '';
		document.getElementById('id_grupo').value	= '1';
		document.getElementById('email').value		= '';
		document.getElementById('sexo').value		= '';
		document.getElementById('data').value		= '';
		document.getElementById('status').checked	= true;
		document.getElementById('botao').value		= 'Cadastrar';
		abrePermissoes(document.getElementById('id_usuario').value);
		setTimeout('abredestinatario(1)',500);
		mensagem = "";
	}
	else return;
}
//var id_dest;
//var newsletter;
function editaInclude(id,news) {
	document.getElementById('tr'+id).style.display = '';
	document.getElementById('tr'+id).innerHTML = '<img src="../../imagens/icones/black_preload.gif" width="16" height="16" align="absmiddle"> Aguarde...';
//	include("cadastro.destinatario.php",'id='+id,'tr'+id));
	id_dest = id;
	newsletter = news
	executar("cadastro.destinatario.php",'id='+id,editaIncludeReturn)
}
function editaIncludeReturn() {
	if (xhReq.readyState == 4) {
		document.getElementById('tr'+id_dest).innerHTML = xhReq.responseText;
		Calendar.setup(
			{
					inputField  : "data",
					button      : "data_img"
			}
		);
	}
}
function alteradestinatarioErro() {
	id			= document.getElementById('id_usuario').value;
	email		= document.getElementById('email');
	grupo		= document.getElementById('id_grupo').value;
	if (email.value == "") {
		alert("Informe um email para o destinatário!");
		email.focus();
		return;
	}
	else if (grupo.value == "") {
		alert('Por favor selecione um grupo para o destinatário');
		return false;
	}
	else {
		mensagem = 'Destinatário alterado com sucesso';
		xhSend('bd.altera.destinatario.php','cad',alteradestinatarioErroReturn);
	}
}
function alteradestinatarioErroReturn() {
	if (xhReq.readyState == 4) {
		executar('bd.altera.envio.php','id='+id_dest+'&id_news='+newsletter,finalizaediterro);
	}
}
function finalizaediterro() {
	if (xhReq.readyState == 4) {
		alert('Atualização realizada com sucesso');
		document.getElementById('tr'+id).style.display = 'none';
		document.getElementById('img'+id).src = '../../imagens/icones/ativo.gif';
		document.getElementById('linkEdit'+id).onclick = '';
	}
}
function verificaDisponibilidade() {
	if (document.getElementById('login').value != '') {
		if (document.getElementById('id_usuario').value != '') {
			parametros = "&id_usuario="+document.getElementById('id_usuario').value;
//			alert(parametros);
		}
		else {
			parametros = '';	
		}
		executar('adm/usuarios/bd.verificalogin.php','login='+document.getElementById('login').value+parametros,verDispoReturn);
	}
}
function verDispoReturn() {
	div = document.getElementById('verificaRetorno');
	cadastroFim = document.getElementById('cadastroFim');
	if (xhReq.readyState == 4) {
		if (xhReq.responseText == 'ok') {
			div.innerHTML = '<a style="color:green">Login disponível no momento.</a>'
			cadastroFim.style.display = '';
			abrePermissao(document.getElementById('id_usuario').value);
		}
		else {
			cadastroFim.style.display = 'none';
			div.innerHTML = '<a style="color:red">Este login já encontra-se na base de dados.</a>';
			document.getElementById('ListaPermissoes').innerHTML = 'Verifique a disponibilidade de login para exibir a lista de Permissões.';
		}
	}
}
function abrePermissao(id) {
	include('adm/usuarios/bd.getPermissoes.php',"id="+id,'ListaPermissoes');
}
var id_permissao;
var id_usuario;
function alteraPermissao(id) {
	id_usuario = document.getElementById('id_usuario').value;
	document.getElementById('imgAguardePerm').style.display = '';
	id_permissao = id;
	executar('adm/usuarios/bd.altera.permissao.php','id_permissao='+id+'&id_usuario='+id_usuario,alteraPermissaoReturn);
}
function alteraPermissaoReturn() {
	if (xhReq.readyState == 4) {
		if (xhReq.responseText == 'ativo.gif' || xhReq.responseText == 'inativo.gif') {
			document.getElementById('img'+id_permissao).src = '../imagens/icones/'+xhReq.responseText;
		}
		document.getElementById('imgAguardePerm').style.display = 'none';
	}
}
var imagem;
function alteraStatus(id,img) {
	id_usuario = id;
	imagem = img;
	i=0;
	document.getElementById('imgAguarde').style.display = '';
	executar('adm/usuarios/bd.altera.status.php','id_usuario='+id_usuario,alteraStatusReturn);
}
function alteraStatusReturn() {
	if (xhReq.readyState == 4) {
		if (xhReq.responseText == 'ativo.gif' || xhReq.responseText == 'inativo.gif') {
			i=0;
			document.getElementById('imgAguarde').style.display = 'none';
			document.getElementById('imgStatus'+imagem).src = '../imagens/icones/'+xhReq.responseText;
		}
	}
}
