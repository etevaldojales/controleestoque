document.addEventListener("DOMContentLoaded", function () {
  var pesoInput = document.getElementById("peso");
  var qtdInput = document.getElementById("qtd");
  var codigoInput = document.getElementById("codigo");

  if (pesoInput) {
    pesoInput.addEventListener("keydown", function (event) {
      if (event.key === "Enter" || event.keyCode === 13) {
        event.preventDefault();
        adicionarItemPdvByRef();
      }
    });
  }

  if (qtdInput) {
    qtdInput.addEventListener("keydown", function (event) {
      if (event.key === "Enter" || event.keyCode === 13) {
        event.preventDefault();
        adicionarItemPdvByRef();
      }
    });
  }

  if (codigoInput) {
    codigoInput.addEventListener("keydown", function (event) {
      if (event.key === "Enter" || event.keyCode === 13) {
        event.preventDefault();
        getProdutoRef(codigoInput.value);
      }
    });
  }
});

// JavaScript Document
var pagina;
var id;
var valorc;
var qtd;
var valor;
var codpedido = 0;
var formpg = 1;
var numparc = 1;
var pvenc = "";
var obs = "";
var total = 0;

function listar(pag) {
  pagina = pag;
  include("lista_produtos_venda.php", "pagina=" + pag, "lista");
}

function paginar(pag) {
  pagina = pag;
  include("lista_produtos_venda.php", "pagina=" + pag, "lista");
}

function pesquisar() {
  var val = document.getElementById("parametro").value;
  var filtro = document.getElementById("filtro").value;
  include(
    "lista_produtos_venda.php",
    "parametro=" + val + "&filtro=" + filtro,
    "lista"
  );
}

function exibirComplementoPg() {
  if (document.getElementById("formpag4").checked == true) {
    document.getElementById("complemento_pg").style.display = "";
    document.getElementById("cliente_credito").value = "";
  } else {
    document.getElementById("cliente").value = 5;
    document.getElementById("complemento_pg").style.display = "none";
  }
}

function pesquisarPNome(val) {
  var filtro = 1;
  include(
    "lista_produtos_venda.php",
    "parametro=" + val + "&filtro=" + filtro,
    "lista"
  );
}

function carregarItens() {
  var cli = document.getElementById("cliente").value;
  if (!cli) {
    alert("Selecione um cliente");
    up();
    return document.getElementById("cliente").focus();
  }
  //down();
  includePost("itens_pedido.php", "idcliente=" + cli, "itens");
}

async function exibirCarrinho() {
  var cli = document.getElementById("cliente").value;
  if (!cli) {
    alert("Selecione um cliente");
    up();
    return document.getElementById("cliente").focus();
  }
  down();
  include("itens_pedido.php", "idcliente=" + cli, "itens");
}

function includePost(url, data, elementId) {
  $.ajax({
    url: url,
    type: "POST",
    data: data,
    success: function (response) {
      $("#" + elementId).html(response);
    },
    error: function (xhr, status, error) {
      alert("Erro ao carregar dados: " + error);
    },
  });
}

function carregarItensPdv() {
  var cli = document.getElementById("cliente").value;
  //down();
  includePost("itens_pedido_pdv.php", "idcliente=" + cli, "itens");
  //$("#itens").html();
}

function excluirItem(id) {
  customConfirm("Deseja realmente excluir esse item?", function() {
    executar("bd.excluiItem.php", "id=" + id, excluirItemRe);
  });
}

function down() {
  $("html, body").animate({ scrollTop: 2000 }, 3000);
}

function up() {
  $("html, body").animate({ scrollTop: 0 }, 2000);
}

function excluirItemPdv(id) {
  customConfirm("Deseja realmente excluir esse item?", function() {
    $.ajax({
      url: "bd.excluiItem.php",
      type: "POST",
      data: { id: id },
      dataType: "json",
      success: function (response) {
        //alert("Item excluÃ­do com sucesso!");
        //window.reload();
        carregarItensPdv();
      },
      error: function (xhr, status, error) {
        alert("Houve um erro ao excluir item");
      },
    });
  });
}

function excluirItemRe(response) {
  if (response && response.retorno == 1) {
    carregarItens();
  } else {
    alert("Houve um erro ao excluir item");
  }
}

function adicionarItemPdv(idproduto) {
  var cli = document.getElementById("cliente").value;
  if (!cli) {
    alert("Seelecione o Cliente");
    return false;
  } else {
    executar(
      "adicionar_item.php",
      "idcliente=" + cli + "&idproduto=" + idproduto,
      adicionarItemPdvRe
    );
  }
}

function adicionarItemPdvRe() {
  if (xhReq.readyState == 4) {
    //console.log(xhReq.responseText);
    if (xhReq.responseText != "") {
      resposta = xhReq.responseXML;
      obj = resposta.getElementsByTagName("retorno");

      // verifica o campo mensagem do XML, se for 1 ï¿½ que inseriu OK, caso contrï¿½rio, ï¿½ erro.
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1
      ) {
        //alert('item incluido com sucesso!');
        $(".chzn-select").chosen();
        $("#produto").val("");
        $("#produto").focus();
        $("#produto").trigger("liszt:updated");
        carregarItensPdv();
      } else if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 2
      ) {
        alert("Item jÃ¡ cadastrado nesse pedido");
      } else {
        alert("Falha ao cadastrar item");
      }
    }
  }
}

