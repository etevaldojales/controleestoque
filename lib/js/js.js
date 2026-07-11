//
//		Funções genéricas.
//

var hoje = new Date();		

dia = hoje.getDate();
mes = hoje.getMonth()+1; /* No JS, os meses são 0-11 */
ano = hoje.getFullYear(); /* getFullYear() para 2006, getYear() para 106 */

if(dia < 10) dia = '0'+dia;
if(mes < 10) mes = '0'+mes;

hora = hoje.getHours();
minutos = hoje.getMinutes();

//	Variavel para tratamento de browser.
var browser = navigator.appName;
// endereço do site para exibição de imagens
//var endereco = 'hawaii:81/cec/';
var endereco = 'enjoydesign.com.br/';

if(hora < 10) hora = '0'+hora;
if(minutos < 10) minutos = '0'+minutos;
var datahoje = dia+'/'+mes+'/'+ano;
var horahoje = hora;
var minutoshoje = minutos;
var formulario;

// passar somente nome do formulario.
// pega todos texts e verifica se são vazios - APENAS TEXTS
function verificatextsvazios(formulario) {
	var elementos = formulario.elements.length;
	for (i = 0;i<elementos;i++) 
		{
			if (formulario.elements[i].value == '' && formulario.elements[i].type == 'text') 
			{
				alert('Por gentileza preencha o campo ' + formulario.elements[i].title + ' para continuar');
				formulario.elements[i].focus();
				return false;
			}
		}	
}
// passar como document.getElement. Valida email.
function validamail (email) {
		if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value))) {
			alert("Email invalido, digite novamente por favor.");
			return email.focus();
		}
}
function validaEmailBO (email) {
		if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value))) {
			return false;
		}
		return true;
}
// mascara de cpf
function mascara_cpf(cpf) { 
	var mycpf = ''; 
	mycpf = mycpf + cpf; 
	if (mycpf.length == 3) { 
		mycpf = mycpf + '.'; 
		document.cad.cpf.value = mycpf; 
	} 
	if (mycpf.length == 7) { 
		mycpf = mycpf + '.'; 
		document.cad.cpf.value = mycpf; 
	} 
	if (mycpf.length == 11) { 
		mycpf = mycpf + '-'; 
		document.cad.cpf.value = mycpf; 
	} 
	if(mycpf.length > 14) {
	   alert("CPF inv&aacute;lido");
		return document.cad.cpf.focus();
	} 
}
// mascara telefone
function mascara_fone(fone) {
	var myfone = '';
	myfone = myfone + fone;
	if(myfone.length == 2) {
	   myfone = '(' + myfone + ')  ';
	   document.cad.fone.value = myfone; 
	}
	if(myfone.length == 10) {
	   myfone = myfone + ' - ';
	   document.cad.fone.value = myfone; 
	}
}
// mascara fone
function mascara_cel(fone) {
	var myfone = '';
	myfone = myfone + fone;
	if(myfone.length == 2) {
	   myfone = '(' + myfone + ')  ';
	   document.cad.celular.value = myfone; 
	}
	if(myfone.length == 10) {
	   myfone = myfone + ' - ';
	   document.cad.celular.value = myfone; 
	}
}

function verificavazio(obj) {
	var valor = obj.value;
	if (valor == "") {
		alert('Atencao:\n Campo '+obj.name+' nao pode estar em branco.');
		obj.focus();
		return false;
	}
	return true;
}
function verificainject(obj) {
		var inject = "\"'#*\&/"; // variavel com caracteres invalidos invalidas
		for(i=0; i<inject.length; i++)
		{
			if(obj.value.indexOf(inject.charAt(i)) >= 0)
			{
			alert("Caracteres invalidos no campo ''"+obj.name+"'',\n favor corrigir. (Ex.\",',#,*,\\,& e /)");
			obj.focus();
			return false;
			}
		}
		return true;
}

function checanumero(nome)
{
	var checkOK = "0123456789";
	var checkStr = nome.value;
	var allValid = true;
	for (i = 0; i < checkStr.length; i++) {
		ch = checkStr.charAt(i);
		for (j = 0; j < checkOK.length; j++)
			if (ch == checkOK.charAt(j))
			break;
			if (j == checkOK.length) {
				allValid = false;
				break;
			}
		}
		if (!allValid) {
			alert("Digite apenas numeros no campo ''"+nome.name+"''");
			nome.focus();
			return (false);
		}
}


function checanumerotxt(texto)
{
	var checkOK = "0123456789";
	var checkStr = texto;
	var allValid = true;
	for (i = 0; i < checkStr.length; i++) {
		ch = checkStr.charAt(i);
		for (j = 0; j < checkOK.length; j++)
			if (ch == checkOK.charAt(j))
			break;
			if (j == checkOK.length) {
				allValid = false;
				break;
			}
		}
		if (!allValid) {
			return (false);
		}
		return true;
}

//
// Funções específicas AJAX
//

