<?php
include("config_inicio.php");
require_once($lib.'classes/class.produto.php');

$_class    	= new produto($dbase);
;

$where 		= "where p.stativo = 1 and m.stativo = 1 and f.stativo = 1 and c.stativo = 1";
$ordem		= 'order by id';
$dados 		= $_class->getList($where,'',$ordem);
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
		<script src="js/estoque.js" charset="utf-8"></script>
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
                     Cadastrar Estoque<small></small>
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
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a> <a href="javascript:;" class="icon-remove"></a> 
                            </span> 
                        </div>
						<div class="widget-body">
							<form action="#" class="form-horizontal" name="frmEstoque" id="frmEstoque" method="post">
                            <div class="span6"> 
                              <!-- INICIO COLUNA A -->
                                <div class="control-group">
                                    <label class="control-label">Produto</label>
                                    <select class="chosen" style="width:70%;" data-placeholder="Selecione" tabindex="1" 
                                    name="produto" id="produto" onChange="veirificarEstoque(this.value)">
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
                               <div class="control-group">
                                    <label class="control-label">Entrada</label>
                                    <input type="number" style="width:20%;" name="qtdentrada" id="qtdentrada" tabindex="2"/>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Saída</label>
                                    <input type="number" style="width:20%;" name="qtdsaida" id="qtdsaida" tabindex="3"/>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Nº Nota Fiscal</label>
                                    <input type="number" style="width:20%;" name="num_nf" id="num_nf" tabindex="3"/>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Estoque Mínimo</label>
                                    <input type="number" style="width:20%;" name="estoque_minimo" id="estoque_minimo" tabindex="4" onClick="this.value=''"/>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Quantidade Acumulada</label>
                                    <input type="number" style="width:20%;" name="qtdacumulada" id="qtdacumulada" readonly value="0"/>
                                </div>
                                <div style="clear:both"></div>
                                <div class="form-actions">
                                    <button type="button" class="btn btn-success" onClick="validar()">Cadastrar</button>
                                    <button type="button" class="btn" onClick="limparcampos()">Cancelar</button>
                                </div>
								</form>                                
                            </div>
                            <!--FIM COLUNA A-->
                            <div class="span6"> <!-- INICIO COLUNA B -->
                                <div class="control-group">
                                    <div class="control-group span6">
                                        <input type="text" placeholder="Pesquisar" class="span12" style="margin-right:20px;" 
                                        data-provide="typeahead" data-items="4" name="parametro" id="parametro" onClick="this.value=''" 
                                        onKeyPress="pesquisarPNome(this.value)"/>
                                    </div>
                                    <div class="btn-group" style="vertical-align: 100%;margin-left:10px;">
                                        <button class="btn btn-primary" onClick="pesquisar()">Buscar</button>
                                    </div>
                                </div>
                            	<div id="lista"></div>
                                <script>//listar(1);</script>
                            </div>
                			<div class="form-actions">
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
         listar(1);
      });
   </script>
   <!-- END JAVASCRIPTS -->  
   
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
</body>
<!-- END BODY -->
</html>