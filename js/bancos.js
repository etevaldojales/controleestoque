// JavaScript Document
function validar() {
	xhSend('bd.alteraBanco.php','frmBanco',validarRe);
	
}

function validarRe()
{
	if (xhReq.readyState == 4)
	{
		if (xhReq.responseText != '')
		{
			resposta = xhReq.responseXML;
			obj = resposta.getElementsByTagName('retorno');
			// verifica o campo mensagem do XML, se for 1 é que inseriu OK, caso contrário, é erro.
			if (obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1)
			{
				alert('Dados salvos com sucesso!');
				location.href = 'bancos.php';
			}
			else {
				alert('Falha ao salvar dados');	
			}
		}
	}
}

