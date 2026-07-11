/*
Funções AJAX de controle do menu Perfil.
*/
function altera() {
	if (verificatextsvazios(document.getElementById('cad')) != false) {
		if (checanumerotxt(document.getElementById('ddd').value) == true && checanumerotxt(document.getElementById('telefone').value) == true) {			
			if (document.getElementById('senha').value == document.getElementById('senha2').value) {
				xhSend('perfil/bd.altera.php','cad',alteraRetorno);
			}
			else {
				alert('Por favor confirme sua senha corretamente.');
				document.getElementById('senha2').focus();
				return false;
			}
		}
		else 
		{
			alert('Digite apenas numeros no campo Telefone');
			document.getElementById('ddd').focus();
		}
	}
}
function alteraRetorno() {
	if (xhReq.readyState==4) {
		if (xhReq.responseText == 'ok') {
			alert('Alteração realizada com sucesso.');
		}
		else {
			alert('Ocorreu um erro durante a alteração de dados. \nPor favor tente novamente mais tarde.')	
		}
	}
}