function applyIntegerMask(inputElement) {
  // Allow only digits on keypress
  inputElement.off("keypress"); // Remove previous keypress handlers to avoid duplicates
  inputElement.on("keypress", function (event) {
    var charCode = event.which ? event.which : event.keyCode;
    // Allow control keys (backspace, delete, arrows)
    if (
      charCode == 8 || // backspace
      charCode == 46 || // delete
      (charCode >= 37 && charCode <= 40) // arrow keys
    ) {
      return true;
    }
    // Allow digits only
    if (charCode < 48 || charCode > 57) {
      event.preventDefault();
      return false;
    }
    return true;
  });
}

function applyWeightMask(inputElement) {
  // Allow numbers with up to 3 decimals on keypress, using comma or dot
  inputElement.off("keypress"); // Remove previous keypress handlers to avoid duplicates
  inputElement.on("keypress", function (event) {
    var charCode = event.which ? event.which : event.keyCode;
    var val = this.value;
    // Allow control keys (backspace, delete, arrows)
    if (
      charCode == 8 || // backspace
      charCode == 46 || // delete
      (charCode >= 37 && charCode <= 40) // arrow keys
    ) {
      return true;
    }
    var charStr = String.fromCharCode(charCode);
    // Allow digits
    if (charStr.match(/[0-9]/)) {
      // Check if decimal places limit reached
      var parts = val.split(/[.,]/);
      if (parts.length == 2 && parts[1].length >= 3) {
        event.preventDefault();
        return false;
      }
      return true;
    }
    // Allow one comma or dot as decimal separator
    if (
      (charStr == "." || charStr == ",") &&
      val.indexOf(".") == -1 &&
      val.indexOf(",") == -1
    ) {
      return true;
    }
    event.preventDefault();
    return false;
  });
}

