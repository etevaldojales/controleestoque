/*
AJAX feito para mÃ©todo POST.
Adaptado por Micael Vianna (micael [at] aiatola [dot] net
CÃ³digo original:
	http://www.captain.at/howto-ajax-form-post-get.php
*/

function createXMLHttpRequest() {
	/*
		Interface genÃ©rica para acesso ao conector remoto.
	*/
   try{ return new ActiveXObject("Msxml2.XMLHTTP"); }catch(e){}
   try{ return new ActiveXObject("Microsoft.XMLHTTP"); }catch(e){}
   try{ return new XMLHttpRequest(); }catch(e){}
   alert("XMLHttpRequest not supported");
   return null;
}
	// contem objeto para solicitar recursos remotos.
var xhReq;
// Envia formulario inteiro via POST
// Trata campos sem a necessidade de verificaÃ§Ã£o.
function xhSend(url,formu,funcao){
	/*
		envia a requisicao para o servidor, e tudo o que eh
		retornado eh passado a funcao do_readyStateChange
	*/
	xhReq = createXMLHttpRequest();
	var form = document.getElementById(formu);
	var form_string = get(form);
	var funcao;
	xhReq.open("post",url,true);
	xhReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	//xhReq.setRequestHeader('Content-Lenght',form_string.lenght);
	
    xhReq.onreadystatechange = funcao;
    xhReq.send(form_string);
}
/*
EXEMPLO DE FUNÃ‡ÃƒO
function do_readyStateChange(){
	/*
		se a requisicao estiver completa entao exibir o
		valor no campo de formulario com id total.
	*/
    /*
	if(xhReq.readyState!=4){return;}
	var total=document.getElementById(DIVDEDESTINO);
    total.innerHTML=xhReq.responseText;
}*/


function get(obj) {
  var getstr = "";
  for (i=0; i<obj.length; i++) {

		if (obj.elements[i].tagName == "INPUT") {
		if (obj.elements[i].type == "text" || obj.elements[i].type == "hidden" || obj.elements[i].type == "password" || obj.elements[i].type == "email" || obj.elements[i].type == "number" || obj.elements[i].type == "tel" || obj.elements[i].type == "url" || obj.elements[i].type == "date" || obj.elements[i].type == "time") {
		   getstr += obj.elements[i].name + "=" + escape(obj.elements[i].value) + "&";
		}
		if (obj.elements[i].type == "checkbox") {
		   if (obj.elements[i].checked) {
			  getstr += obj.elements[i].name + "=" + escape(obj.elements[i].value) + "&";
		   } else {
			  getstr += obj.elements[i].name + "=&";
		   }
		}
		if (obj.elements[i].type == "radio") {
		   if (obj.elements[i].checked) {
			  getstr += obj.elements[i].name + "=" + escape(obj.elements[i].value) + "&";
		   }
		}
	 }   
	 if (obj.elements[i].tagName == "SELECT") {
		var sel = obj.elements[i];
		if (sel.selectedIndex !== -1) {
			getstr += sel.name + "=" + escape(sel.options[sel.selectedIndex].value) + "&";
		} else {
			getstr += sel.name + "=&";
		}
	 }
 	if (obj.elements[i].type == "textarea") {
	   getstr += obj.elements[i].name + "=" + escape(obj.elements[i].value) + "&";
	}
  }
  return getstr;
}

// url de destino, parametros em formato get, funcao que vai executar

function include(url,parametros,div){
/*
		envia a requisicao para o servidor, e tudo o que eh
		retornado eh passado a funcao do_readyStateChange
		usar parametros no formato: variavel=texto&variavel2=texto2
	*/
//	var form = document.getElementById(formu);
//	var form_string = get(form);
//	var funcao;
	xhReq = createXMLHttpRequest();
	xhReq.open("post",url,true);
	xhReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	//xhReq.setRequestHeader('Content-Lenght',form_string.lenght);
	
    xhReq.onreadystatechange = function() {
		if(xhReq.readyState==4){ 
			var texto = unescape(xhReq.responseText.replace(/\\+/g," "));
			document.getElementById(div).innerHTML = xhReq.responseText; 
			extraiScript(texto);
		}
		if(xhReq.readyState!=4){ 
			return;
		}
	}
	xhReq.send(parametros);
}

function executar(url,parametros,funcao){
/*
		envia a requisicao para o servidor, e tudo o que eh
		retornado eh passado a funcao do_readyStateChange
		usar parametros no formato: variavel=texto&variavel2=texto2
	*/
//	var form = document.getElementById(formu);
//	var form_string = get(form);
//	var funcao;
	xhReq = createXMLHttpRequest();
	xhReq.open("post",url,true);
	xhReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	//xhReq.setRequestHeader('Content-Lenght',form_string.lenght);
	
    xhReq.onreadystatechange = funcao;
	xhReq.send(parametros);
}

//
//	exemplo de funlÃ§ao.
function adiciona() {
	if(xhReq.readyState==4){ 
		document.getElementById('centro').innerHTML = xhReq.responseText; 
	}
	if(xhReq.readyState!=4){ 
		return;
	}
}

