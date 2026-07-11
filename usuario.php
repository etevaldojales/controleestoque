<?php
include("config_inicio.php");
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
   <link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />

   <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
   <link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <script src="lib/js/ajax.js"></script>
   <script src="js/usuario.js" charset="utf-8"></script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="fixed-top">
   <!-- BEGIN HEADER -->
   <div id="header" class="navbar navbar-inverse navbar-fixed-top">
      <!-- BEGIN TOP NAVIGATION BAR -->
      <?php
      include("topo.php");
      ?>
      <!-- END TOP NAVIGATION BAR -->
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

                  <h3 class="page-title">
                     Usuários
                     <small></small>
                  </h3>
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <br>
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span6 sortable">
                  <!-- BEGIN SAMPLE FORMPORTLET-->
                  <div class="widget">
                     <div class="widget-title">
                        <h4><i class="icon-reorder"></i>Cadastrar</h4>
                        <span class="tools">
                           <a href="javascript:;" class="icon-chevron-down"></a>
                           <a href="javascript:;" class="icon-remove"></a>
                        </span>
                     </div>
                     <div class="widget-body">
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal" name="frmUsu" method="post" id="frmUsu">
                           <div class="control-group">
                              <label class="control-label">Nome</label>
                              <div class="controls">
                                 <input type="text" class="span6 " name="nome_usu" id="nome_usu" />
                              </div>
                           </div>
                           <div class="control-group" style="display: none">
                              <label class="control-label">Email</label>
                              <div class="controls">
                                 <div class="input-prepend">
                                    <input class=" " type="email" placeholder="Email Address" name="email_usu" id="email_usu" value=""/>
                                 </div>
                              </div>
                           </div>
                           <div class="control-group" style="display: none">
                              <label class="control-label">Telefone</label>
                              <div class="controls">
                                 <input type="text" class="span6 " name="fone_usu" id="fone_usu" value=""
                                    onKeyDown="mascarag(this,mtel)" maxlength="14" />
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Login</label>
                              <div class="controls">
                                 <input class="span6" type="text" name="login_usu" id="login_usu" />
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Senha</label>
                              <div class="controls">
                                 <input type="password" class="span6 " name="senha_usu" id="senha_usu" />
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Tipo Usuario</label>
                              <div class="controls">
                                 <select class="span6 chosen" data-placeholder="Selecione" tabindex="1" name="tipo_usu"
                                    id="tipo_usu">
                                    <option value="">Selecione</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Operador</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-actions">
                              <button type="button" class="btn blue" onClick="valida()" id="btnSalva"><i
                                    class="icon-save"></i> Salvar</button>
                              <button type="button" class="btn" onClick="limpacampos()"><i class=" icon-remove"></i>
                                 Cancelar</button>
                           </div>
                           <input type="hidden" name="id" id="id" value="0">
                        </form>
                        <!-- END FORM-->
                     </div>
                  </div>

                  <!-- END SAMPLE FORM PORTLET-->
               </div>
               <div class="widget-title">
                  <h4><i class="icon-user"></i> Usuários Cadastrados</h4>
               </div>
               <div class="span6">
                  <div class="control-group span4">
                     <input type="text" placeholder="Pesquisar" class="control-label" style="margin: 0 auto;"
                        data-provide="typeahead" data-items="4" name="parametro" id="parametro"
                        onKeyPress="pesquisar(this.value)" onClick="this.value=''" />
                  </div>
                  <div class="btn-group" style="vertical-align: 77%;">
                     <button class="btn btn-primary"
                        onClick="pesquisar(document.getElementById('parametro').value)">Buscar</button>
                  </div>
               </div>
               <div class="span6" id="lista"></div>
               <div class="span6" id="dvpermissoes" style="display:none">
                  <script>
                     listar(1);
                  </script>
               </div>
            </div>
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
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
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="assets/clockface/js/clockface.js"></script>
   <script type="text/javascript" src="assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>
   <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
   <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
   <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
   <script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
   <script src="js/scripts.js"></script>
   <script>
      jQuery(document).ready(function () {
         // initiate layout and plugins
         App.init();
      });
   </script>
   <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>