// JavaScript Document
var pagina;
function listar(pag) {
  pagina = pag;
  include("lista_clientes.php", "pagina=" + pag, "lista");
}

function paginar(pag) {
  pagina = pag;
  include("lista_clientes.php", "pagina=" + pag, "lista");
}

function pesquisar() {
  var val = document.getElementById("parametro").value;
  var status;
  if (document.getElementById("ativo").checked == true) {
    status = 1;
  } else if (document.getElementById("inativo").checked == true) {
    status = 2;
  } else {
    status = "";
  }
  include(
    "lista_clientes.php",
    "parametro=" + val + "&status=" + status,
    "lista"
  );
}

function pesquisarPNome(val) {
  var status;
  if (document.getElementById("ativo").checked == true) {
    status = 1;
  } else if (document.getElementById("inativo").checked == true) {
    status = 2;
  } else {
    status = "";
  }
  include(
    "lista_clientes.php",
    "parametro=" + val + "&status=" + status,
    "lista"
  );
}

function validar() {
  var nome = document.getElementById("nome");
  var ender = document.getElementById("endereco");
  var fone = document.getElementById("fone");
  var status = 1;

  if (!nome.value) {
    showToast("Por favor insira Nome", "warning");
    return nome.focus();
  } else if (!ender.value) {
    showToast("Por favor insira o Endereço", "warning");
    return ender.focus();
  } else if (!fone.value) {
    showToast("Por favor insira o Telefone", "warning");
    return fone.focus();
  }
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "bd.insereCliente.php",
    data: $("#frmCli").serialize(),
    success: function (response) {
      if (response == 1) {
        showToast("Dados salvos com sucesso!", "success");
        limpacampos();
        listar(pagina);
        down();
      } else if (response == 2) {
        showToast("Cliente já cadastrado", "warning");
      } else if (response && response.error) {
        showToast("Erro ao salvar cliente: " + response.error, "error");
      } else {
        showToast("Falha ao salvar dados", "error");
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      showToast("Erro na requisição AJAX.", "error");
      console.log("Status:", textStatus, "Error:", errorThrown);
      console.log("Resposta do servidor:", XMLHttpRequest.responseText);
    },
  });

  //xhSend('bd.insereCliente.php','frmCli',validarRe);
}

function editar(id) {
  up();
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "bd.getCliente.php",
    data: { id: id },
    success: function (response) {
      if (response) {
        document.getElementById("id").value = response.id;
        document.getElementById("nome").value = response.nome;
        document.getElementById("endereco").value = response.endereco;
        document.getElementById("fone").value = response.telefone;
        $("#stativo").val(response.st_ativo);
        $("#stativo").trigger("liszt:updated");
        document.getElementById("btnCad").innerHTML = "Alterar";
      } else {
        showToast("Falha ao carregar dados", "error");
      }
    },
    error: function () {
      showToast("Erro na requisição AJAX", "error");
    },
  });
}

function excluir(id) {
  customConfirm("Deseja realmente excluir esse registro?", function() {
    //executar('bd.excluiCliente.php','id='+id,excluirRe);
    $.ajax({
      type: "POST",
      url: "bd.excluiCliente.php",
      data: { id: id },
      success: function (response) {
        var retornoVal = $(response).find("retorno").text();
        if (retornoVal == 1) {
          showToast("Registro excluído com sucesso!", "success");
          listar(pagina);
        } else if (retornoVal == 2) {
          showToast(
            "Não é possível excluir esse cliente, existe pedido relacionado a ele", "warning"
          );
        } else {
          showToast("Houve um erro ao excluir dados", "error");
        }
      },
      error: function () {
        showToast("Erro na requisição AJAX", "error");
      },
    });
  });
}

function limpacampos() {
  document.getElementById("frmCli").reset();
  $(".chzn-select").chosen();
  $("#stativo").val("");
  $("#stativo").trigger("liszt:updated");
  document.getElementById("id").value = 0;
  document.getElementById("btnCad").innerHTML = "Cadastrar";
}

function down() {
  $("html, body").animate({ scrollTop: 2000 }, 3000);
}

function up() {
  $("html, body").animate({ scrollTop: 0 }, 2000);
}
