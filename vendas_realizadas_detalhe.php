<?php
include("config_inicio.php");
require_once($lib.'classes/class.cliente.php');

$_class    	= new cliente($dbase);
;

$idcliente 	= $_GET["idcliente"];
$idpedido	= $_GET["idpedido"];
$cliente 	= $_class->get($idcliente);
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
         <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
         <!-- END RESPONSIVE QUICK SEARCH FORM -->
          <!-- BEGIN SIDEBAR MENU -->
		<?php  
        include ("menu.php"); 
        ?> 
        <script language="javascript" src="js/vendas_realizadas.js"></script>
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
                     Vendas
                     <small>
                     	<div class="span4 invoice-block pull-right">
                     		<i class="btn icon-print" onClick="document.getElementById('frm').submit()"> <b>Imprimir</b></i>
                        </div>
                     </small>
                  </h3>
               </div>
            </div>
            <!-- END PAGE HEADER-->
           <div class="space10"></div>
             <div class="row-fluid"></div>
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid"></div>
           <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN EXAMPLE TABLE widget-->
                  <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>DETALHE DO PEDIDO</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <div class="portlet-body">
                                <div class="span4">
                                    <h4><?=$cliente['nome']?></h4>
                                    <p>
                                        Endereço: <?=$cliente['endereco']?><br>
                                        E-mail: <?=$cliente['email']?><br>
                                        Telefone: <?=$cliente['telefone']?><br>
                                    </p>
                                </div>
                                <div class="space15"></div>
                                <div class="row-fluid">
                                    <div class="invoice-date-range span12 form">
                                        <div class="control-group span3">
                                            <input type="text" placeholder="Referência" class="control-label" style="margin-right:20px; " 
                                            data-provide="typeahead" data-items="4" name="filtro" id="filtro" onClick="this.value=''"/>
                                        </div>
                                        <div class="btn-group" style="vertical-align: 100%; margin-left:15px; float:left;">
                                            <button class="btn btn-primary" onClick="pesquisarDetalhe()">Buscar</button>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div id="lista_detalhe"></div>
                                    <script>listarDetalhes(<?=$idpedido?>)</script>
                                      <div class="space20"></div>
                                      <div class="space20"></div>
                                        <div class="row-fluid text-center">
                                            <a class="btn btn-primary btn-large hidden-print" onClick="javascript: history.go(-1)">Voltar</a>
                                        </div>
                                  </div>
                          </div>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE widget-->
                </div>
            </div>
     
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>
   <form name="frm" id="frm" action="impressao_pedido.php" target="impressao" method="post">
    <input type="hidden" name="idcliente" id="idcliente" value="<?=$idcliente?>">
    <input type="hidden" name="idpedido" id="idpedido" value="<?=$idpedido?>">
   </form>
   <iframe src="#" name="impressao" id="impressao" width="300" height="350" frameborder="0" style="display:none"></iframe>
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
   <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
   
   <script src="js/scripts.js"></script>
   
    
</body>
<!-- END BODY -->
</html>