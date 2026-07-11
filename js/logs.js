// JavaScript Document
var pagina;
function pesquisarLogs(pag) {
	pagina = pag;
	var datai = document.getElementById('dtini').value;
	var dataf = document.getElementById('dtfim').value;
	if (!validarDatas(datai, dataf)) return;
	include('lista_logs.php','datai='+datai+'&dataf='+dataf+'&pagina='+pag,'lista');	
}

function paginar(pag) {
	pagina = pag;
	var datai = document.getElementById('dtini').value;
	var dataf = document.getElementById('dtfim').value;
	if (!validarDatas(datai, dataf)) return;
	include('lista_logs.php','datai='+datai+'&dataf='+dataf+'&pagina='+pag,'lista');	
}