function getProdutoRef(ref) {
  var cli = document.getElementById("cliente").value;
  if (!cli) {
    alert("Seelecione o Cliente");
    return false;
  } else {
    $.ajax({
      url: "get_produto_ref.php",
      type: "post",
      dataType: "json",
      data: {
        idcliente: cli,
        codigo: ref,
      },
      success: function (r) {
        console.log(r);
        if (r && r.id) {
          if (
            r.qtdacumulado == null ||
            r.qtdacumulado == undefined ||
            r.qtdacumulado == 0
          ) {
            showEstoqueRapidoModal(ref, r.id);
            return;
          }

          var unidade = r.unidade == 1 ? "Valor unitÃ¡rio:" : "Valor Kg:";

          $("#desc_produto").text(r.nome.toUpperCase());
          $("#vr_unitario").val(r.valor);

          document.getElementById("img_produto").src = r.imagem
            ? "uploads/produtos/" + r.imagem
            : "img/no_produto.png";
          var imgProduto = document.getElementById("img_produto");
          imgProduto.style.width = "264px";
          imgProduto.style.height = "234px";

          if (r.unidade == 1) {
            $("#qtd").attr("placeholder", "Qtd");
            $("#qtd").show();
            $("#qtd").focus();
            $("#peso").hide();
            $("#peso").val();
          } else {
            $("#qtd").hide(); 
            $("#peso").show();
            $("#peso").attr("placeholder", "Peso (kg)");
            $("#peso").focus();
            $("#peso").attr("readonly", false);
            $("#qtd").val("");
          }

          $("#valor_unitario").val(unidade + " " + r.valor);
          $("#qtd_estoque").val("Estoque: " + r.qtdacumulado);
        } else {
          alert("Produto nÃ£o encontrado");
          setTimeout(function () {
            showProdutoRapidoModal(ref);
          }, 4400);
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        for (i in XMLHttpRequest) {
          if (i != "channel") console.log(i + " : " + XMLHttpRequest[i]);
        }
      },
    });
  }
}

function getProdutoId(id) {
  var cli = document.getElementById("cliente").value;
  if (!cli) {
    alert("Seelecione o Cliente");
    return false;
  } else {
    $.ajax({
      url: "get_produto_id.php",
      type: "post",
      dataType: "json",
      data: {
        idcliente: cli,
        id: id,
      },
      success: function (r) {
        //console.log(r);
        if (r != null) {
          if (r.id) {
            if (r.qtdacumulado == 0 || r.qtdacumulado == null || r.qtdacumulado == undefined) {
              showEstoqueRapidoModal(r.codigo, r.id);
              return;
            }
            var unidade = r.unidade == 1 ? "Valor unitÃ¡rio:" : "Valor Kg:";

            $("#desc_produto").text(r.nome.toUpperCase());
            $("#codigo").val(r.codigo);
            $("#vr_unitario").val(r.valor);
            document.getElementById("img_produto").src = r.imagem
              ? "uploads/produtos/" + r.imagem
              : "img/no_produto.png";
            var imgProduto = document.getElementById("img_produto");
            imgProduto.style.width = "264px";
            imgProduto.style.height = "234px";

            if (r.unidade == 1) {
              $("#qtd").attr("placeholder", "Qtd");
              $("#qtd").show();
              $("#qtd").focus();
              $("#peso").hide();
              $("#peso").val();
            } else {
              $("#qtd").hide();
              $("#peso").show();
              $("#peso").attr("placeholder", "Peso (kg)");
              $("#peso").focus();
              $("#peso").attr("readonly", false);
              $("#qtd").val("");
            }

            $("#valor_unitario").val(unidade + " " + r.valor);
            $("#qtd_estoque").val("Estoque: " + r.qtdacumulado);
          } else {
            alert("Produto nÃ£o encontrado");
          }
        } else {
          alert("Falha ao buscar produto");
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        for (i in XMLHttpRequest) {
          if (i != "channel") console.log(i + " : " + XMLHttpRequest[i]);
        }
      },
    });
  }
}

function adicionarItemPdvByRef() {
  var ref = $("#codigo").val().trim();
  var cli = $("#cliente").val().trim();
  var peso = $("#peso").val().trim();
  var qtd = $("#qtd").val().trim();
  var valor_unitario = parseFloat(
    $("#vr_unitario").val().trim().replace(",", ".")
  );
  var qtd_peso;

  if (qtd == "" && peso == "") {
    alert("Por favor informe a quantidade ou peso do produto");
    return false;
  } else {
    if (qtd != "") {
      qtd = parseFloat(qtd.replace(",", "."));
      qtd_peso = qtd;
    }
    if (peso != "") {
      peso = parseFloat(peso.replace(",", "."));
      qtd_peso = peso;
    }
  }
  if (!cli) {
    alert("Seelecione o Cliente");
    return false;
  } else {
    $.ajax({
      url: "adicionar_item_ref.php",
      type: "post",
      dataType: "json",
      data: {
        idcliente: cli,
        codigo: ref,
        peso: peso,
        qtd: qtd,
      },
      success: function (r) {
        console.log(r);
        if (r == 1) {
          limparCampos();
          carregarItensPdv();
        } else if (r == 2) {
          alert("Item jÃ¡ cadastrado nesse pedido");
        } else {
          alert("Falha ao cadastrar item");
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        for (i in XMLHttpRequest) {
          if (i != "channel") console.log(i + " : " + XMLHttpRequest[i]);
        }
      },
    });
  }
}

function limparCampos() {
  $("#codigo").val("");
  $("#peso").val("");
  $("#qtd").val("");
  $("#qtd_estoque").val("");
  $("#valor_unitario").val("");
  $("#codigo").focus();
  $("#desc_produto").text("");
  document.getElementById("img_produto").src = "img/no_produto.png";
}

function adicionarItem(idproduto) {
  var cli = document.getElementById("cliente").value;
  if (!cli) {
    alert("Selecione o Cliente");
    return false;
  } else {
    executar(
      "adicionar_item.php",
      "idcliente=" + cli + "&idproduto=" + idproduto,
      adicionarItemRe
    );
  }
}

function adicionarItemRe() {
  if (xhReq.readyState == 4) {
    //console.log(xhReq.responseText);
    if (xhReq.responseText != "") {
      resposta = xhReq.responseXML;
      obj = resposta.getElementsByTagName("retorno");

      // verifica o campo mensagem do XML, se for 1 ï¿½ que inseriu OK, caso contrï¿½rio, ï¿½ erro.
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1
      ) {
        alert("item incluido com sucesso!");
        carregarItens();
      } else if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 2
      ) {
        alert("Item jÃ¡ cadastrado nesse pedido");
      } else {
        alert("Falha ao cadastrar item");
      }
    }
  }
}

function capturarQtd(event, iditem, qtd) {
  var keynum;
  if (window.event) {
    //IE
    keynum = event.keyCode;
  } else if (event.which) {
    // Netscape/Firefox/Opera AQUI ESTAVA O PEQUENINO ERRO ao inves de "e." Ã© "event."
    keynum = event.which;
  }
  if (keynum == 13) {
    // 13 Ã© o codigo do Enter --> AQUI TAMBEM
    alterarQuantidadeItem(iditem, qtd);
  }
}

function capturarQtdPdv(event, iditem, qtd, und) {
  var keynum;
  if (window.event) {
    //IE
    keynum = event.keyCode;
  } else if (event.which) {
    // Netscape/Firefox/Opera AQUI ESTAVA O PEQUENINO ERRO ao inves de "e." Ã© "event."
    keynum = event.which;
  }
  if (keynum == 13) {
    // 13 Ã© o codigo do Enter --> AQUI TAMBEM
    alterarQuantidadeItemPdv(iditem, qtd, und);
  }
}

function alterarQuantidadeItemPdv(iditem, qtd, und) {
  executar(
    "alterarQuantidade.php",
    "iditem=" + iditem + "&quantidade=" + qtd + "&unidade=" + und,
    alterarQuantidadeItemPdvRe
  );
}

function alterarQuantidadeItemPdvRe() {
  if (xhReq.readyState == 4) {
    if (xhReq.responseText != "") {
      console.log("rettorno: " + xhReq.responseText);
      resposta = xhReq.responseXML;
      obj = resposta.getElementsByTagName("retorno");

      // verifica o campo mensagem do XML, se for 1 ï¿½ que inseriu OK, caso contrï¿½rio, ï¿½ erro.
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1
      ) {
        carregarItensPdv();
      } else {
        alert("Falha ao alterar quantidade");
      }
    }
  }
}

