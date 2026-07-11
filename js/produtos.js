"use strict";

var pagina;

function listar(pag) {
  pagina = pag;
  $.ajax({
    url: "lista_produtoscad.php",
    type: "POST",
    data: { pagina: pag },
    dataType: "html",
    success: function (data) {
      $("#lista").html(data);
    },
    error: function () {
      alert("Erro ao listar produtos");
    },
  });
}

function paginar(pag) {
  pagina = pag;
  listar(pag);
}

function pesquisar() {
  var val = $("#parametro").val();
  var filtro = $("#tipo").val();
  $.ajax({
    url: "lista_produtoscad.php",
    type: "POST",
    data: { parametro: val, filtro: filtro, pagina: pagina },
    dataType: "html",
    success: function (data) {
      $("#lista").html(data);
    },
    error: function () {
      alert("Erro ao pesquisar produtos");
    },
  });
}

function showCalculadora() {
  var valor = $("#valor_compra").val();
  if (!valor) {
    alert("Preencha o campo Preço Compra");
    $("#btnCloseModal").click();
    $("#valor_compra").focus();
    return;
  } else {
    $.ajax({
      url: "calculadora.php",
      type: "POST",
      data: { valor: valor },
      dataType: "html",
      success: function (data) {
        $("#myModal1").html(data);
      },
      error: function () {
        alert("Erro ao carregar calculadora");
      },
    });
  }
}

