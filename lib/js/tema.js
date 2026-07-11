/*
Funções AJAX de controle de notícia.
*/
var popup
function abretema(pag) {
	include("modulos/temas/lista.temas.php",'pagina='+pag,'tema');
}
// mensagem de erro na funcao deletatema;
var mensagem; 
function novotema(id) {
	mensagem = '';
	executar("modulos/temas/bd.new.tema.php",'id='+id,deletaretorno);	
}
var statusmodify;
function editatema(id) {
	executar("modulos/temas/bd.get.php",'id='+id,editatemaopen);
}
function mudastatus(id) {
	statusmodify = id;
	document.getElementById('imgAguarde').style.display = '';
	executar("modulos/temas/bd.mudastatus.php",'id='+id,mudaimagemstatus);
}

function mudaimagemstatus() {
	if(xhReq.readyState==4){
		document.getElementById('imgAguarde').style.display = 'none';
		document.getElementById('img'+statusmodify).src = xhReq.responseText;
	}
}

function deletatema(id,titulo) {
	customConfirm('Tem certeza que deseja excluir "'+titulo+'" do cadastro?', function() {
		executar("modulos/temas/bd.apaga.tema.php",'id='+id,deletaretorno);
	});
}

/*
Função de retorno do delete de tema.
*/
function deletaretorno() {
	if(xhReq.readyState==4){
		retorno = parseInt(xhReq.responseText);
		if (retorno > 0) {
			if (mensagem) {
				alert(mensagem);
			}
			var oFCKeditor = FCKeditorAPI.GetInstance('texto');
			// zera campos e seta o id com o retorno do readystate.
			document.getElementById('titulo').value 		 = '';
			oFCKeditor.SetHTML('');
			document.getElementById('botao').value = 'Cadastrar';
			document.getElementById('status').checked = false;
			document.getElementById('id').value = xhReq.responseText;
			// da reload na lista de temas na pagina 1.
			setTimeout('abretema(1)',500);
		}
		else 
		{
			alert('Ocorreu um erro durante a remoção desta notícia\nPor favor tente novamente.');	
			abretema(1);
		}
	}
	else return;
}
/*
Função que pega os dados via ajax e preenche formulario sem dar refresh.
Codifica o texto enviado ao banco que deve ser lido com a funcao unhtmlentities
da classe utilidades.

*/
function editatemaopen() {
	if(xhReq.readyState==4){ 

		resposta = xhReq.responseXML;
		obj = resposta.getElementsByTagName('tema');
		if (obj.length > 0) {
			id 				= obj[0].getElementsByTagName('id')[0].firstChild.nodeValue;
			titulo			= unescape(obj[0].getElementsByTagName('titulo')[0].firstChild.nodeValue);
			textonot 		= unescape(obj[0].getElementsByTagName('textonot')[0].firstChild.nodeValue);
			data 			= obj[0].getElementsByTagName('data')[0].firstChild.nodeValue;
			statusretorno 	= obj[0].getElementsByTagName('status')[0].firstChild.nodeValue;
			autor 			= obj[0].getElementsByTagName('autor')[0].firstChild.nodeValue;
			document.getElementById('titulo').value 		 = titulo;
			var oFCKeditor = FCKeditorAPI.GetInstance('texto');
			oFCKeditor.SetHTML(textonot);
			document.getElementById('data').value 			 = data;
			if (statusretorno == 1) {
				document.getElementById('status').checked = true;
			}
			else {
				document.getElementById('status').checked = false;
			}
			document.getElementById('id').value = id;
			document.getElementById('botao').value = 'Alterar';
		}
		else {
			
		}
	}
	if(xhReq.readyState!=4){ 
		return;
	}
}

function alteratema()
{
	// cria objeto do fck editor
	var oEditor = FCKeditorAPI.GetInstance('texto');
	// pega o valor do campo do fck editor.
	var texto = oEditor.GetXHTML();
	document.getElementById('texto').value = escape(texto);
	var titulo = document.getElementById('titulo');
	var data = document.getElementById('data');
	var id = document.getElementById('id');
	if (texto.value =='' || titulo.value =='' || data.value =='' || id.value =='') {
		alert('Por favor preencha todos os campos.');
		return false;
	}
	else {
		document.getElementById('botao').value = 'Aguarde';
		document.getElementById('botao').disabled = true;
		xhSend('modulos/temas/bd.altera.tema.php','cad_tema',alteratemafim);
	}
}
// apos ter readyState == 4, entao chega se o retorno é um numero (id temporario).
function alteratemafim() {
	if(xhReq.readyState==4){
		if (checanumerotxt(xhReq.responseText)) {
			// abre objeto para que possa ser colocado o texto '' no fck.
			var oFCKeditor = FCKeditorAPI.GetInstance('texto');
			oFCKeditor.SetHTML('');
			alert('Operação realizada com sucesso.');
			// zera campos e seta o id com o retorno do readystate.
			document.getElementById('titulo').value 		 = '';

			document.getElementById('data').value = datahoje;
			document.getElementById('botao').value = 'Cadastrar';
			document.getElementById('botao').disabled = false;
			document.getElementById('status').checked = false;
			document.getElementById('id').value = xhReq.responseText;
			// da reload na lista de temas na pagina 1.
			abretema(1)
		}
		else {
			alert('Ocorreu um erro durante sua solicitação.\nTente novamente por favor.');
		}
	}
	else {
		return;	
	}	
}
