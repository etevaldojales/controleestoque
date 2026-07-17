<?php
require_once 'lib/classes/config.php';
require_once 'lib/classes/class.utilidades.php';

$util = new utilidades();
$util->generate_csrf_token();

// Initialize error display (cleared by AJAX)
$error = '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Controle Estoque - Login</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/style_responsive.css" rel="stylesheet" />
  <link href="css/style_default.css" rel="stylesheet" id="style_color" />
</head>

<body id="login-body">
  <div class="login-header">
    <div id="logo" class="center" style="color:#FFF"><b>CONTROLE - <span class="text-primary">ESTOQUE</span></b></div>
  </div>
  <div id="login">
    <!-- AJAX errors shown here -->
    <div id="login-error" class="alert alert-error" style="display:none;"></div>

    <form id="loginform" class="form-vertical no-padding no-margin" method="POST" action="">
      <?= $util->get_csrf_token_html() ?>
      <div class="lock">
        <i class="icon-lock"></i>
      </div>
      <div class="control-wrap">
        <h4>Login do Usuário</h4>
        <div class="control-group">
          <div class="controls">
            <div class="input-prepend">
              <span class="add-on"><i class="icon-user"></i></span>
              <input name="login_usu" type="text" placeholder="Usuário"
                value="<?= htmlspecialchars($_POST['login_usu'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required />

            </div>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <div class="input-prepend">
              <span class="add-on"><i class="icon-key"></i></span>
              <input id="senha" name="senha" type="password" placeholder="Senha" required />

            </div>
            <div class="mtop10">
              <div class="block-hint pull-left small">
                <input type="checkbox" id="remember"> Lembrar me
              </div>
              <div class="block-hint pull-right">
                <a href="javascript:;" id="forget-password">Esqueceu sua senha?</a>
              </div>
            </div>
            <div class="clearfix space5"></div>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-block login-btn">Login</button>
    </form>
  </div>
  <div id="login-copyright">
    <?php echo "Controle Estoque"; ?><br>© Copyright
    <?php echo date('Y'); ?> - Jales Tecnologia
  </div>
  <script src="js/jquery-1.8.3.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="js/jquery.blockui.js"></script>
  <script src="js/scripts.js"></script>
  <script>
    jQuery(document).ready(function () {
      App.initLogin();

      // Clear login and password inputs before filling
      $('input[name="login_usu"]').val('');
      $('#senha').val('');

      // AJAX Login Handler
      $('#loginform').on('submit', function (e) {
        e.preventDefault();

        var $form = $(this);
        var $btn = $('.login-btn');
        var $errorDiv = $('#login-error');

        // Disable button & show loading
        $btn.prop('disabled', true).text('Entrando...');
        $errorDiv.hide();

        $.ajax({
          url: 'login/index.php',
          type: 'POST',
          data: $form.serialize(),
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              window.location.href = response.redirect;
            } else {
              $errorDiv.text(response.error).show();
              $btn.prop('disabled', false).text('Login');
            }
          },
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            $errorDiv.text('Erro de conexão. Tente novamente.').show();
            $btn.prop('disabled', false).text('Login');

            for (i in XMLHttpRequest) {
              if (i != "channel") console.log(i + " : " + XMLHttpRequest[i]);
            }
          },
        });
      });
    });
  </script>

</body>

</html>