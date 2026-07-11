<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8" />
<title>Result Comercial</title>
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
       <div class="navbar-inner">
           <div class="container-fluid">
               <!-- BEGIN LOGO -->
               <a class="brand" href="index.php">
                   <img src="img/logo.png" alt="" />
               </a>
               <!-- END LOGO -->
               <!-- BEGIN RESPONSIVE MENU TOGGLER -->
               <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="arrow"></span>
               </a>
               <!-- END RESPONSIVE MENU TOGGLER -->
              
               <div class="top-nav ">
                   <ul class="nav pull-right top-menu" >
                     
                       <!-- BEGIN USER LOGIN DROPDOWN -->
                       <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                             
                           <span class="username">Nome do usuário</span>
                               <b class="caret"></b>
                           </a>
                           <ul class="dropdown-menu">
                              
                               <li><a href="login.php"><i class="icon-key"></i> Sair</a></li>
                           </ul>
                       </li>
                       <!-- END USER LOGIN DROPDOWN -->
                   </ul>
                   <!-- END TOP NAVIGATION MENU -->
               </div>
           </div>
       </div>
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
                     Cadastrar
                     Produtos<small></small>
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
              
              <span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a> <a href="javascript:;" class="icon-remove"></a> </span> </div>
            <div class="widget-body">
             
                <div class="span6"> 
                  <!-- INICIO COLUNA A -->
                   <form action="#" class="form-horizontal">
           
            <div class="control-group">
                    <label class="control-label">Categoria</label>
                    <select class="chosen" style="width:90%;" data-placeholder="Selecione" tabindex="1">
                      <option value=""></option>
                      <option value="28">Rolamentos</option>
                      <option value="27">Correias</option>
                      <option value="45">Mangueiras</option>
                     
                    </select>
                       </div>
                       
           
                  <div class="control-group">
                    <label class="control-label">Referência</label>
                    <input type="text" style="width:90%;"/>
                  </div>
                  
                    <div class="control-group">
                              <label class="control-label">Conversão (Palavras-chave)</label>
                            
                               
                                 <input id="tags_2" type="text" class="m-wra tags" value="" />
                       
                              
                           </div>
                           
                   <div class="control-group">
                    <label class="control-label">Marca</label>
                    <select class="chosen" style="width:90%;"  data-placeholder="Selecione" tabindex="1">
                      <option value=""></option>
                      <option value="28">Marca A</option>
                      <option value="27">Marca B</option>
                      <option value="45">Marca C</option>
                      <option value="36">Marca D</option>
                      <option value="35">Marca E</option>
                      <option value="44">Marca F</option>
                    </select>
                       </div>
                       
                       
                  
                    <div class="control-group">
                    <label class="control-label">Fornecedor</label>
                    <select class="chosen" style="width:90%;"  data-placeholder="Selecione" tabindex="1">
                      <option value=""></option>
                      <option value="28">Marca A</option>
                      <option value="27">B</option>
                      <option value="45">C</option>
                      <option value="36">D</option>
                      <option value="35">E</option>
                      <option value="44"> F</option>
                    </select>
                   
                  </div>
                  
                </div>
                <!--FIM COLUNA A-->
                
                <div class="span6"> <!-- INICIO COLUNA B -->
                
                
                  
                   <div class="control-group">
                    <label class="control-label">Preço</label>
                    <input type="text" style="width:90%;" />
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label">Prateleira</label>
                    <input type="text" style="width:90%;" />
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label">QTD</label>
                    <input type="text" style="width:90%;" />
                  </div>
                 
                 
                
                  
                  
                </div>
                
               
               
                
                <div class="form-actions">
                  <button type="submit" class="btn btn-success">Cadastrar</button>
                  <button type="button" class="btn">Cancelar</button>
                </div>
              </form>
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
   <div id="footer">
       Result Comercial</div>
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
     <script type="text/javascript" src="assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
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