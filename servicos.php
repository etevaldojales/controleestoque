<?php
include("config_inicio.php");
require_once($lib.'classes/class.cliente.php');
require_once($lib.'classes/class.produto.php');

$_class    	= new cliente($dbase);
$_produto  	= new produto($dbase);
;

$where 		= "where stativo = 1";
$ordem		= 'order by nome';

$wherep		= "where 1 = 1";
$ordemp		= 'order by id';

$dados 		= $_class->getList($where,'',$ordem);
$dadosp		= $_produto->getList($wherep,'',$ordemp);
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
        include ("menu.php"); 
        ?> 
		<script src="js/servico.js" charset="ISO-8859-1"></script>
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
                     Pedidos
                     <small></small>
                  - Serviços</h3>
               </div>
            </div>
            <!-- END PAGE HEADER-->
           <div class="space10"></div>
             <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM widget-->   
                  <div class="widget">
                     <div class="widget-title">
                        <h4><i class="icon-reorder"></i> SERVIÇO</h4>
                        <span class="tools">
                           <a href="javascript:;" class="icon-chevron-down"></a>
                           <a href="javascript:;" class="icon-remove"></a>
                        </span>
                     </div>
                     <div class="widget-body form">
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
							<div class="control-group">
								<label class="control-label">Cliente:</label>
								<div class="controls">
									<select data-placeholder="Selecione" class="chosen-with-diselect span5" tabindex="1" id="cliente" name="cliente" 
									onChange="carregarItens()">
									<option value=""></option>
									<?
									if(is_array($dados)) {
										foreach($dados as $d) {
										?>
										<option value="<?=$d['id']?>"><?=$d['nome']?></option>
										<?	
										}
									}
									?>                                    
									</select>
								</div>
							</div>
							<div class="control-group">
								<fieldset>	
									<legend><h4><i class="icon-reorder"></i> Ítens do Serviço</h4></legend>
									<div class="control-group">
										<label class="control-label">Produto: </label>
										<select class="chosen-with-diselect span5" data-placeholder="Selecione" tabindex="1" 
										name="produto" id="produto" onChange="adicionarItem(this.value)">
											<option value=""></option>
											<?php
											if(is_array($dadosp)) {
												foreach($dadosp as $dp) {
												?>
												<option value="<?=$dp['id']?>"><?=$dp['nome']?></option>
												<?php	
												}
											}
											?>
										</select>
									</div>
								</fieldset>
							</div>
                        </form>
                        <!-- END FORM-->           
                     </div>
                  </div>
                  <!-- END SAMPLE FORM widget-->
               </div>
            </div>
           <div class="row-fluid" id="itens"></div>
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
        <!--MODAL-->
        <!--FIM MODAL-->
      </div>
      <!-- END PAGE -->  
	      
   </div>
   <div id="myModal1"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="width:450px;margin:0;"></div>
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
   <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js" charset="ISO-8859-1"></script>   
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js" charset="ISO-8859-1"></script> 
  <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
   <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

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