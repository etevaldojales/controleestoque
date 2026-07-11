<?php
include("config_inicio.php");
require_once($lib . 'classes/class.cliente.php');
require_once($lib . 'classes/class.utilidades.php');
$_class = new cliente($dbase);
$_util = new utilidades();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8" />
<?php 
include("titulo.php");
?>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
<link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
<link href="assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="css/style.css" rel="stylesheet" />
<link href="css/style_responsive.css" rel="stylesheet" />
<link href="css/style_gray.css" rel="stylesheet" type="text/css" id="style_color" />
<link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
<link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
<link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
<link rel="stylesheet" type="text/css" href="assets/jquery-tags-input/jquery.tagsinput.css" />
<link rel="stylesheet" type="text/css" href="assets/clockface/css/clockface.css" />
<link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />
<link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
<link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
<link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="css/estilo.css" />


<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="assets/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
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
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <div class="navbar-inverse">
                <form class="navbar-search visible-phone">
                   <input type="text" class="search-query" placeholder="Search" />
                </form>
            </div>
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
            <!-- BEGIN SIDEBAR MENU -->
            <?php  
            include ("menu.php"); 
            ?> 
            <script src="js/cliente.js" charset="utf-8"></script>
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
                        Clientes
                        <small></small>
                    </h3>
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <div class="space10"></div>
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12"> 
                    <!-- BEGIN EXAMPLE TABLE widget-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>CADASTRAR CLIENTE</h4>
                        </div>
                        <div class="widget-body">
                            <form action="#" class="form-horizontal" name="frmCli" id="frmCli" method="post">
                             <?= $_util->get_csrf_token_html() ?>
                            <div class="span6"> 
                                <!-- INICIO COLUNA A -->
                                <div class="control-group">
                                    <label class="control-label">NOME</label>
                                    <input type="text" class="span10" name="nome" id="nome" tabindex="1"/>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">TELEFONE</label>
                                    <input type="text" class="span3" name="fone" id="fone" data-mask="(99) 99999-9999" tabindex="3"/>
                                </div>
                                <!--
                                <div class="control-group">
                                    <label class="control-label">STATUS</label>
                                    <select class="chosen" style="width:90%;" data-placeholder="Selecione" tabindex="5" name="stativo" id="stativo">
                                      <option value="">SELECIONE</option>
                                      <option value="1">ATIVO</option>
                                      <option value="0">INATIVO</option>
                                    </select>
                                </div>-->
                            </div>
                            <!--FIM COLUNA A-->
                            <div class="span6"> <!-- INICIO COLUNA B -->
                                <div class="control-group">
                                    <label class="control-label">ENDERECÇO</label>
                                    <input type="text" class="span10" name="endereco" id="endereco" tabindex="2"/>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">E-MAIL</label>
                                    <input type="text" class="span10" name="email" id="email" tabindex="4"/>
                                </div>
                            </div>  <!--FIM COLUNA B-->
                            <div class="row-fluid"></div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-success" onClick="validar()" id="btnCad" tabindex="6">Cadastrar</button>
                                <button type="button" class="btn" onClick="limpacampos()" tabindex="7">Cancelar</button>
                            </div>
                            <input type="hidden" name="id" id="id" value="0">
                            <input type="hidden" name="stativo" id="stativo" value="1">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget">
                            <div class="widget-title">
                                <h4><i class="icon-user"></i>CLIENTES CADASTRADOS</h4>
                            </div>
                            <div class="widget-body">
                                <div class="invoice-date-range span12 form">
                                    <div class="control-group span4">
                                        <input type="text" placeholder="Pesquisar" class="control-label" style="margin: 0 auto; width:290px;" 
                                        data-provide="typeahead" data-items="4" name="parametro" id="parametro" onClick="this.value=''" 
                                        onKeyPress="pesquisarPNome(this.value)"/>
                                    </div>
                                    <div class="control-group span12" style="margin-top:15px;">
                                        <label style="width:80px; margin-left:0px;" class="radio">
                                            <input type="radio" name="stativop" id="ativo" value="1" /> ATIVOS
                                        </label>
                                        <label style="width:100px;" class="radio">
                                            <input type="radio" name="stativop" id="inativo" value="0" /> INATIVOS
                                        </label> 
                                       <label  style="width:100px;" class="radio">
                                            <input type="radio" name="stativop" id="todos" value="" checked />TODOS
                                        </label>  
                                    </div>
                                    <div class="btn-group" style="vertical-align: 77%;">
                                        <button class="btn btn-primary" onClick="pesquisar()">Buscar</button>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                                <div id="lista"></div>
                                <script>listar(1);</script>
                            </div>
                        </div>
                    </div>
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
   <script src="js/scripts.js"></script>
   <script>
      jQuery(document).ready(function() {       
         // initiate layout and plugins
         App.init();
      });
   </script>
   <!-- END JAVASCRIPTS -->  
   
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
   <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.js"></script>
   <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
   <script src="js/scripts.js"></script>
   
    
</body>
<!-- END BODY -->
</html>