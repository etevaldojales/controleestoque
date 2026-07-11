// JavaScript Document
var pagina;
var cdprod;
function listar(pag) {
	pagina = pag;
	include('lista_produtos_estoque.php','pagina='+pag,'lista');	
}

function exibirCotacao(id) {
	include('cotacao.php','id='+id,'myModal1');	
}

function listarCotacoes(id,pag) {
	pagina = pag;
	include('lista_cotacao.php','pagina='+pag+'&id='+id,'lista_cotacao');	
}

function pesquisar() {
	var val 	= document.getElementById('parametro').value;
	var filtro 	= document.getElementById('tipo').value;
	include('lista_produtos_estoque.php','parametro='+val+'&filtro='+filtro+'&pagina='+pagina,'lista');	
}

function pesquisarPNome(val) {
	var filtro 	= document.getElementById('tipo').value;
	if(filtro == 1) {
		include('lista_produtos_estoque.php','parametro='+val+'&filtro='+filtro+'&pagina='+pagina,'lista');	
	}
}


function validarCotacao() {
	var local = document.getElementById('local');
	var valor = document.getElementById('valor');
	var id	  = document.getElementById('id').value;
	cdprod = id;
	if(!local.value) {
		alert('Por favor insira o Local');
		return local.focus();
	}
	if(!valor.value) {
		alert('Por favor insira o Valor');
		return valor.focus();
	}
	executar('bd.insereCotacao.php','local='+local.value+'&valor='+valor.value+'&id='+id,validarCotacaoRe);
}

function validarCotacaoRe()
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
				listarCotacoes(cdprod,pag);
			}
			else {
				alert('Falha ao salvar dados');	
			}
		}
	}
}

function visualizarProduto(tags) {
	include('visualiza_produto.php','tags='+tags,'myModal1');
}

function down() {
    $('html, body').animate({ scrollTop: 2000 }, 3000);
}

function up() {
    $('html, body').animate({ scrollTop: 0 }, 2000);
}