<?php
include("config_inicio.php");
require_once($lib."classes/class.pedido.php");
require_once($lib."classes/class.utilidades.php");
require_once($lib."classes/class.cliente.php");

$_class 	= new pedido($dbase);
$_cliente 	= new cliente($dbase);
$_util 		= new utilidades();

$cdpedido	= $_SESSION["codpedido"];
$formas		= $_class->getFormasPagamento();
$pedido		= $_class->get($cdpedido);
$cliente	= $_cliente->get($pedido['id_cliente']);
$numpedido	= $pedido['numero_pedido'] > 9 ? $pedido['numero_pedido'] : "0".$pedido['numero_pedido']; 
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
            <script src="js/venda.js" charset="ISO-8859-1"></script>
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
                        Forma de Pagamento / Parcelas
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
                            <h4><i class="icon-reorder"></i>CADASTRAR FORMA DE PAGAMENTO / GERAR PARCELAS</h4>
                        </div>
                        <div class="widget-body">
                            <form action="#" class="form-horizontal" name="frmFormPag" id="frmFormPag" method="post">
                            <div class="span6"> 
                                <!-- INICIO COLUNA A -->
                                <div class="control-group">
                                    <label class="control-label">CLIENTE</label>
                                    <input type="text" class="span10" name="cliente" id="cliente" tabindex="1" readonly value="<?=$cliente['nome']?>"/>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">PEDIDO Nº</label>
                                    <input type="text" class="span4" name="npedido" id="npedido" tabindex="3" readonly value="<?=$numpedido?>"/>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">FORMA DE PAGAMENTO</label>
                                    <select class="chosen" style="width:50%;" data-placeholder="Selecione" tabindex="5" name="formpag" id="formpag">
                                      <option value="">SELECIONE</option>
                                      <?
                                      foreach($formas as $f) {
										  if($f['id'] == 4) {
										  ?>
										  <option value="<?=$f['id']?>" selected><?=$f['descricao']?></option>
										  <?
										  }
										  else {
										  ?>
										  <option value="<?=$f['id']?>"><?=$f['descricao']?></option>
										  <?
										  }
									  }
									  ?>
                                    </select>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">PRIMEIRO VENCIMENTO</label>
                                    <div class="input-append date date-picker" data-date="01-01-2014" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                        <input class=" m-ctrl-medium date-picker span10" size="10" type="text" name="primvenc" id="primvenc" 
                                        data-date-format="dd/mm/yyyy" value="<?=date("d/m/Y")?>"/>
                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <!--FIM COLUNA A-->
                            <div class="span6"> <!-- INICIO COLUNA B -->
                                <div class="control-group">
                                    <label class="control-label">ENDEREÇO</label>
                                    <input type="text" class="span10" name="endereco" id="endereco" tabindex="2" readonly value="<?=$cliente['endereco']?>"/>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">VALOR PEDIDO</label>
                                    <input type="text" class="span4	" name="valorpedido" id="valorpedido" tabindex="4" readonly 
                                    value="R$ <?=number_format($pedido['valor'],2,",",".")?>" style="text-align:right"/>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Nº DE PARCELAS</label>
                                    <select class="chosen" style="width:50%;" data-placeholder="Selecione" tabindex="5" name="numparc" id="numparc">
                                      <option value="">SELECIONE</option>
                                      <option value="1" selected>01</option>
                                      <option value="2">02</option>
                                      <option value="3">03</option>
                                      <option value="4">04</option>
                                      <option value="5">05</option>
                                      <option value="6">06</option>
                                      <option value="7">07</option>
                                      <option value="8">08</option>
                                      <option value="9">09</option>
                                      <option value="10">10</option>
                                    </select>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">OBSERVAÇÃO</label>
                                    <textarea name="obs" id="obs" rows="1" cols="35" class="span8"></textarea>
                                </div>
                            </div>  <!--FIM COLUNA B-->
                            <div class="row-fluid"></div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-success" onClick="validar()" id="btnCad" tabindex="7">Cadastrar / Gerar Parcelas</button>
                                &nbsp;&nbsp;
                                <button data-placement="left" class="btn btn-success" data-toggle="modal" href="#myModal1" 
                                onclick="exibirFormEntrada(<?=$cdpedido?>)" id="btnEtrada">
                                    <i class="icon-money icon-white"></i> Entrada
                                </button>
                            </div>
                            <input type="hidden" name="id" id="id" value="<?=$cdpedido?>">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row-fluid" id="parcelas"></div>
            </div>
            <!--MODAL-->
            <div id="myModal1"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            </div>
            <!--MODAL FIM  -->
            
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
   <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>   
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js" charset="ISO-8859-1"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
   <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
   <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
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
   <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
   <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.js"></script>
   <script src="js/scripts.js"></script>
   
    
</body>
<!-- END BODY -->
</html>