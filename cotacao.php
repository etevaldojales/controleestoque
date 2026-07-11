<?php
include("config_inicio.php");
require_once($lib.'classes/class.fornecedor.php');
require_once($lib.'classes/class.marca.php');
require_once($lib.'classes/class.categoria.php');

$_forn    	= new fornecedor($dbase);
$_cat    	= new categoria($dbase);
$_marca    	= new marca($dbase);
;

$where 		= "where 1 = 1";
$ordem		= 'order by descricao';
$forns		= $_forn->getList($where,'',$ordem);
$marcas		= $_marca->getList($where,'',$ordem);
$cats		= $_cat->getList($where,'',$ordem);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>LOJA - DEMO</title>
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
       <?
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
        include ("menu.php"); 
        ?> 
        <script language="javascript" src="js/cotacoes.js"></script>
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
                     Cotação
                     <small></small>
                  </h3>
               </div>
            </div>
            <!-- END PAGE HEADER-->

            <div class="space10"></div>
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span6">
               <div class="widget">
            <div class="widget-title">
              <h4><i class="icon-reorder"></i>CADASTRAR COTAÇÃO</h4>
              <span class="tools"> <a class="icon-chevron-down" href="javascript:;"></a> <a class="icon-remove" href="javascript:;"></a> </span> </div>
            <div class="widget-body">
              <form class="form-horizontal" action="#" name="frmCotacao" id="frmCotacao" method="post">
                <div class="span6"> 
                <!-- INICIO COLUNA A -->
                    <div class="control-group">
                    <label class="control-label">DATA</label>
                    <?=date("d/m/Y")?>
                    <input type="hidden" name="data" id="data" value="<?=date("d/m/Y")?>">
                    </div>
                    <div class="control-group">
                    <label class="control-label">Fornecedor</label>
                     <select class="chosen" style="width:220px;" data-placeholder="Selecione" tabindex="1" name="fornecedor" id="fornecedor">
                    <option value=""></option>
                    <?
                    if(is_array($forns)) {
                        foreach($forns as $f) {
                        ?>
                        <option value="<?=$f['id']?>"><?=$f['descricao']?></option>
                        <?	
                        }
                    }
                    ?>
                    </select>
                    </div>
                    
                    <div class="control-group">
                     <label class="control-label">Marca</label>
                     <select class="chosen" style="width:200px;"  data-placeholder="Selecione" tabindex="1" name="marca" id="marca">
                    <option value=""></option>
                    <?
                    if(is_array($marcas)) {
                        foreach($marcas as $m) {
                        ?>
                        <option value="<?=$m['id']?>"><?=$m['descricao']?></option>
                        <?	
                        }
                    }
                    ?>
                    </select>
                    </div>
                    <div class="control-group">
                     <label class="control-label">Referência</label>
                     <input type="text" style="margin: 0 auto;" data-provide="typeahead" data-items="4" name="codigo" id="codigo">
                    </div>
                    <div class="control-group">
                        <label class="control-label">Observações</label>
                        <input type="text" style="width:450px;" name="observacao" id="observacao"/>
                    </div>
                </div>
                <!--FIM COLUNA A-->
                <div class="span6"> <!-- INICIO COLUNA B -->
                    <div class="control-group">
                        <label class="control-label">Preço</label>
                        <input type="text" class="width-inputs" name="valor" id="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" 
                        style="text-align:right"/>
                    </div>
                    <!--Ipi com percentual de 0%, 5%, 8%, 10%, 12%, 15% para cálculo do preço final St = substituição tributárias-->
                    <div class="control-group">
                        <label class="control-label">IPI</label>
                        <select class="chosen" style="width:220px;margin-top:" data-placeholder="Selecione" name="ipi" id="ipi" onChange="calcularValor(this.value)">
                        <option value=""></option>
                        <option value="0">0%</option>
                        <option value="5">5%</option>
                        <option value="8">8%</option>
                        <option value="10">10%</option>
                        <option value="12">12%</option>
                        <option value="15">15%</option>
                        </select>
                    </div>
                    <!-- Preço final calcular automatico preço + IPI = preço final  -->
                    <div class="control-group">
                        <label class="control-label">Preço Final</label>
                        <input type="text" class="width-inputs" name="valorf" id="valorf" onKeyPress="return(MascaraMoeda(this,'.',',',event))" 
                        style="text-align:right" disabled/>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Categoria</label>
                        <select class="chosen" style="width:220px;" data-placeholder="Selecione" tabindex="1" name="categoria" id="categoria">
                        <option value=""></option>
						<?
                        if(is_array($cats)) {
                            foreach($cats as $c) {
                            ?>
                            <option value="<?=$c['id']?>"><?=$c['descricao']?></option>
                            <?	
                            }
                        }
                        ?>
                        </select>
                    </div>
                </div>  <!--FIM COLUNA B-->
                <div class="row-fluid"></div>
                <div class="form-actions">
                  <button class="btn btn-success" type="button" id="btnCad" onClick="validar()">Cadastrar</button>
                  <button class="btn" type="button" onClick="limpacampos()">Cancelar</button>
                </div>
                <input type="hidden" name="id" id="id" value="0">
              </form>
            </div>
          </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-reorder"></i>ÚLTIMAS COTAÇÕES</h4>
                </div>
                <div class="widget-body">
                    <div class="invoice-date-range span12 form">
						<form class="form-horizontal form-row-seperated" action="#">
                        <div class="control-group span2">
							<input type="text" placeholder="Pesquisar" class="control-label" style="margin-right:20px;" 
                            data-provide="typeahead" data-items="4" name="parametro" id="parametro"/>
                        </div>
                        <div class="btn-group" style="vertical-align: 100%;">
                            <select class="control-label" style="margin-left:14px;" data-placeholder="Selecione" tabindex="1" name="tipo" id="tipo">
                            <option value="1">Referência</option>
                            <option value="2">Linha de Produtos</option>
                            <option value="3">Fornecedor</option>
                            </select>
                            <button class="btn btn-primary" onClick="pesquisar()">Buscar</button>
                        </div>
						</form>
                    </div>
                    <div style="clear:both"></div>
                    <div id="lista"></div>
                    <script>listar(1);</script>>
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
</body>
<!-- END BODY -->
</html>