function alterarQuantidadeItem(iditem, qtd) {
  executar(
    "alterarQuantidade.php",
    "iditem=" + iditem + "&quantidade=" + qtd,
    alterarQuantidadeItemRe
  );
}

function alterarQuantidadeItemRe() {
  if (xhReq.readyState == 4) {
    //console.log('Retorno: Etevaldo' + xhReq.responseText);
    if (xhReq.responseText != "") {
      resposta = xhReq.responseXML;
      obj = resposta.getElementsByTagName("retorno");

      // verifica o campo mensagem do XML, se for 1 ï¿½ que inseriu OK, caso contrï¿½rio, ï¿½ erro.
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1
      ) {
        carregarItens();
      } else {
        alert("Falha ao alterar quantidade");
      }
    }
  }
}

function capturarIpi(event, iditem, ipi) {
  var keynum;
  if (window.event) {
    //IE
    keynum = event.keyCode;
  } else if (event.which) {
    // Netscape/Firefox/Opera AQUI ESTAVA O PEQUENINO ERRO ao invï¿½s de "e." ï¿½ "event."
    keynum = event.which;
  }
  if (keynum == 13) {
    // 13 ï¿½ o cï¿½digo do Enter --> AQUI TAMBEM
    alterarIpiItem(iditem, ipi);
  }
}

function alterarIpiItem(iditem, ipi) {
  executar(
    "alterarIpiItem.php",
    "iditem=" + iditem + "&ipi=" + ipi,
    alterarIpiItemRe
  );
}

function alterarIpiItemRe() {
  if (xhReq.readyState == 4) {
    if (xhReq.responseText != "") {
      resposta = xhReq.responseXML;
      obj = resposta.getElementsByTagName("retorno");

      // verifica o campo mensagem do XML, se for 1 ï¿½ que inseriu OK, caso contrï¿½rio, ï¿½ erro.
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1
      ) {
        carregarItens();
      } else {
        alert("Falha ao alterar ipi");
      }
    }
  }
}

function concluirPedido(id, valor, valorc, valorv) {
  var obs = document.getElementById("obs").value;
  var data = document.getElementById("data").value;
  executar(
    "concluirPedido.php",
    "id=" +
      id +
      "&observacao=" +
      obs +
      "&valor=" +
      valor +
      "&valorcusto=" +
      valorc +
      "&valorvenda=" +
      valorv +
      "&data=" +
      data,
    concluirPedidoRe
  );
}

function concluirPedidoRe() {
  if (xhReq.readyState == 4) {
    if (xhReq.responseText != "") {
      resposta = xhReq.responseXML;
      console.log(xhReq.responseText);
      obj = resposta.getElementsByTagName("retorno");

      // verifica o campo mensagem do XML, se for 1 ï¿½ que inseriu OK, caso contrï¿½rio, ï¿½ erro.
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1
      ) {
        alert("Pedido concluÃ­do com sucesso!");
        //location.href = 'vendas.php';
        location.href = "formapagamento.php";
      } else {
        alert("Falha ao concluir opedido");
      }
    }
  }
}

