<?php
include("config_inicio.php");
require_once($lib . 'classes/class.empresa.php');
$_class = new empresa($dbase);
$emp = $_class->get(1);
//print_r($emp);

// Verificar se é necessário rodar o backup (se o último tiver mais de 12 horas)
$backupNecessario = false;
$backupDir = __DIR__ . '/backups';
$arquivos = glob($backupDir . '/db_backup_*.sql');

if (empty($arquivos)) {
    $backupNecessario = true;
} else {
    // Ordena os backups pelo tempo de modificação para pegar o mais recente (mais novo primeiro)
    usort($arquivos, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    $ultimoBackup = $arquivos[0];
    
    // Se o último backup tem mais de 12 horas (43200 segundos)
    if ((time() - filemtime($ultimoBackup)) > 43200) {
        $backupNecessario = true;
    }
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
   <meta charset="utf-8" />
   <?php
   include("titulo.php");
   ?>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="css/style.css" rel="stylesheet" />
   <link href="css/style_responsive.css" rel="stylesheet" />
   <link href="css/style_gray.css" rel="stylesheet" type="text/css" id="style_color" />

   <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
   <link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link rel="stylesheet" type="text/css" href="css/estilo.css" />

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="fixed-top">
   <!-- BEGIN HEADER -->
   <div id="header" class="navbar navbar-inverse navbar-fixed-top">
      <?php
      include("topo.php");
      ?>
   </div>
   <!-- END HEADER -->
   <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->
      <div id="sidebar" class="nav-collapse collapse">
         <div class="sidebar-toggler hidden-phone"></div>
         <!-- BEGIN SIDEBAR MENU -->
         <?php
         include("menu.php");
         ?>

         <!-- END SIDEBAR MENU -->
      </div>
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">

                  <h3 class="page-title"><?= isset($emp['nome']) ? htmlspecialchars($emp['nome']) : 'Controle de Estoque' ?></h3>
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <div class="space10"></div>
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM widget-->
                  <div class="widget" style="height: 700px;">
                     <div class="widget-title">
                        <h4><i class="icon-reorder"></i> INÍCIO</h4>
                        <span class="tools">
                           <a href="javascript:;" class="icon-chevron-down"></a>
                           <a href="javascript:;" class="icon-remove"></a>
                        </span>
                     </div>
                     <div class="widget-body form"
                        style="border: 2px solid; margin-top: 10%; width: 57%; margin-left: 20%; border-radius: 30px;">
                        <h2>Bem-vindo ao Sistema de Controle de Loja</h2>
                        <p>
                        <h4>Este é o painel inicial onde você pode acessar as principais funcionalidades do sistema.
                        </h4>
                        </p>
                        <ul>
                           <li><a href="pdv.php" style="font-size: 14px; color: #808080">Gerenciar PDV</a></li>
                           <li><a href="estoque_listar.php" style="font-size: 14px; color: #808080">Gerenciar Estoque</a></li>
                           <li><a href="pedidos.php" style="font-size: 14px; color: #808080">Gerenciar Pedidos</a></li>
                           <li><a href="clientes.php" style="font-size: 14px; color: #808080">Gerenciar Clientes</a>
                           </li>
                           <li><a href="fornecedor.php" style="font-size: 14px; color: #808080">Gerenciar Fornecedores</a></li>
                           <!--<li><a href="relatorios.php" style="font-size: 14px; color: #808080">Relatórios</a></li>-->
                        </ul>
                     </div>
                     <div class="widget-body form"
                        style="margin-top: 1%; width: 57%; margin-left: 20%; border-radius: 30px; text-align: center;">
                        <img src="uploads/<?= (!empty($emp) && !empty($emp['logo'])) ? htmlspecialchars($emp['logo']) : 'logo.png' ?>" alt="">
                     </div>

                  </div>
                  <!-- END SAMPLE FORM widget-->
               </div>
            </div>

            <!-- BEGIN PAGE CONTENT-->

            <div class="row-fluid" id="itens" style="margin-left: -2%;"></div>

         </div>
         <!-- END PAGE CONTAINER-->
         <!--MODAL-->
         <!--FIM MODAL-->
      </div>
      <!-- END PAGE -->

   </div>
   <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
      aria-hidden="true" style="width:450px;"></div>
   <!-- END CONTAINER -->
   <!-- BEGIN FOOTER -->
   <?php
   include("rodape.php");
   ?>
   <!-- END FOOTER -->
   <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="js/jquery-1.8.3.min.js"></script>
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
   <script src="js/jquery.blockui.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"
      charset="ISO-8859-1"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"
      charset="ISO-8859-1"></script>
   <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
   <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

   <script src="js/scripts.js"></script>
   <script>
       jQuery(document).ready(function () {
          // initiate layout and plugins
          App.init();
          <?php if ($backupNecessario): ?>
          console.log("Iniciando backup em segundo plano...");
          $.ajax({
             url: 'cron_backup.php',
             type: 'GET',
             success: function(response) {
                console.log("Backup automático executado com sucesso.");
             },
             error: function() {
                console.log("Falha ao rodar o backup automático em segundo plano.");
             }
          });
          <?php endif; ?>
       });
   </script>
   <!-- END JAVASCRIPTS -->
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>

   <script>
      function validarCheckout() {
         var formpag = document.getElementById('formpag').value;
         if (!formpag) {
            alert('Por favor selecione a forma de pagamento');
            return document.getElementById('formpag').focus();
         }
         var idpedido = <?= $idpedido ?? 0 ?>;
         var obs = document.getElementById('obs') ? document.getElementById('obs').value : '';
         var data = document.getElementById('data') ? document.getElementById('data').value : '';
         var total = 0;
         var total_custo = 0;
         var total_venda = 0;
         // Calculate totals from the cart table if needed or pass from PHP if available
         // For now, use 0 or fetch dynamically if needed
         concluirPedido(idpedido, total, total_custo, total_venda, formpag, obs, data);
      }
   </script>
</body>
<!-- END BODY -->

</html>