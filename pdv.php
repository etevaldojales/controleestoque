<?php
include("config_inicio.php");
require_once($lib . 'classes/class.produto.php');

$_class = new produto($dbase);

$where = "where 1 = 1";
$ordem = 'order by nome';
$dados = $_class->getList($where, '', $ordem);
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

<body class="fixed-top" onload="document.getElementById('codigo').focus();">
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

                  <h3 class="page-title">PDV - PONTO DE VENDA</h3>
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <div class="space10"></div>
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM widget-->
                  <div class="widget">
                     <div class="widget-title">
                        <h4><i class="icon-reorder"></i> PRODUTOS</h4>
                        <span class="tools">
                           <a href="javascript:;" class="icon-chevron-down"></a>
                           <a href="javascript:;" class="icon-remove"></a>
                        </span>
                     </div>
                     <div class="widget-body form">
                        <?php
                        $lib = '.';
                        require_once($lib . '/lib/classes/class.utilidades.php');
                        $util = new utilidades();
                        $util->generate_csrf_token();
                        ?>
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal" autocomplete="off">
                           <?= $util->get_csrf_token_html() ?>

                           <div class="control-group"
                              style="margin-left: 0px; margin-right: 0px; border: 2px solid; border-radius: 10px;">
                              <div class="controls span4"
                                 style="margin-left: 15px; margin-right: 0px; margin-top: 10px; margin-bottom: 10px;">
                                 <input type="hidden" name="cliente" id="cliente" value="1">
                                 <select name="produto" id="produto" data-placeholder="Selecione"
                                    class="chosen-with-diselect span10" tabindex="1"
                                    onChange="getProdutoId(this.value)">
                                    <option value="">Selecione um produto</option>
                                    <?php
                                    if (is_array($dados)) {
                                       foreach ($dados as $d) {
                                          ?>
                                          <option value="<?= $d['id'] ?>"><?= $d['nome'] ?></option>
                                          <?php
                                       }
                                    }
                                    ?>
                                 </select>
                              </div>

                           </div>
                           <div class="control-group"
                              style="margin-left: 0px; margin-right: 0px; border: 1px solid; width: 49%; float: left; border-radius: 10px;">
                              <div class="control-group">
                                 <div class="controls span4"
                                    style="margin-left: 15px; margin-right: 0px; margin-top: 10px; margin-bottom: 10px; width: 95%;">
                                    <div class="controls" style="margin-left: 0px; margin-right: 0px; margin-top">
                                       <label for="codigo"
                                          style="margin-left: 15px; margin-right: 0px; margin-top: 10px; margin-bottom: 5px;"><b>Código</b></label>
                                       <input type="text" name="codigo" id="codigo" tabindex="2" placeholder="Código"
                                          onclick="this.value=''" autocomplete="off"
                                          style="margin-left: 15px; margin-right: 0px; margin-top: 2px; margin-bottom: 10px; width: 20%; height: 30px;">
                                       <span id="desc_produto" style="margin-left: 8px"></span>
                                    </div>
                                    <div class="controls" style="margin-left: 5px; margin-right: 0px; margin-top: 10px; margin-bottom: 10px; width: 50%; 
                                       float: left; text-align: center;">
                                       <img src="img/no_produto.png" alt="" id="img_produto"
                                          style="width: 264px;  border-radius: 10px; border: 1px solid;">
                                    </div>
                                    <div class="controls"
                                       style="margin-left: 15px; margin-right: 0px; margin-top: 10px; margin-bottom: 10px;">
                                       <input type="text" name="peso" id="peso" tabindex="3" readonly="readonly"
                                          placeholder="Qtd / Peso (kg)" autocomplete="off"
                                          style="margin-left: 15px; margin-right: 0px; margin-top: 4px; margin-bottom: 10px; height: 40px; width: 17%;">

                                       <input type="number" name="qtd" id="qtd" tabindex="3" placeholder="Qtd" autocomplete="off"
                                          style="margin-left: 15px; margin-right: 0px; margin-top: 4px; margin-bottom: 10px; height: 40px; width: 17%; display: none;">


                                       <input type="text" name="qtd_estoque" id="qtd_estoque" tabindex="3"
                                          readonly="readonly" placeholder="Estoque"
                                          style="margin-left: 15px; margin-right: 0px; margin-top: 10px; margin-bottom: 10px; width: 17%; height: 40px;">

                                       <input type="text" name="valor_unitario" id="valor_unitario" tabindex="4"
                                          placeholder="Valor Unitário"
                                          style="width: 40%; height: 40px; margin-left: 15px; margin-top: 10px; text-align: right;"
                                          readonly="readonly">
                                       <input type="hidden" name="vr_unitario" id="vr_unitario">
                                       <p id="medida"></p>
                                       <input type="text" name="data_hora" id="data_hora" tabindex="4"
                                          value="Fortaleza, <?= date('d/m/Y') ?>"
                                          style="width: 40%; height: 40px; margin-left: 15px; margin-top: 10px; text-align: right;"
                                          readonly="readonly">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="control-group"
                              style="margin-left: 20px; margin-right: 0px; border: 1px solid; width: 49%; float: left; border-radius: 10px;">
                              <div class="control-group">
                                 <div class="controls span11"
                                    style="margin-left: 15px; margin-right: 0px; margin-top: 10px; margin-bottom: 10px; width: 95%;">
                                    <div class="row-fluid" id="itens" style="margin-left: -2%;"></div>
                                 </div>
                              </div>
                           </div>

                        </form>
                        <!-- END FORM-->
                     </div>
                  </div>
                  <!-- END SAMPLE FORM widget-->
               </div>
            </div>

            <!-- BEGIN PAGE CONTENT-->



         </div>
         <!-- END PAGE CONTAINER-->
         <!--MODAL-->
         <!--FIM MODAL-->
      </div>
      <!-- END PAGE -->

   </div>
   <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
      aria-hidden="true" style="width:450px; margin-left: -130px;"></div>
   <!-- END CONTAINER -->
   <!-- BEGIN FOOTER -->
   <?php
   include("rodape.php");
   ?>
   <!-- END FOOTER -->
   <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="js/jquery-1.8.3.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

   <script src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
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
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
   <script src="js/venda.js" charset="utf-8"></script>
   <script>
      jQuery(document).ready(function () {
         // initiate layout and plugins
         App.init();
         $('#peso').mask('#.##0,000', { reverse: true });
         carregarItensPdv();
      });
   </script>
   <!-- END JAVASCRIPTS -->

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