function concluirPedidoPdv(id, valor, valorc, valorv) {
  codpedido = id;
  if (document.getElementById("formpag1").checked == true) {
    formpg = 1;
  } else if (document.getElementById("formpag2").checked == true) {
    formpg = 2;
  } else if (document.getElementById("formpag3").checked == true) {
    formpg = 3;
  } else if (document.getElementById("formpag4").checked == true) {
    formpg = 4;
  }
  numparc = document.getElementById("numparc").value;
  pvenc = document.getElementById("primvenc").value;
  obs = document.getElementById("obs").value;
  var data = document.getElementById("data").value;

  $.ajax({
    url: "concluirPedidoPdv.php",
    type: "POST",
    dataType: "json",
    data: {
      id: id,
      observacao: obs,
      valor: valor,
      valorcusto: valorc,
      valorvenda: valorv,
      data: data,
      formpag: formpg,
    },
    success: function (response) {
      console.log(response);
      if (response == 1) {
        alert("Pedido concluÃ­do com sucesso!");
        document.getElementById("frmimpressao").src = "impressao.php";
        // Call NFe generation and sending after order conclusion
        //gerarEnviarNfe(id);
      } else {
        alert("Falha ao concluir o pedido");
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      for (i in XMLHttpRequest) {
        if (i != "channel") console.log(i + " : " + XMLHttpRequest[i]);
      }
    },
  });
}

function gerarEnviarNfe(orderId) {
  $.ajax({
    url: "gerar_enviar_nfe.php",
    type: "POST",
    dataType: "json",
    data: { id: orderId },
    success: function (response) {
      if (response.success) {
        alert("NFe: " + response.message);
      } else {
        alert("Erro ao gerar/enviar NFe: " + response.message);
      }
    },
    error: function (xhr, status, error) {
      alert("Erro na requisiÃ§Ã£o NFe: " + error);
    },
  });
}

function validar() {
  var formpg = document.getElementById("formpag").value;
  var numparc = document.getElementById("numparc").value;
  var pvenc = document.getElementById("primvenc").value;
  if (!formpg) {
    alert("Por favor selecione a forma de pagamento do pedido");
    return document.getElementById("formpag").focus();
  } else if (!numparc) {
    alert("Por favor selecione o numero de parcelas do pedido");
    return document.getElementById("numparc").focus();
  } else if (pvenc == "") {
    alert("Por favor seelecione a data do primeiro vencimento do pedido");
    return document.getElementById("primvenc").focus();
  }
  document.getElementById("btnCad").style.display = "none";
  document.getElementById("btnEtrada").style.display = "none";
  xhSend("concluir_pedido.php", "frmFormPag", validarRe);
}

function validarRe() {
  if (xhReq.readyState == 4) {
    retorno = xhReq.responseXML;
    // se o retorno for um XML, entï¿½o comeï¿½a a agir.
    if (retorno != null) {
      obj = retorno.getElementsByTagName("retorno");
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == "1"
      ) {
        alert("Operacao realizada com sucesso!");
        exibirBaixasCadastro(
          obj[0].getElementsByTagName("codpedido")[0].firstChild.nodeValue
        );
      } else {
        alert("Falha ao inserir dados");
      }
    } else {
      alert("Falha ao inserir dados");
    }
  }
}

function exibirFormEntrada(cdpedido) {
  include("form_entrada.php", "codigo=" + cdpedido, "myModal1");
}

function validarEntrada() {
  var formpg = document.getElementById("formpgentrada");
  var datapg = document.getElementById("dtentrada");
  var valpg = document.getElementById("valor_entrada");
  var valrec = document.getElementById("recibo_entrada");
  var codigo = document.getElementById("codpedido").value;
  if (!formpg.value) {
    alert("Por favor selecione a Forma de Pagamento da Entrada");
    return formpg.focus();
  }
  if (!datapg.value) {
    alert("Por favor informe a data do pagamento da Entrada");
    return datapg.focus();
  }
  if (!valpg.value) {
    alert("Por favor informe o valor da Entrada");
    return valpg.focus();
  }
  executar(
    "insereEntrada.php",
    "formpgentrada=" +
      formpg.value +
      "&dtentrada=" +
      datapg.value +
      "&valor_entrada=" +
      valpg.value +
      "&recibo=" +
      valrec.value +
      "&codigo=" +
      codigo,
    validarEntradaRe
  );
}

function validarEntradaRe() {
  if (xhReq.readyState == 4) {
    resposta = xhReq.responseXML;
    if (resposta) {
      obj = resposta.getElementsByTagName("dados");
      if (obj.length >= "1") {
        var Xentrada = obj[0].getElementsByTagName("entrada")[0].firstChild;
        var Xtotal = obj[0].getElementsByTagName("total")[0].firstChild;
        var Xstotal = obj[0].getElementsByTagName("subtotal")[0].firstChild;
        alert("Entrada cadastrada com sucesso!");
        document.getElementById("btnCloseModal").click();
        //setTotal(Xtotal.nodeValue,Xstotal.nodeValue,Xcredito.nodeValue,Xentrada.nodeValue);
      } else {
        alert("Falha");
      }
    } else {
      alert("Falha");
    }
  }
}

function exibirBaixasCadastro(id) {
  document.getElementById("parcelas").style.display = "";
  include("baixa_cadastro.php", "id=" + id, "parcelas");
}

function imprimirBoleto(id, numparc) {
  numeroparcela = numparc;
  executar("config_boleto.php", "id=" + id, imprimirBoletoRe);
}

function imprimirBoletoRe() {
  if (xhReq.readyState == 4) {
    retorno = xhReq.responseXML;
    // se o retorno for um XML, entï¿½o comeï¿½a a agir.
    if (retorno != null) {
      obj = retorno.getElementsByTagName("retorno");
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == "1"
      ) {
        window.open(
          "boleto/boleto.php?numparc=" + numeroparcela,
          "boleto",
          "toolbar=no, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=710, height=800"
        );
      }
    }
  }
}

