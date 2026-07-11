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

         <!-- END SIDEBAR MENU -->

        <script language="javascript" src="js/logs.js?v=2"></script>

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

                     Auditoria

                     <small></small>

                  </h3>

               </div>

            </div>

            <!-- BEGIN PAGE CONTENT-->

           <div class="row-fluid">

             <div class="span12">

                 <div class="widget">

                    <div class="span12">

                        <div class="widget">

                            <div class="widget-title">

                                <h4><i class="icon-globe"></i>AUDITORIA</h4>

                                <span class="tools">

                                    <a href="javascript:;" class="icon-chevron-down"></a>

                                    <a href="javascript:;" class="icon-remove"></a>

                                </span>                    

                            </div>

                            <div class="widget-body form">

                                <!-- BEGIN FORM-->

                                <div class="span2"> 

                                    <div class="control-group">

                                        <label class="control-label">de</label>

                                        <div class="input-append date date-picker" data-date="01-01-2014" data-date-format="dd/mm/yyyy" data-date-viewmode="years">

                                            <input class=" m-ctrl-medium date-picker" size="10" type="text" value="<?=date("d/m/Y")?>" name="dtini" id="dtini" 

                                            data-date-format="dd/mm/yyyy" style="width:100px;"/>

                                            <span class="add-on"><i class="icon-calendar"></i></span>

                                        </div>

                                    </div>

                                </div>

                                <div class="span2"> 

                                    <div class="control-group">

                                        <label class="control-label">à</label>

                                        <div class="input-append date date-picker" data-date="01-01-2014" data-date-format="dd/mm/yyyy" data-date-viewmode="years">

                                            <input class=" m-ctrl-medium date-picker" size="10" type="text" value="<?=date("d/m/Y")?>" name="dtfim" id="dtfim" 

                                            data-date-format="dd/mm/yyyy" style="width:100px"/>

                                            <span class="add-on"><i class="icon-calendar"></i></span>

                                        </div>

                                    </div>

                                </div>

                                <div class="space10"></div>

                                <button type="button" class="btn btn-success" onClick="pesquisarLogs(1)">OK</button>

                                <!-- END FORM-->

                            </div>

                        </div>

                    </div>

                    <div class="widget-body" id="lista"></div>

                    <script>pesquisarLogs(1)</script>

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

   <div id="footer">
	<?php
	include("rodape.php");
	?>
   </div>

   <!-- END FOOTER -->

   <!-- BEGIN JAVASCRIPTS -->    

   <!-- Load javascripts at bottom, this will reduce page load time -->

   <script src="js/jquery-1.8.3.min.js"></script>

   <script src="assets/bootstrap/js/bootstrap.min.js"></script>

   <script src="assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

   <script src="js/jquery.blockui.js"></script>

 <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>

   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>

   <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 

   <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

   <script type="text/javascript" src="assets/clockface/js/clockface.js"></script>

   <script type="text/javascript" src="assets/jquery-tags-input/jquery.tagsinput.min.js"></script>

   <script type="text/javascript" src="assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>

   <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js" charset="ISO-8859-1"></script>   

   <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>

   <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script> 

   <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  

   <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

   <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

   <script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>

   <script src="js/scripts.js" charset="ISO-8859-1"></script>

   <script>

      jQuery(document).ready(function() {       

         // initiate layout and plugins

         App.init();

      });

   </script>

   

    

</body>

<!-- END BODY -->

</html>