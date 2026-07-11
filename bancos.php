<?
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.bancos.php');

$_class = new bancos($dbase);
$dados 		= $_class->get(1);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
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
        <!-- BEGIN SIDEBAR MENU -->
		<?php  
        include ("menu.php"); 
        ?> 
		<script src="js/bancos.js" charset="ISO-8859-1"></script>
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
                     Bancos
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
                            <h4><i class="icon-reorder"></i>Selecionar Banco</h4>
                                        <span class="tools">
                                        <a href="javascript:;" class="icon-chevron-down"></a>
                                        <a href="javascript:;" class="icon-remove"></a>
                                        </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form action="#" class="form-horizontal" name="frmBanco" id="frmBanco" method="post">
                                <div class="control-group">
                                    <label class="control-label">Bancos</label>
                                    <table width="100%" cellpadding="10" cellspacing="2" background="0">
                                    	<tr>
                                        	<td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="1" <?=$_class->getSelecionado(1, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logobb.jpg">
                                                </span>
                                            </td>
                                            <td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="2" <?=$_class->getSelecionado(2, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logocaixa.jpg">
                                                </span>
                                            </td>
                                        </tr>
                                    	<tr>
                                        	<td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="3" <?=$_class->getSelecionado(3, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logobradesco.jpg">
                                                </span>
                                            </td>
                                            <td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="4" <?=$_class->getSelecionado(4, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logoitau.jpg">
                                                </span>
                                            </td>
                                        </tr>
                                    	<tr>
                                        	<td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="5" <?=$_class->getSelecionado(5, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logohsbc.jpg">
                                                </span>
                                            </td>
                                            <td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="6" <?=$_class->getSelecionado(6, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logoreal.jpg">
                                                </span>
                                            </td>
                                        </tr>
                                    	<tr>
                                        	<td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="7" <?=$_class->getSelecionado(7, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logobanespa.jpg">
                                                </span>
                                            </td>
                                            <td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="8" <?=$_class->getSelecionado(8, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logobanestes.jpg">
                                                </span>
                                            </td>
                                        </tr>
                                    	<tr>
                                        	<td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="9" <?=$_class->getSelecionado(9, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logonossacaixa.jpg">
                                                </span>
                                            </td>
                                            <td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="10" <?=$_class->getSelecionado(10, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logobancoob.jpg">
                                                </span>
                                            </td>
                                        </tr>
                                    	<tr>
                                        	<td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="11" <?=$_class->getSelecionado(11, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logobesc.jpg">
                                                </span>
                                            </td>
                                            <td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="12" <?=$_class->getSelecionado(12, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logosantander.jpg">
                                                </span>
                                            </td>
                                        </tr>
                                    	<tr>
                                        	<td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="13" <?=$_class->getSelecionado(13, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logosicredi.jpg">
                                                </span>
                                            </td>
                                            <td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="14" <?=$_class->getSelecionado(14, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logosudameris.jpg">
                                                </span>
                                            </td>
                                        </tr>
                                    	<tr>
                                        	<td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="15" <?=$_class->getSelecionado(15, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    <img src="boleto/imagens/logounibanco.jpg">
                                                </span>
                                            </td>
                                            <td>
                                                <input type="radio" class="span1"  name="banco" id="banco" value="16" <?=$_class->getSelecionado(16, $dados['id'])?>/>
                                                <span class="help-inline">
                                                    Nenhum
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn blue" id="btnCad" onClick="validar()"><i class="icon-ok"></i> Salvar</button>
                                    <button type="reset" class="btn"><i class=" icon-remove"></i> Cancelar</button>
                                </div>
                                <input type="hidden" name="id" id="id" value="0">
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
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
   <?
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
</body>
<!-- END BODY -->
</html>