function baixarParcela(id, valrec, recibo, forma, numparc) {
  nparc = numparc;
  cdparcela = id;
  if (!forma) {
    alert("Por favor selecione a forma de pagamento da parcela");
    return false;
  }
  if (!valrec) {
    alert("Por favor insira o valor recebido da parcela");
    return false;
  }
  executar(
    "bd.baixa.php",
    "id=" +
      id +
      "&valor=" +
      valrec +
      "&recibo=" +
      recibo +
      "&formapag=" +
      forma,
    baixarParcelaRe
  );
}

function baixarParcelaRe() {
  if (xhReq.readyState == 4) {
    retorno = xhReq.responseXML;
    // se o retorno for um XML, entï¿½o comeï¿½a a agir.
    if (retorno != null) {
      obj = retorno.getElementsByTagName("retorno");
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == "1"
      ) {
        alert("Operacao realizada com sucesso!");
        //location.href = modulocont+'contratos.php';
        exibirBaixas(
          obj[0].getElementsByTagName("pedido")[0].firstChild.nodeValue
        );
        //setTimeout('imprimirRecibo()',500);
      } else {
        alert("Falha ao inserir dados");
      }
    } else {
      alert("Falha ao inserir dados");
    }
  }
}

function exibirBaixas(id) {
  include("baixa.php", "id=" + id, "parcelas");
}

function imprimirRecibo() {
  customConfirm("Deseja imprimir o Recibo?", function() {
    var url = "recibopdf.php?codigo=" + cdparcela + "&numero_parcela=" + nparc;
    window.open(url, "_blank");
  });
}

function baixarEntrada(id, valrec, recibo, forma) {
  if (!forma) {
    alert("Por favor selecione a forma de pagamento da entrada");
    return false;
  }
  if (!valrec) {
    alert("Por favor insira o valor recebido da entrada");
    return false;
  }
  executar(
    "bd.baixa_entrada.php",
    "id=" +
      id +
      "&valor=" +
      valrec +
      "&recibo=" +
      recibo +
      "&formapag=" +
      forma,
    baixarEntradaRe
  );
}

function baixarEntradaRe() {
  if (xhReq.readyState == 4) {
    retorno = xhReq.responseXML;
    // se o retorno for um XML, entï¿½o comeï¿½a a agir.
    if (retorno != null) {
      obj = retorno.getElementsByTagName("retorno");
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == "1"
      ) {
        alert("Operacao realizada com sucesso!");
        //location.href = modulocont+'contratos.php';
        exibirBaixas(
          obj[0].getElementsByTagName("pedido")[0].firstChild.nodeValue
        );
      } else {
        alert("Falha ao inserir dados");
      }
    } else {
      alert("Falha ao inserir dados");
    }
  }
}

function excluirParcela(id) {
  customConfirm("deseja realmente excluir essa Parcela?", function() {
    executar("exclui_parcela.php", "id=" + id, excluirParcelaRe);
  });
}

function excluirParcelaRe() {
  if (xhReq.readyState == 4) {
    retorno = xhReq.responseXML;
    // se o retorno for um XML, entï¿½o comeï¿½a a agir.
    if (retorno != null) {
      obj = retorno.getElementsByTagName("retorno");
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == "1"
      ) {
        alert("Parcela excluida com sucesso!");
        //location.href = modulocont+'contratos.php';
        exibirBaixas(
          obj[0].getElementsByTagName("pedido")[0].firstChild.nodeValue
        );
      } else {
        alert("Falha ao excluir dados");
      }
    } else {
      alert("Falha ao excluir dados");
    }
  }
}

function estornarParcela(id) {
  include("estornoparcela.php", "id=" + id, "myModal1");
}

function validarEstorno(id) {
  var data = document.getElementById("dtvenc");
  if (!data.value) {
    alert("Por favor preencha o campo Data de Vencimento");
    return data.focus();
  }
  executar(
    "processaestornoparcela.php",
    "id=" + id + "&data=" + data.value,
    validarEstornoRe
  );
}

function validarEstornoRe() {
  if (xhReq.readyState == 4) {
    resposta = xhReq.responseXML;
    if (resposta) {
      obj = resposta.getElementsByTagName("dados");
      if (obj.length >= "1") {
        var Xmensagem = obj[0].getElementsByTagName("mensagem")[0].firstChild;
        var Xid = obj[0].getElementsByTagName("id")[0].firstChild;
        if (Xmensagem.nodeValue == 1) {
          alert("Estorno da parcela realizado com sucesso!");
          document.getElementById("btnCloseModal").click();
          exibirBaixas(Xid.nodeValue);
        } else {
          alert("Falha ao realizar Estorno!");
        }
      } else {
        alert("Falha");
      }
    } else {
      alert("Falha");
    }
  }
}

function finalizarPedido() {
  location.href = "vendas.php";
}

function alterarValorVendaPdv(idItem, valorcItem, qtdItem, valorItem) {
  executar(
    "alterarValorVenda.php",
    "id=" +
      idItem +
      "&valor=" +
      valorItem +
      "&valor_compra=" +
      valorcItem +
      "&quantidade=" +
      qtdItem,
    alterarValorVendaPdvRe
  );
}

