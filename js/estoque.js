// JavaScript Document
var pagina = 1;
function listar(pag) {
	pagina = pag;
	include('lista_estoque.php','pagina='+pag,'lista');	
}

function paginar(pag) {
	pagina = pag;
	var val 	= document.getElementById('parametro').value;
	include('lista_estoque.php','pagina='+pag+'&parametro='+val,'lista');	
}

function pesquisar() {
	var val 	= document.getElementById('parametro').value;
	include('lista_estoque.php','parametro='+val,'lista');	
}

function pesquisarPNome(val) {
	include('lista_estoque.php','parametro='+val,'lista');	
}


function validar() {
	var produto		= document.getElementById('produto');	
	var qtdentrada 	= document.getElementById('qtdentrada');	
	var qtdsaida 	= document.getElementById('qtdsaida');	
	var estoquemin 	= document.getElementById('estoque_minimo');	
	var qtdacum 	= document.getElementById('qtdacumulada');	
	var num_nf		= document.getElementById('num_nf');
	if(!produto.value) {
		alert('Por favor selecione o Produto');
		return produto.focus();
	}
	else if(!qtdentrada.value && !qtdsaida.value) {
		alert('Por favor insira a quantidade de entrada ou a quantidade de saída do Produto');
		return false();
	}
	else if(parseInt(qtdsaida.value) > parseInt(qtdacum.value)) {
		alert('A quantidade de saída não pode ser maior que a quantidade acumulada do produto');
		return qtdsaida.focus();
	}
	else if(!estoquemin.value || estoquemin.value == 0) {
		alert('Insira a quantidade mínima para o estoque desse Produto');
		return estoquemin.focus();
	}
	$.ajax({
		url:'bd.insereEstoque.php',
        type: "post",
        data: { 
			'produto': produto.value,
			'qtdentrada': qtdentrada.value,
			'qtdsaida': qtdsaida.value,
			'estoque_minimo': estoquemin.value,
			'qtdacumulada': qtdacum.value,
			'num_nf': num_nf.value
		},
        dataType: "json",
        success: function (r) {
            console.log(r);
			if(r == 1) {
				alert('Dados salvos com sucesso!');
				limpacampos();
				listar(pagina);
			}
			else if(r == 2) {
				alert('Estoque já cadastrado');
			}
			else {
				alert('Falha ao salvar dados');
			}

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {

            for (i in XMLHttpRequest) {
                if (i != "channel")
                    console.log(i + " : " + XMLHttpRequest[i])
            }
        }

	});
	
}

function validarRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			console.log(xhReq.responseText);
			obj = resposta.getElementsByTagName('retorno');

			// verifica o campo mensagem do XML, se for 1 � que inseriu OK, caso contr�rio, � erro.
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
			{
				//document.getElementById('load').style.display = 'none';
				alert('Dados salvos com sucesso!');
				limpacampos();
				listar(pagina);
			}
			else if(obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 2) {
				alert('Cliente j� cadastrado');
			}
			else {
				alert('Falha ao salvar dados');	
			}
		}
	}
}

function limpacampos() {
	document.getElementById('frmEstoque').reset();
}

function veirificarEstoque(cod) {
	executar('verificar_estoque.php','id='+cod,veirificarEstoqueRe);	
}

function veirificarEstoqueRe()
{
	if (xhReq.readyState == 4)
	{
		//console.log(xhReq.responseText);
		resposta = xhReq.responseXML;
		if (resposta)
		{
			obj = resposta.getElementsByTagName('dados');
			if (obj.length >= 1)
			{
				/* Vari�veis do Formul�rio */
				var qtd			= document.getElementById('qtdacumulada');
				var estmin		= document.getElementById('estoque_minimo');
				var Xqtd		= obj[0].getElementsByTagName('qtd')[0].firstChild;
				var Xestmin		= obj[0].getElementsByTagName('estmin')[0].firstChild;
				qtd.value 		= (Xqtd != null?unescape(Xqtd.nodeValue):'');
				estmin.value	= (Xestmin != null?unescape(Xestmin.nodeValue):'');
			}
			else { alert('Falha'); }
		}
		else { 
		alert('Falha de xml'); 
		}
	}
}
