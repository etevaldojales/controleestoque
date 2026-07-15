$(document).ready(function () {
  let currentStep = 1;

  function showAlert(step, type, message) {
    const alertDiv = $(`#alert-step${step}`);
    alertDiv.removeClass('alert-error alert-success').addClass(`alert-${type}`);
    alertDiv.html(`<i class="icon-${type === 'error' ? 'warning-sign' : 'ok-sign'}"></i> <span>${message}</span>`);
    alertDiv.show();
  }

  function hideAlerts() {
    $('.alert').hide().html('');
  }

  function setStep(step) {
    hideAlerts();
    $('.step-panel').removeClass('active');
    $(`#panel-step${step}`).addClass('active');

    // Stepper header classes
    $('.step').removeClass('active completed');
    for (let i = 1; i <= 3; i++) {
      const stepEl = $(`.step[data-step="${i}"]`);
      if (i < step) {
        stepEl.addClass('completed');
      } else if (i === step) {
        stepEl.addClass('active');
      }
    }

    // Stepper progress bar width
    const progressWidth = step === 1 ? 0 : step === 2 ? 50 : 100;
    $('.step-progress').css('width', `${progressWidth}%`);

    currentStep = step;
  }

  // STEP 1: Test Connection & Save config
  $('#btn-step1').on('click', function () {
    const btn = $(this);
    const host = $('#db_host').val().trim();
    const user = $('#db_user').val().trim();
    const pass = $('#db_pass').val();
    const name = $('#db_name').val().trim();

    if (!host || !user || !name) {
      showAlert(1, 'error', 'Por favor, preencha todos os campos obrigatórios (Servidor, Usuário e Nome do Banco).');
      return;
    }

    btn.prop('disabled', true).html('<div class="spinner"></div> Testando...');
    hideAlerts();

    $.ajax({
      url: 'index.php?action=test_connection',
      type: 'POST',
      data: { host, user, pass, name },
      dataType: 'json',
      success: function (response) {
        btn.prop('disabled', false).html('Testar e Salvar Conexão <i class="icon-chevron-right"></i>');
        if (response.success) {
          setStep(2);
        } else {
          showAlert(1, 'error', 'Erro ao conectar ao banco de dados: ' + response.error);
        }
      },
      error: function () {
        btn.prop('disabled', false).html('Testar e Salvar Conexão <i class="icon-chevron-right"></i>');
        showAlert(1, 'error', 'Erro de comunicação com o servidor. Tente novamente.');
      }
    });
  });

  // STEP 2: Database Creation & Table structure installation
  $('#btn-step2').on('click', function () {
    const btn = $(this);
    btn.prop('disabled', true).html('<div class="spinner"></div> Instalando...');
    hideAlerts();

    // Visual updates for progress items
    const itemStructure = $('#progress-structure');
    const itemSeeds = $('#progress-seeds');

    itemStructure.addClass('active');

    $.ajax({
      url: 'index.php?action=install_db',
      type: 'POST',
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          // Visual simulation for smooth transition
          itemStructure.removeClass('active').addClass('completed');
          itemStructure.find('.progress-icon').html('<i class="icon-ok"></i>');

          setTimeout(function () {
            itemSeeds.addClass('active');
            
            setTimeout(function () {
              itemSeeds.removeClass('active').addClass('completed');
              itemSeeds.find('.progress-icon').html('<i class="icon-ok"></i>');

              setTimeout(function () {
                setStep(3);
              }, 800);
            }, 1000);
          }, 1000);
        } else {
          btn.prop('disabled', false).html('Instalar Tabelas e Seeds <i class="icon-chevron-right"></i>');
          itemStructure.removeClass('active');
          showAlert(2, 'error', 'Erro ao instalar o banco de dados: ' + response.error);
        }
      },
      error: function () {
        btn.prop('disabled', false).html('Instalar Tabelas e Seeds <i class="icon-chevron-right"></i>');
        itemStructure.removeClass('active');
        showAlert(2, 'error', 'Erro de rede ao instalar o banco de dados. Tente novamente.');
      }
    });
  });

  // STEP 3: Admin Account Creation
  $('#btn-step3').on('click', function () {
    const btn = $(this);
    const name = $('#admin_name').val().trim();
    const login = $('#admin_login').val().trim();
    const email = $('#admin_email').val().trim();
    const password = $('#admin_pass').val().trim();
    const projectName = $('#project_name').val().trim();

    if (!name || !login || !password || !projectName) {
      showAlert(3, 'error', 'Por favor, preencha o Nome do Projeto, Nome Completo, Usuário e Senha.');
      return;
    }

    btn.prop('disabled', true).html('<div class="spinner"></div> Criando Administrador...');
    hideAlerts();

    $.ajax({
      url: 'index.php?action=create_admin',
      type: 'POST',
      data: { name, login, email, password, project_name: projectName },
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          showAlert(3, 'success', 'Instalação concluída com sucesso! Redirecionando para o login...');
          setTimeout(function () {
            window.location.href = '../login.php';
          }, 2000);
        } else {
          btn.prop('disabled', false).html('Finalizar Instalação <i class="icon-check"></i>');
          showAlert(3, 'error', 'Erro ao criar conta administrativa: ' + response.error);
        }
      },
      error: function () {
        btn.prop('disabled', false).html('Finalizar Instalação <i class="icon-check"></i>');
        showAlert(3, 'error', 'Erro ao se conectar ao servidor. Tente novamente.');
      }
    });
  });
});