function alterarValorVendaPdv() {
  if (xhReq.readyState == 4) {
    if (xhReq.responseText != "") {
      resposta = xhReq.responseXML;
      obj = resposta.getElementsByTagName("retorno");
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1
      ) {
        alert("Valor alterado com sucesso!");
        if (document.getElementById("btnCloseModal")) {
          document.getElementById("btnCloseModal").click();
        }
        carregarItensPdv();
      } else if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 2
      ) {
        alert(
          "O valor de venda nï¿½o pode ser menor ou igual ao valor de compra"
        );
        if (document.getElementById("btnCloseModal")) {
          document.getElementById("btnCloseModal").click();
        }
        carregarItensPdv();
      } else {
        alert("Falha ao alterar valor");
      }
    }
  }
}

function alterarValorVenda(idItem, valorcItem, qtdItem, valorItem) {
  executar(
    "alterarValorVenda.php",
    "id=" +
      idItem +
      "&valor=" +
      valorItem +
      "&valor_compra=" +
      valorcItem +
      "&quantidade=" +
      qtdItem,
    alterarValorVendaRe
  );
}

function alterarValorVendaRe() {
  if (xhReq.readyState == 4) {
    if (xhReq.responseText != "") {
      resposta = xhReq.responseXML;
      obj = resposta.getElementsByTagName("retorno");
      if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 1
      ) {
        alert("Valor alterado com sucesso!");
        if (document.getElementById("btnCloseModal")) {
          document.getElementById("btnCloseModal").click();
        }
        carregarItens();
      } else if (
        obj[0].getElementsByTagName("mensagem")[0].firstChild.nodeValue == 2
      ) {
        alert(
          "O valor de venda nï¿½o pode ser menor ou igual ao valor de compra"
        );
        if (document.getElementById("btnCloseModal")) {
          document.getElementById("btnCloseModal").click();
        }
        carregarItens();
      } else {
        alert("Falha ao alterar valor");
      }
    }
  }
}

function showCalculadora(idItem, valorcItem, qtdItem, valorItem) {
  this.id = idItem;
  this.valorc = valorcItem;
  this.qtd = qtdItem;
  this.valor = valorItem;
  include("calculadora_itens.php", "valor=" + valorItem, "myModal1");
}

function calcular() {
  var perc = document.getElementById("percentual");
  var valorc = this.valor;
  var opcao = document.getElementById("opc1").checked == true ? 1 : 2; // 1 - Acrescimo; 2 - Desconto
  if (!perc.value) {
    alert("Preencha o campo Percentual");
    return document.getElementById("percentual").focus();
  }
  executar(
    "calcular.php",
    "valor=" + valorc + "&percentual=" + perc.value + "&opcao=" + opcao,
    calcularRe
  );
}

function calcularRe() {
  if (xhReq.readyState == 4) {
    resposta = xhReq.responseXML;
    if (resposta) {
      obj = resposta.getElementsByTagName("dados");
      if (obj.length >= 1) {
        /* Variï¿½veis do Formulï¿½rio */
        var nvalor;
        var Xvalor = obj[0].getElementsByTagName("valor")[0].firstChild;
        nvalor = Xvalor != null ? unescape(Xvalor.nodeValue) : "";
        alterarValorVenda(id, valorc, qtd, nvalor);
      } else {
        alert("Falha ao calcular");
      }
    } else {
      alert("Falha de xml");
    }
  }
}

function maskPeso() {
  $(".qtdi").mask("#0.000", { reverse: true });
}

function mascara_peso(p) {
  var v = p.value;
  integer = v.split(".")[0];
  v = v.replace(/\D/, "");
  v = v.replace(/^[0]+/, "");

  if (v.length <= 3 || !integer) {
    if (v.length === 1) v = "0.00" + v;
    if (v.length === 2) v = "0.0" + v;
    if (v.length === 3) v = "0." + v;
  } else {
    v = v.replace(/^(\d{1,})(\d{3})$/, "$1.$2");
  }

  p.value = v;
}

async function redirecionar() {
  window.location.href = "pdv.php";
}

async function comprar() {
  up();
  document.getElementById("itens").innerHTML = "";
}

async function showQrcode() {
  $("#myModal1").css({ "width": "450px", "margin-left": "-130px" });
  document.getElementById("formpag3").checked = true;
  document.getElementById("myModal1").innerHTML = "";
  include("show_qrcode.php", "", "myModal1");
}

