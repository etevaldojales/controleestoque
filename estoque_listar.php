<?php
include("config_inicio.php");
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
		<?php  
        include ("menu.php"); 
        ?> 
		<script src="js/produtospr.js"></script>
        </div>
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
                     Consultar Estoque
                     <small></small>
                  </h3>
               </div>
            </div>
            <!-- END PAGE HEADER-->

            <div class="space10"></div>
             
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
               
               
                 <div class="widget">
                   <div class="widget-title">

                   </div>
                        <div class="widget-body">
                            <div class="invoice-date-range span12 form">
                                <div class="control-group span2">
                                    <input type="text" placeholder="Pesquisar" class="control-label" style="margin-right:20px;" 
                                    data-provide="typeahead" data-items="4"  name="parametro" id="parametro" onClick="this.value=''" 
                                    onKeyPress="pesquisarPNome(this.value)"/>
                                </div>
                                <div style="width:15px;"></div>
                                <div class="btn-group" style="vertical-align: 100%;margin-left:10%;">
                                    <select class="control-label" style="margin-left:14px;" data-placeholder="Selecione" tabindex="1" name="tipo" id="tipo">
                                        <option value="1">Produto</option>
                                        <option value="2">Referência</option>
                                        <option value="3">Fornecedor</option>
                                        <option value="4">Marca</option>
                                        <option value="5">Categoria</option>
                                    </select>
                                    <button class="btn btn-primary" onClick="pesquisar()" style="margin-left:30px;margin-top:-10px;">Buscar</button>
                                </div>
							</div>
                            <div style="clear:both"></div>
                            <!--Lista de Produtos-->
                            <div id="lista"></div>
                            <script>
							listar(1);
							</script>
                            <!--Fimn Lista de Produtos-->
                        </div>
                 </div>
               </div>
           </div>
            <!--MODAL COTAÇÃO-->
            <div id="myModal1"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            </div>
            <!--MODAL COTAÇÃO FIM  -->
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
</body>
<!-- END BODY -->
</html>