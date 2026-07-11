// JavaScript Document
var pagina;
function listar(pag) {
  pagina = pag;
  include("lista_empresas.php", "pagina=" + pag, "lista");
}

function paginar(pag) {
  pagina = pag;
  include("lista_empresas.php", "pagina=" + pag, "lista");
}

function pesquisar() {
  var val = document.getElementById("parametro").value;
  var status = document.getElementById("ativo").checked == true ? 1 : 0;
  include(
    "lista_empresas.php",
    "parametro=" + val + "&status=" + status,
    "lista"
  );
}

function validar() {
  var nome = document.getElementById("nome");
  var formData = new FormData($("#frmempresa")[0]);
  if (!nome.value.trim()) {
    showToast("Por favor insira o Nome da Empresa", "warning");
    return nome.focus();
  }
  $.ajax({
    type: "POST",
    url: "bd.insereEmpresa.php",
    data: formData,
    processData: false,
    contentType: false,
    dataType: "json",
    success: function (r) {
      console.log(r);
      if (r == 1) {
        showToast("Empresa inserida com sucesso!", "success");
        limpacampos();
        listar(1);
      } else if (r == 2) {
        showToast("Empresa já cadastrada", "warning");
        limpacampos();
      } else {
        showToast("Erro ao inserir empresa!", "error");
        limpacampos();
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      for (i in XMLHttpRequest) {
        if (i != "channel") console.log(i + " : " + XMLHttpRequest[i]);
      }
    },
  });
}

async function editar(id) {
  $.ajax({
    type: "post",
    url: "bd.getEmpresa.php",
    data: { id: id },
    dataType: "json",
    success: function (r) {
      console.log(r);
      $("#nome").val(r.nome);
      $("#endereco").val(r.endereco);
      $("#telefone").val(r.telefone);
      $("#email").val(r.email);
      $("#id").val(r.id);
      document.getElementById("btnCad").innerHTML =
        '<i class="icon-ok"></i>Alterar';
      if (r.logo) {
        document.getElementById("dvlogo").innerHTML =
          "<img src='" + r.logo + "'>";
      }
      if (r.qrcode) {
        document.getElementById("dvqrcode").innerHTML =
          "<img src='" + r.qrcode + "' width='200'>";
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      for (i in XMLHttpRequest) {
        if (i != "channel") console.log(i + " : " + XMLHttpRequest[i]);
      }
    },
  });
}

function excluir(id) {
  customConfirm("Deseja realmente excluir esse registro?", function() {
    //executar("bd.excluiCategoria.php", "id=" + id, excluirRe);
    $.ajax({
      type: "post",
      url: "bd.excluiEmpresa.php",
      data: { id: id },
      dataType: "json",
      success: function (r) {
        console.log(r);
        if (r == 1) {
          showToast("Empresa excluída com sucesso!", "success");
        } else {
          showToast("Erro ao excluir empresa!", "error");
        }
        listar(1);
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        for (i in XMLHttpRequest) {
          if (i != "channel") console.log(i + " : " + XMLHttpRequest[i]);
        }
      },
    });
  });
}

function limpacampos() {
  document.getElementById("frmempresa").reset();
  document.getElementById("id").value = 0;
  document.getElementById("btnCad").innerHTML =
    '<i class="icon-ok"></i>Cadastrar';
  document.getElementById("dvlogo").innerHTML = "";
  document.getElementById("dvqrcode").innerHTML = "";
}
