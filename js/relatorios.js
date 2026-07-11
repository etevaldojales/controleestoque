// JavaScript Document
var pagina;

function pesquisarPedidos() {
	var datai = document.getElementById('dtini').value;
	var dataf = document.getElementById('dtfim').value;
	if (!validarDatas(datai, dataf)) return;
	var fpg = document.getElementById('forma_pg').value;
	include('lista_pedidos.php','datai='+datai+'&dataf='+dataf+'&formapg='+fpg,'lista_pedidos');	
}

function pesquisarProdutos() {
	var datai = document.getElementById('datini').value;
	var dataf = document.getElementById('datfim').value;
	if (!validarDatas(datai, dataf)) return;
	include('lista_produtos_resumo.php','datai='+datai+'&dataf='+dataf,'lista_produtos');	
}

function pesquisarReceitas() {
	var datai = document.getElementById('dtini').value;
	var dataf = document.getElementById('dtfim').value;
	if (!validarDatas(datai, dataf)) return;
	document.getElementById('datai').value = datai;
	document.getElementById('dataf').value = dataf;
	include('lista_receitas.php','datai='+datai+'&dataf='+dataf,'lista_receitas');	
}

function pesquisarParcVenc() {
	var datai = document.getElementById('dtini').value;
	var dataf = document.getElementById('dtfim').value;
	if (!validarDatas(datai, dataf)) return;
	document.getElementById('datai').value = datai;
	document.getElementById('dataf').value = dataf;
	include('lista_parc_vencida.php','datai='+datai+'&dataf='+dataf,'lista_parc_venc');	
}

function pesquisarEstoqueMinimo() {
	include('lista_estoque_minimo.php','','lista_estoque');	
}

function pesquisarBaixas() {
	var datai = document.getElementById('dtini').value;
	var dataf = document.getElementById('dtfim').value;
	if (!validarDatas(datai, dataf)) return;
	document.getElementById('datai').value = datai;
	document.getElementById('dataf').value = dataf;
	include('lista_baixas.php','datai='+datai+'&dataf='+dataf,'lista_baixas');	
}

function imprimirRelatório(divId) {
    document.getElementById('btnImp').style.display = 'none';
    var divContents = document.getElementById(divId).innerHTML;
    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Imprimir Relatório</title>');
    // Optional: Include styles for printing
    printWindow.document.write('<style>body{font-family: Arial, sans-serif; margin: 20px;}<\/style>');
    printWindow.document.write('</head><body >');
    printWindow.document.write(divContents);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
        document.getElementById('btnImp').style.display = '';

}