function calculadora() {
  $("#myModal1").css({ "width": "450px", "margin-left": "-130px" });
  document.getElementById("formpag1").checked = true;
  document.getElementById("myModal1").innerHTML = "";

  total = parseFloat(document.getElementById("totalPedido").value);
  var cont = "";
  cont += "<div class='modal-header'>";
  cont +=
    "    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>Ã—</button>";
  cont += "    <h3 id='myModalLabel1'>Calculadora</h3>";
  cont += "    </div>";
  cont += "    <div class='modal-body'>";
  cont += "    <p>";
  cont += "    <table width='1231' class='table table-bordered table-hover'>";
  cont += "        <tr>";
  cont +=
    "            <td colspan='2' align='left' style='font-size: 1.5rem'><b>Valor de Compra: " +
    number_format(total, 2, ",", ".") +
    "</b></td>";
  cont += "        </tr>";
  cont += "        <tr>";
  cont += "            <td align='left' colspan='2' style='font-size: 1.5rem'>";
  cont +=
    "            	<b>Valor recebido:</b> <input type='text' name='valor_rec' id='valor_rec' style='text-align:right; font-size: 1.5rem; width: 130px' ";
  cont +=
    "                onKeyPress=return(MascaraMoeda(this,'.',',',event)) onblur='calcularTroco()'>";
  cont += "            </td>";
  cont += "        </tr>";
  cont += "        <tr>";
  cont += "            <td id='troco' style='font-size: 1.5rem'>";
  cont += "            </td>";
  cont += "        </tr>";
  cont += "    </table>";
  cont += "    <div class='modal-footer'>";
  cont +=
    "      <button class='btn' data-dismiss='modal' aria-hidden='true' id='btnCloseModal'>Fechar</button>";
  cont += "	</div>";
  cont += "</div>";
  document.getElementById("myModal1").innerHTML = cont;
  document.getElementById("valor_rec").focus();
}

function calcularTroco() {
  var troco =
    parseFloat(document.getElementById("valor_rec").value) - parseFloat(total);
  document.getElementById("troco").innerHTML =
    "<b>Troco:</b> " + number_format(troco, 2, ",", ".");
}

function showProdutoRapidoModal(codigo) {
  $("#myModal1").css({ "width": "680px", "margin-left": "-245px" });
  document.getElementById("myModal1").innerHTML = "";
  include("produto_rapido_modal.php", "codigo=" + encodeURIComponent(codigo), "myModal1");
  $("#myModal1").modal("show");
}

function showEstoqueRapidoModal(codigo, id) {
  $("#myModal1").css({ "width": "520px", "margin-left": "-165px" });
  document.getElementById("myModal1").innerHTML = "";
  include("estoque_rapido_modal.php", "codigo=" + encodeURIComponent(codigo) + "&id=" + id, "myModal1");
  $("#myModal1").modal("show");
}

function cadastrarProdutoRapido() {
  var nome = $("#modal_nome").val();
  var valor_compra = $("#modal_valor_compra").val();
  var valor = $("#modal_valor").val();
  var marca = $("#modal_marca").val();
  var categoria = $("#modal_categoria").val();
  var codigo = $("#modal_codigo").val();
  var fornecedor = $("#modal_fornecedor").val();

  if (!nome || !valor_compra || !valor || !marca || !categoria || !codigo || !fornecedor) {
    alert("Por favor, preencha todos os campos obrigatÃ³rios.");
    return false;
  }

  var formData = new FormData(document.getElementById("frmCadProdRapido"));
  $.ajax({
    url: "bd.insereProduto.php",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    dataType: "json",
    success: function (response) {
      if (response === 1 || response == "1") {
        alert("Produto cadastrado com sucesso!");
        $("#myModal1").modal("hide");
        getProdutoRef(codigo);
      } else if (response === 2 || response == "2") {
        alert("Produto jÃ¡ cadastrado!");
      } else {
        alert("Erro ao cadastrar produto.");
      }
    },
    error: function (xhr, status, error) {
      alert("Erro na requisiÃ§Ã£o. Verifique o console.");
      console.log(error);
    }
  });
}

function cadastrarEstoqueRapido() {
  var produto = $("#modal_estq_produto_id").val();
  var qtdentrada = $("#modal_estq_qtdentrada").val();
  var estoquemin = $("#modal_estq_minimo").val();
  var num_nf = $("#modal_estq_num_nf").val();
  var qtdacumulada = $("#modal_estq_acumulada").val();

  if (!qtdentrada || !estoquemin) {
    alert("Por favor, insira a quantidade de entrada e o estoque mÃ­nimo.");
    return false;
  }

  $.ajax({
    url: "bd.insereEstoque.php",
    type: "POST",
    data: {
      produto: produto,
      qtdentrada: qtdentrada,
      qtdsaida: 0,
      estoque_minimo: estoquemin,
      qtdacumulada: qtdacumulada,
      num_nf: num_nf
    },
    dataType: "json",
    success: function (response) {
      if (response === 1 || response == "1") {
        alert("Estoque atualizado com sucesso!");
        $("#myModal1").modal("hide");
        var codigo = $("#codigo").val() || $("#modal_codigo").val();
        if (codigo) {
          getProdutoRef(codigo);
        } else {
          location.reload();
        }
      } else {
        alert("Erro ao salvar dados de estoque.");
      }
    },
    error: function (xhr, status, error) {
      alert("Erro na requisiÃ§Ã£o. Verifique o console.");
      console.log(error);
    }
  });
}