/* MÃ¡scaras ER */
function mascarag(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mcep(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/^(\d{5})(\d)/,"$1-$2")         //Esse Ã© tÃ£o fÃ¡cil que nÃ£o merece explicaÃ§Ãµes
    return v
}
function mtel(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
    return v
}
function cnpj(v){
    v=v.replace(/\D/g,"")                           //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro dÃ­gitos
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dÃ­gitos
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono dÃ­gitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um hÃ­fen depois do bloco de quatro dÃ­gitos
    return v
}
function mcpf(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dÃ­gitos
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dÃ­gitos
                                             //de novo (para o segundo bloco de nÃºmeros)
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hÃ­fen entre o terceiro e o quarto dÃ­gitos
    return v
}
function mdata(v){
    v=v.replace(/\D/g,"");                    //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/(\d{2})(\d)/,"$1/$2");       
    v=v.replace(/(\d{2})(\d)/,"$1/$2");       
                                             
    v=v.replace(/(\d{2})(\d{2})$/,"$1$2");
    return v;
}
function mtempo(v){
    v=v.replace(/\D/g,"");                    //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/(\d{1})(\d{2})(\d{2})/,"$1:$2.$3");    
    return v;
}
function mhora(v){
    v=v.replace(/\D/g,"");                    //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/(\d{2})(\d)/,"$1h$2");       
    return v;
}
function mrg(v){
    v=v.replace(/\D/g,"");                                      //Remove tudo o que nÃ£o Ã© dÃ­gito
        v=v.replace(/(\d)(\d{7})$/,"$1.$2");    //Coloca o . antes dos Ãºltimos 3 dÃ­gitos, e antes do verificador
        v=v.replace(/(\d)(\d{4})$/,"$1.$2");    //Coloca o . antes dos Ãºltimos 3 dÃ­gitos, e antes do verificador
        v=v.replace(/(\d)(\d)$/,"$1-$2");               //Coloca o - antes do Ãºltimo dÃ­gito
    return v;
}
function mnum(v){
	var patt = /\./g;
	var result=patt.exec(v);	
	if(result == null) { 
		v=v.replace(/\D/g,"");                                      //Remove tudo o que nÃ£o Ã© dÃ­gito
	}
    return v;
}

function is_email(email)
{
	var er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
	
	if(er.exec(email))
	{
		return true;
	} else {
		return false;
	}
}

function logout() {
	customConfirm('Deseja realmente sair do Sistema?', function() {
		location.href = 'logout.php';	
	});
}

function extraiScript(texto) {
	// inicializa o inicio ><
	var ini = 0;
	// loop enquanto achar um script
	while (ini!=-1){
		// procura uma tag de script
		ini = texto.indexOf('<script', ini);
		// se encontrar
		if (ini >=0){
			// define o inicio para depois do fechamento dessa tag
			ini = texto.indexOf('>', ini) + 1;
			// procura o final do script
			var fim = texto.indexOf('</script>', ini);
			// extrai apenas o script
			codigo = texto.substring(ini,fim);
			// executa o script
			eval(codigo);
		}
	}
}

function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
	//alert(e.keyCode);
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
	if(whichCode == 46) {
	   return true;
	   //break;
	}
	if(whichCode == 8) {
	   return true;
	   //break
	}
    if (whichCode == 13) return true;
    key = String.fromCharCode(whichCode); // Valor para o cÃ³digo da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave invÃ¡lida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}

function number_format(number, decimals, dec_point, thousands_sep) {
  //  discuss at: http://phpjs.org/functions/number_format/
  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: davook
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Theriault
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Michael White (http://getsprink.com)
  // bugfixed by: Benjamin Lupton
  // bugfixed by: Allan Jensen (http://www.winternet.no)
  // bugfixed by: Howard Yeend
  // bugfixed by: Diogo Resende
  // bugfixed by: Rival
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  //  revised by: Luke Smith (http://lucassmith.name)
  //    input by: Kheang Hok Chin (http://www.distantia.ca/)
  //    input by: Jay Klehr
  //    input by: Amir Habibi (http://www.residence-mixte.com/)
  //    input by: Amirouche
  //   example 1: number_format(1234.56);
  //   returns 1: '1,235'
  //   example 2: number_format(1234.56, 2, ',', ' ');
  //   returns 2: '1 234,56'
  //   example 3: number_format(1234.5678, 2, '.', '');
  //   returns 3: '1234.57'
  //   example 4: number_format(67, 2, ',', '.');
  //   returns 4: '67,00'
  //   example 5: number_format(1000);
  //   returns 5: '1,000'
  //   example 6: number_format(67.311, 2);
  //   returns 6: '67.31'
  //   example 7: number_format(1000.55, 1);
  //   returns 7: '1,000.6'
  //   example 8: number_format(67000, 5, ',', '.');
  //   returns 8: '67.000,00000'
  //   example 9: number_format(0.9, 0);
  //   returns 9: '1'
  //  example 10: number_format('1.20', 2);
  //  returns 10: '1.20'
  //  example 11: number_format('1.20', 4);
  //  returns 11: '1.2000'
  //  example 12: number_format('1.2000', 3);
  //  returns 12: '1.200'
  //  example 13: number_format('1 000,50', 2, '.', ' ');
  //  returns 13: '100 050.00'
  //  example 14: number_format(1e-8, 8, '.', '');
  //  returns 14: '0.00000001'

  number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}