function calcular() {
  var perc = $("#percentual").val();
  var valorc = $("#valor_compra").val();
  var opcao = $("#opc1").is(":checked") ? 1 : 2; // 1 - Acrescimo; 2 - Desconto
  if (!perc) {
    alert("Preencha o campo Percentual");
    $("#percentual").focus();
    return;
  }
  $.ajax({
    url: "calcular.php",
    type: "POST",
    data: { valor: valorc, percentual: perc, opcao: opcao },
    dataType: "json",
    success: function (response) {
      if (response) {
        $("#valor").val(response);
        $("#btnCloseModal").click();
      } else {
        alert("Falha ao calcular");
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      alert("Erro na requisição de cálculo");
      for (var i in XMLHttpRequest) {
        if (i != "channel") console.log(i + " : " + XMLHttpRequest[i]);
      }
    },
  });
}

function validaMarca() {
  var nome = $("#nmmarca").val();

  if (!nome) {
    alert("Por favor preencha o campo Marca");
    $("#nmmarca").focus();
    return;
  } else {
    $.ajax({
      url: "bd.insereMarca.php",
      type: "POST",
      data: $("#frmCadMarca").serialize(),
      dataType: "json",
      success: function (response) {
        if (response.mensagem === "1") {
          alert("Dados salvos com sucesso!");
          carregarMarcas();
        } else if (response.mensagem === "2") {
          alert("Marca já cadastrada");
        } else {
          alert("Falha ao salvar dados");
        }
      },
      error: function () {
        alert("Erro na requisição de validação de marca");
      },
    });
  }
}

function carregarMarcas(selected_id) {
  $("#marcaprod, #marca").empty();

  $.ajax({
    url: "bd.getMarcas.php",
    type: "POST",
    dataType: "json",
    success: function (data) {
      console.log(data);
      $("#marcaprod, #marca").append("<option></option>");
      for (var i = 0; i < data.length; i++) {
        var selected = (selected_id && data[i].id == selected_id) ? " selected" : "";
        $("#marcaprod, #marca").append(
          '<option value="' +
          data[i].id +
          '"' + selected + '>' +
          data[i].descricao +
          "</option>"
        );
      }
      console.log('id selecionado: ' + selected_id);
      if (selected_id) {
        $("#marcaprod, #marca").val(selected_id);
      }
      $("#marcaprod, #marca").trigger("liszt:updated");
      if (selected_id) {
        $("#marcaprod, #marca").trigger("change");
      }
    },
    error: function () {
      alert("Erro ao carregar marcas");
    },
  });
  $("#fecha_status").click();
}

function validaFornecedor() {
  var nome = $("#nmfornecedor").val();
  if (!nome) {
    alert("Por favor preencha o campo Fornecedor");
    $("#nmfornecedor").focus();
    return;
  }
  $.ajax({
    url: "bd.insereFornecedor.php",
    type: "POST",
    data: $("#frmCadForn").serialize(),
    dataType: "json",
    success: function (response) {
      if (response.mensagem === "1") {
        alert("Dados salvos com sucesso!");
        carregarFornecedores();
      } else if (response.mensagem === "2") {
        alert("Fornecedor já cadastrado");
      } else {
        alert("Falha ao salvar dados");
      }
    },
    error: function () {
      alert("Erro na requisição de validação de fornecedor");
    },
  });
}

function carregarFornecedores(selected_id) {
  $("#fornprod, #fornecedor").empty();

  $.ajax({
    url: "bd.getFornecedores.php",
    type: "POST",
    dataType: "json",
    success: function (data) {
      $("#fornprod, #fornecedor").append("<option></option>");
      for (var i = 0; i < data.length; i++) {
        var selected = (selected_id && data[i].id == selected_id) ? " selected" : "";
        $("#fornprod, #fornecedor").append(
          '<option value="' +
          data[i].id +
          '"' + selected + '>' +
          data[i].descricao +
          "</option>"
        );
      }
      if (selected_id) {
        $("#fornprod, #fornecedor").val(selected_id);
      }
      $("#fornprod, #fornecedor").trigger("liszt:updated");
      if (selected_id) {
        $("#fornprod, #fornecedor").trigger("change");
      }
    },
    error: function () {
      alert("Erro ao carregar fornecedores");
    },
  });
  $("#fecha_status").click();
}

function editar(id) {
  up();
  $.ajax({
    url: "bd.getProduto.php",
    type: "POST",
    data: { id: id },
    dataType: "json",
    success: function (response) {
      if (response && response.dados) {
        var dados = response.dados;
        $("#id").val(dados.id);
        $("#nome").val(dados.nome);
        $("#codigo").val(dados.codigo);
        $("#valor_compra").val(dados.valor_compra);
        $("#valor").val(dados.valor);
        $("#qtd").val(dados.quantidade);
        $("#estqmin").val(dados.estoque);
        $("#local").val(dados.local);
        $("#unidade").val(dados.unidade);

        $(".chzn-select").chosen();
        $("#marca").val(dados.id_marca);
        $("#marca").trigger("liszt:updated");

        $(".chzn-select").chosen();
        $("#fornecedor").val(dados.id_fornecedor);
        $("#fornecedor").trigger("liszt:updated");

        $(".chzn-select").chosen();
        $("#categoria").val(dados.id_categoria);
        $("#categoria").trigger("liszt:updated");

        // Handle image link display
        if (dados.imagem && dados.imagem !== null && dados.imagem !== "") {
          var imageUrl = "uploads/produtos/" + dados.imagem;
          var linkHtml = '<a href="#" id="imagem-link-anchor">Imagem atual</a>';
          $("#imagem-link").html(linkHtml);

          $("#imagem-link-anchor")
            .off("click")
            .on("click", function (e) {
              e.preventDefault();
              $("#imagemModalImg").attr("src", imageUrl);
              $("#imagemModal").modal("show");
            });
        } else {
          $("#imagem-link").html("");
        }

        $("#btnCad").html("Alterar");
      } else {
        alert("Falha ao editar Produto");
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      alert("Erro na requisição de edição");
      for (var i in XMLHttpRequest) {
        if (i != "channel") console.log(i + " : " + XMLHttpRequest[i]);
      }
    },
  });
}

function excluir(id) {
  customConfirm("Deseja realmente excluir esse registro?", function() {
    $.ajax({
      url: "bd.excluiProduto.php",
      type: "POST",
      data: { id: id },
      dataType: "json",
      success: function (response) {
        if (response && response.retorno == 1) {
          alert("Registro excluido com sucesso!");
          listar(pagina);
        } else {
          alert("Houve um erro ao excluir dados");
        }
      },
      error: function () {
        alert("Erro na requisição de exclusão");
      },
    });
  });
}

function limpacampos() {
  $("#frmCadProd")[0].reset();
  $("#id").val(0);
  $(".chzn-select").chosen();
  $("#marca").val("");
  $("#marca").trigger("liszt:updated");

  $(".chzn-select").chosen();
  $("#fornecedor").val("");
  $("#fornecedor").trigger("liszt:updated");

  $(".chzn-select").chosen();
  $("#categoria").val("");
  $("#categoria").trigger("liszt:updated");

  $("#btnCad").html("Cadastrar");
}

function formatNumber(number) {
  var number = new Number(number);
  var prec = number.toPrecision(4);
  prec = prec.replace(".", ",");
  return prec;
}

function showMarca() {
  $.ajax({
    url: "marca_modal.php",
    type: "POST",
    dataType: "html",
    success: function (data) {
      $("#myModal1").html(data);
    },
    error: function () {
      alert("Erro ao carregar modal de marca");
    },
  });
}

function cadastrarMarca() {
  var marca = $("#nmmarca").val();
  if (!marca) {
    alert("Por favor preencha o campo Marca");
    $("#nmmarca").focus();
    return;
  }
  $.ajax({
    url: "bd.insereMarcaMod.php",
    type: "POST",
    data: $("#frmCadMarcaMod").serialize(),
    dataType: "json",
    success: function (response) {
      if (response && response.status === 1) {
        alert("Dados salvos com sucesso!");
        carregarMarcas(response.id);
        $("#btnCloseModal").click();
      } else if (response && response.status === 2) {
        alert("Marca já cadastrada");
        $("#btnCloseModal").click();
      } else {
        alert("Falha ao salvar dados");
      }
    },
    error: function () {
      alert("Erro na requisição de cadastro de marca");
    },
  });
}

function showCategoria() {
  $.ajax({
    url: "categoria_modal.php",
    type: "POST",
    dataType: "html",
    success: function (data) {
      $("#myModal1").html(data);
    },
    error: function () {
      alert("Erro ao carregar modal de categoria");
    },
  });
}

function cadastrarCategoria() {
  var categoria = $("#nmcategoria").val();
  if (!categoria) {
    alert("Por favor preencha o campo Categoria");
    $("#nmcategoria").focus();
    return;
  }
  $.ajax({
    url: "bd.insereCategoriaMod.php",
    type: "POST",
    data: $("#frmCadCatMod").serialize(),
    dataType: "json",
    success: function (response) {
      if (response && response.status === 1) {
        alert("Dados salvos com sucesso!");
        $("#btnCloseModal").click();
        carregarCategorias(response.id);
      } else if (response && response.status === 2) {
        alert("Categoria já cadastrada");
        $("#btnCloseModal").click();
      } else {
        alert("Falha ao salvar dados");
      }
    },
    error: function () {
      alert("Erro na requisição de cadastro de categoria");
    },
  });
}

function carregarCategorias(selected_id) {
  $("#categoria").empty();

  $.ajax({
    url: "bd.getCategorias.php",
    type: "POST",
    dataType: "json",
    success: function (data) {
      $("#categoria").append("<option></option>");
      for (var i = 0; i < data.length; i++) {
        var selected = (selected_id && data[i].id == selected_id) ? " selected" : "";
        $("#categoria").append(
          '<option value="' +
          data[i].id +
          '"' + selected + '>' +
          data[i].descricao +
          "</option>"
        );
      }
      if (selected_id) {
        $("#categoria").val(selected_id);
      }
      $("#categoria").trigger("liszt:updated");
      if (selected_id) {
        $("#categoria").trigger("change");
      }
    },
    error: function (XHR, textStatus, errorThrown) {
      alert("Erro ao carregar categorias");
      for (var i in XHR) {
        if (i != "channel") console.log(i + " : " + XHR[i]);
      }
    },
  });
  $("#fecha_status").click();
}


function showFornecedor() {
  $.ajax({
    url: "fornecedor_modal.php",
    type: "POST",
    dataType: "html",
    success: function (data) {
      $("#myModal1").html(data);
    },
    error: function () {
      alert("Erro ao carregar modal de fornecedor");
    },
  });
}

function cadastrarFornecedor() {
  var fornecedor = $("#nmfornecedor").val();
  if (!fornecedor) {
    alert("Por favor preencha o campo Fornecedor");
    $("#nmfornecedor").focus();
    return;
  }
  $.ajax({
    url: "bd.insereFornecedorMod.php",
    type: "POST",
    data: $("#frmCadFornMod").serialize(),
    dataType: "json",
    success: function (response) {
      if (response && response.status === 1) {
        alert("Dados salvos com sucesso!");
        $("#btnCloseModal").click();
        carregarFornecedores(response.id);
      } else if (response && response.status === 2) {
        alert("Fornecedor já cadastrado");
        $("#btnCloseModal").click();
      } else {
        alert("Falha ao salvar dados");
      }
    },
    error: function () {
      alert("Erro na requisição de cadastro de fornecedor");
    },
  });
}

function down() {
  $("html, body").animate({ scrollTop: 2000 }, 3000);
}

function up() {
  $("html, body").animate({ scrollTop: 0 }, 2000);
}

function checkCodigoExists() {
  var codigo = $("#codigo").val().trim();
  if (codigo === "") {
    return;
  }
  $.ajax({
    url: "bd.checkCodigoExists.php",
    type: "POST",
    data: { codigo: codigo },
    dataType: "json",
    success: function (response) {
      if (response.exists) {
        alert("Código já cadastrado! Por favor, insira um código diferente.");
      }
    },
    error: function () {
      alert("Erro na requisição de verificação de código");
    },
  });
}

// Validation function for product form
function validar() {
  var nome = $("#nome").val().trim();
  var valor_compra = $("#valor_compra").val().trim();
  var valor = $("#valor").val().trim();
  var marca = $("#marca").val();
  var categoria = $("#categoria").val();
  var codigo = $("#codigo").val().trim();
  var fornecedor = $("#fornecedor").val();

  if (nome === "") {
    alert("Por favor, preencha o campo Produto.");
    $("#nome").focus();
    return false;
  }
  if (valor_compra === "") {
    alert("Por favor, preencha o campo Preço Compra.");
    $("#valor_compra").focus();
    return false;
  }
  if (valor === "") {
    alert("Por favor, preencha o campo Preço Venda.");
    $("#valor").focus();
    return false;
  }
  if (!marca) {
    alert("Por favor, selecione a Marca.");
    $("#marca").focus();
    return false;
  }
  if (!categoria) {
    alert("Por favor, selecione a Categoria.");
    $("#categoria").focus();
    return false;
  }
  if (codigo === "") {
    alert("Por favor, preencha o campo Código.");
    $("#codigo").focus();
    return false;
  }
  if (!fornecedor) {
    alert("Por favor, selecione o Fornecedor.");
    $("#fornecedor").focus();
    return false;
  }
  return true;
}

// Intercept form submission and send ajax request
$(document).ready(function () {
  $("#frmCadProd").on("submit", function (e) {
    e.preventDefault();
    if (!validar()) {
      return false;
    }
    var formData = new FormData(this);
    $.ajax({
      url: "bd.insereProduto.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response === 1 || response == "1") {
          alert("Produto salvo com sucesso!");
          limpacampos();
          listar(1);
        } else if (response === 2 || response == "2") {
          alert("Produto já cadastrado!");
          $("#nome").focus();
        } else if (response && response.error) {
          alert("Erro ao salvar produto: " + response.error);
        } else {
          alert("Erro ao salvar produto! Verifique o console para mais detalhes.");
          console.log("Resposta inesperada do servidor:", response);
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert("Erro na requisição de salvamento do produto. Verifique o console.");
        console.log("Status:", textStatus, "Error:", errorThrown);
        console.log("Resposta do servidor:", XMLHttpRequest.responseText);
      },
    });
  });

  // Image resizing before upload
  $("#imagem").on("change", function (event) {
    var file = event.target.files[0];
    if (!file) return;

    var maxWidth = 800;
    var maxHeight = 800;

    var reader = new FileReader();
    reader.onload = function (e) {
      var img = new Image();
      img.onload = function () {
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext("2d");

        var width = img.width;
        var height = img.height;

        // Calculate new dimensions while maintaining aspect ratio
        if (width > height) {
          if (width > maxWidth) {
            height = Math.round(height * (maxWidth / width));
            width = maxWidth;
          }
        } else {
          if (height > maxHeight) {
            width = Math.round(width * (maxHeight / height));
            height = maxHeight;
          }
        }

        canvas.width = width;
        canvas.height = height;

        ctx.drawImage(img, 0, 0, width, height);

        canvas.toBlob(
          function (blob) {
            var resizedFile = new File([blob], file.name, {
              type: file.type,
              lastModified: Date.now(),
            });

            // Create a new DataTransfer to update the file input
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(resizedFile);
            $("#imagem")[0].files = dataTransfer.files;
          },
          file.type,
          0.9
        );
      };
      img.src = e.target.result;
    };
    reader.readAsDataURL(file);
  });
});
