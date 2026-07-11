// JavaScript Document
function logout() {
	customConfirm('Deseja realmente sair do Sistema?', function() {
		location.href = 'logout.php';	
	});
}

function abrirMeusDados() {
	location.href = "dados_usuario.php";		
}