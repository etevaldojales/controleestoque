//função para pegar o tamanho da área útil do IE
function getPageSize() {
	var xScroll, yScroll;
	if (window.innerHeight && window.scrollMaxY){
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else {
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	var windowWidth, windowHeight;
	if (self.innerHeight) {
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) {
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) {
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}	
	if(yScroll < windowHeight) pageHeight = windowHeight;
	else pageHeight = yScroll;
	if(xScroll < windowWidth) pageWidth = windowWidth;
	else pageWidth = xScroll;
	arrayPageSize = {pageWidth:pageWidth,pageHeight:pageHeight,windowWidth:windowWidth,windowHeight:windowHeight}
	return arrayPageSize;
}

function mostrarComentarios()
{
	//mostrando elementos
	var pageSize = getPageSize();
	document.getElementById('mascara').style.height = (pageSize.pageHeight + 'px');
	document.getElementById('mascara').style.display = '';
	document.getElementById('lerComentarios').style.display = '';
	include('modulos/comentarios/comentarios.php','','lerComentarios');
}

function fecharComentarios()
{
	document.getElementById('mascara').style.display = 'none';
	document.getElementById('lerComentarios').style.display = 'none';
}

function mostrarEnviar(cod,tipo)
{
	document.getElementById('lerComentarios').style.display = 'none';
	
	//mostrando elementos
	var pageSize = getPageSize();
	document.getElementById('mascara').style.height = (pageSize.pageHeight + 'px');
	document.getElementById('mascara').style.display = '';
	document.getElementById('EnviarComentarios').style.display = '';
	include('modulos/comentarios/comentario_form.php','id_ant='+cod+'&tipo='+tipo,'EnviarComentarios');
}

function fecharEnviar()
{
	document.getElementById('mascara').style.display = 'none';
	document.getElementById('EnviarComentarios').style.display = 'none';
	mostrarComentarios();
}

function submeter() {
   var titulo = document.getElementById('titulo');	
   var desc   = document.getElementById('descricao');	
   if(!titulo.value) {
	  alert("É necessário preencher o campo Titulo");
	  return titulo.focus();
   }
   if(!desc.value) {
	  alert("É necessário preencher o campo Descrição");
	  return desc.focus();
   }
   else {
	  enviarFormComent();    
   }
}

function enviarFormComent() {
   xhSend('modulos/comentarios/envia_form.php','frmComent',enviaFormComentRe);	
}

function enviaFormComentRe() {

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
				alert("Dados cadastrados com sucesso");
				fecharEnviar();
			}
			else
			{
				alert("Falha ao cadastrar Dados");
			}
		}
		else { 
		   alert("Falha de xml"); 
		}
	}
}

function mostrarImagem(param,altura,largura)
{	
	var pageSize = getPageSize();
	document.getElementById('mascara').style.height = (pageSize.pageHeight + 'px');
	
	document.getElementById('caixa').innerHTML 		= '<img src="imagens/tema/'+param+'" height="'+altura+'" width="'+largura+'" alt="Clique na imagem para fechar"><div id="caixa_legenda">Clique na imagem para fechar</div>';
	document.getElementById('caixa').style.width 	= largura+'px';
	n_altura = parseInt(altura) + 20;
	document.getElementById('caixa').style.height 	= n_altura +'px';
	if (navigator.appName == "Microsoft Internet Explorer")
	{
		var alturaScroll = document.documentElement.scrollTop;
		diferencaIE = alturaScroll - altura/2;
		document.getElementById('caixa').style.marginLeft = -largura/2 + "px";
		document.getElementById('caixa').style.marginTop = diferencaIE + "px";
	}
	else
	{
		document.getElementById('caixa').style.margin = "-"+ altura/2 + "px 0 0 -" + largura/2 + "px";	
	}
	document.getElementById('mascara').style.display 	= '';
	document.getElementById('caixa').style.display 	= '';
}

function fecharImagem()
{
	document.getElementById('caixa').innerHTML 		= '';
	document.getElementById('mascara').style.display 	= 'none';
	document.getElementById('caixa').style.display 	= 'none';
}