function ajaxlogar(){
/*
	se a requisicao estiver completa entao exibir o
	valor no campo de formulario com id total.
 */  
	if(xhReq.readyState!=4){return;}
	var total=document.getElementById('retorno');
	if (xhReq.responseText == 'logado') 
	{
		document.getElementById('carregando').innerHTML='<br><br><br><img src="img/black_preload.gif" align="absmiddle"> &nbsp;Carregando...';
		location.href = 'index.php';
	}
	else 
		{
		total.innerHTML=xhReq.responseText;
		total.style.visibility = 'visible';
		document.getElementById('login_usu').disabled = false;
		document.getElementById('senha').disabled = false;
		document.getElementById('login-btn').disabled = false;
	//	document.getElementById('Reset').disabled = false;
	}
}
function verificalogin() {
	var login_usu = document.getElementById('login_usu');
	var senha = document.getElementById('senha');
	document.getElementById('senha').value = hex_md5(senha.value);
	if (verificavazio(document.getElementById('login_usu')) == false || verificavazio(document.getElementById('senha')) == false || verificainject(document.getElementById('login_usu')) == false || verificainject(document.getElementById('senha')) == false) 
	{
		return false; 
	}
	else 
	{
		xhSend('login/index.php','logar',ajaxlogar)
		login_usu.disabled = true;
		senha.disabled = true;
		document.getElementById('login-btn').disabled = true;
//		document.getElementById('Reset').disabled = true;
	}
}
function verificaextensao(obj,nome,exts) {
	var pos;
	var ext;
	if (obj.value == '') {
		alert('Selecione um arquivo para realizar o upload.');	
		return false;
	}
	pos = obj.value.lastIndexOf('.');
	ext = obj.value.substring(pos+1,obj.value.length);
	if (exts.indexOf(ext) == -1) {
		alert("Selecione um arquivo v&aacute;lido em "+nome+".");
		obj.focus();
		return false;
	}
	return true;
}
function visibilidade(id) {
	if (document.getElementById(id).style.display == 'none') {
		document.getElementById(id).style.display = '';
	}
	else {
		document.getElementById(id).style.display = 'none';
	}
}
function mudapara(atual,para,chars) {
	var goto = document.getElementById(para);
	if (atual.value.length >= chars) {
		goto.focus();
	}
} 
function mudaCampos(formulario,acao)
{
	var action
	if (acao == '0') { action = true; }
	else { action = false; }
	for (i = 0; i < formulario.length; i++)
	{
		formulario.elements[i].disabled = action;	
	}
}

function moveList(origem,destino,limite) {
	dest 	= 	document.getElementById(destino);
	orig	=	document.getElementById(origem);
	if (document.getElementById(origem).value == '') {
		return false;
	}
	else {
		if (limite == '' || dest.length < limite) {
			txt 	=	document.getElementById(origem).options[document.getElementById(origem).selectedIndex].text;
			valor 	= 	document.getElementById(origem).value;
			orig.options[orig.selectedIndex] = null;
			dest.options[dest.length] = new Option(txt,valor);
		}
		else {
			alert('Este campo permite no m&aacute;ximo '+limite+' ítens');
		}
	}
}

function addList(origem,destino,limite) {
	dest 	= 	document.getElementById(destino);
	orig	=	document.getElementById(origem);
	alert("Teste");
	if (orig.value == '') {
		alert('Por favor preencha o campo "'+orig.title+'" para adicionar a lista.');
		return false;
	}
	else {
		if (limite == '' || dest.length < limite) {
			txt 	=	orig.value;
			valor 	= 	orig.value;
			dest.options[dest.length] = new Option(txt,valor);
			orig.value = '';
		}
		else {
			alert('Este campo permite no m&aacute;ximo '+limite+' ítens');
		}
	}
}

function remList(origem) {
	orig	=	document.getElementById(origem);
	orig.options[orig.selectedIndex] = null;
}

function limpaList(list,limite)
{
	listbox = document.getElementById(list);
	for (i = listbox.length;i >= limite; i--) {
		listbox.options[i] = null;;
	}
}

function addListValor(texto,value,destino) {
	dest 	= 	document.getElementById(destino);
	txt 	=	texto;
	valor 	= 	value;
	dest.options[dest.length] = new Option(txt,valor);
}

function enviaSenha() {
   var email = document.getElementById('email_usu');
   var nome  = document.getElementById('nome_usu');
   if(!nome) {
	   alert('Preencha por favor o campo Nome');
	   return nome.focus();
   }
   if(!email) {
	   alert('Preencha por favor o campo E-mail');
	   return email.focus();
   }
   else {
		xhSend('login/envia_sen.php','frmLem',enviaSenhaRe);
   }
}

function redireciona() {
	var lem = document.getElementById('lembrar');
	if(lem.checked == true) {
      location.href = "lembra_sen.php";	
	}
}

function enviaSenhaRe() {

    if (xhReq.readyState == 4)
	{
		resposta = xhReq.responseXML;
		if (resposta)
		{
			obj = resposta.getElementsByTagName('retorno');
			// variaveis do XML
			Xmsg 	= obj[0].getElementsByTagName('mensagem')[0].firstChild;
			if (Xmsg.nodeValue == '1')
			{
				alert("E-mail enviado com sucesso");
				location.href = 'login.php';
			}
			if (Xmsg.nodeValue == '2')
			{
				alert("Falha ao enviar E-mail");
				location.href = 'login.php';
			}
			if (Xmsg.nodeValue == '0') {
			    alert("Usuario inexistente"); 
				location.href = 'login.php';
			}
		}
		else { 
		   alert("Falha de xml"); 
		}
	}
}

