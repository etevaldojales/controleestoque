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
                     Clientes
                     <small></small>
                  </h3>
               </div>
            </div>
            <!-- END PAGE HEADER-->

            <div class="space10"></div>
             
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
            
            
            <div class="span6"> 
          <!-- BEGIN EXAMPLE TABLE widget-->
          <div class="widget">
            <div class="widget-title">
              <h4><i class="icon-reorder"></i>CADASTRO DE FORNECEDOR</h4>
              <span class="tools"> <a href="javascript:;" class="icon-chevron-down"></a> <a href="javascript:;" class="icon-remove"></a> </span> </div>
            <div class="widget-body">
              <form action="#" class="form-horizontal">
                <div class="span6"> 
                  <!-- INICIO COLUNA A -->
                  
           
                  <div class="control-group">
                    <label class="control-label">Nome do Fornecedor</label>
                    <input type="text" class="span10"/>
                  </div>
                  
                  
                  
                        <div class="control-group">
                    <label class="control-label">E-mail</label>
                    <input type="text" class="span10"/>
                  </div>
                  
                  
                  
                  
                </div>
                <!--FIM COLUNA A-->
                
                <div class="span6"> <!-- INICIO COLUNA B -->
                  
                  <div class="control-group">
                    <label class="control-label">Telefone</label>
                    <input type="text" class="span10"/>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label">Nome do Contato</label>
                    <input type="text" class="span10"/>
                  </div>
 
                 
                   
                     
                   
                              
                  
                </div>  <!--FIM COLUNA B-->
                <div class="span12" style="margin-left:0px;">
                <div class="control-group">
                 <label class="control-label">Linha de Produtos</label>
                 <input id="tags_1" type="text" class="m-wra tags" value="" />
                 </div>
                 </div>
                <div class="row-fluid"></div>
               
                <div class="form-actions">
                  <button type="submit" class="btn btn-success">Cadastrar</button>
                  <button type="button" class="btn">Cancelar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        
     
             <div class="row-fluid">
               <div class="span12">
               
               
                 <div class="widget">
                   <div class="widget-title">
                     <h4><i class="icon-user"></i>FORNECEDORES CADASTRADOS</h4>
 
                     
                   </div>
                   <div class="widget-body">
                   
                   
<div class="invoice-date-range span12 form">


<form class="form-horizontal form-row-seperated" action="#">
<div class="control-group span2">

<input type="text" placeholder="Pesquisar" class="control-label" style="margin-right:20px;" data-provide="typeahead" data-items="4" data-source="[&quot;Alabama&quot;,&quot;Alaska&quot;,&quot;Arizona&quot;,&quot;Arkansas&quot;,&quot;California&quot;,&quot;Colorado&quot;,&quot;Connecticut&quot;,&quot;Delaware&quot;,&quot;Florida&quot;,&quot;Georgia&quot;,&quot;Hawaii&quot;,&quot;Idaho&quot;,&quot;Illinois&quot;,&quot;Indiana&quot;,&quot;Iowa&quot;,&quot;Kansas&quot;,&quot;Kentucky&quot;,&quot;Louisiana&quot;,&quot;Maine&quot;,&quot;Maryland&quot;,&quot;Massachusetts&quot;,&quot;Michigan&quot;,&quot;Minnesota&quot;,&quot;Mississippi&quot;,&quot;Missouri&quot;,&quot;Montana&quot;,&quot;Nebraska&quot;,&quot;Nevada&quot;,&quot;New Hampshire&quot;,&quot;New Jersey&quot;,&quot;New Mexico&quot;,&quot;New York&quot;,&quot;North Dakota&quot;,&quot;North Carolina&quot;,&quot;Ohio&quot;,&quot;Oklahoma&quot;,&quot;Oregon&quot;,&quot;Pennsylvania&quot;,&quot;Rhode Island&quot;,&quot;South Carolina&quot;,&quot;South Dakota&quot;,&quot;Tennessee&quot;,&quot;Texas&quot;,&quot;Utah&quot;,&quot;Vermont&quot;,&quot;Virginia&quot;,&quot;Washington&quot;,&quot;West Virginia&quot;,&quot;Wisconsin&quot;,&quot;Wyoming&quot;]" />



</div>
<div class="btn-group" style="vertical-align: 100%;">
<select class="control-label" style="margin-left:14px;" data-placeholder="Selecione" tabindex="1">
<option value="">Nome</option>
<option value="Category 2">Linha de Produtos</option>

</select>
<button class="btn btn-primary">Buscar</button>
</div>

</form>
</div>
                                
                     <!--BEGIN ABOUT US-->
                     <!--END ABOUT US-->
                     
                     <table class="table table-striped table-bordered" id="sample_1">
                       <thead>
                         <tr>
                           <td class="hidden-phone">EMPRESA</td>
                           <td class="hidden-phone">TELEFONE</td>
                           <td class="hidden-phone">E-MAIL</td>
                           <td class="hidden-phone">NOME DO CONTATO</td>
                           <td class="hidden-phone">OPÇÕES</td>
                         </tr>
                       </thead>
                       <tbody>
                         <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA A</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="center hidden-phone">Nome do Contato                           
                           <td class="center hidden-phone">

<button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
<i class="icon-edit icon-white"></i>
</button>
  
<button data-original-title="Excluir" data-placement="left" class="btn tooltips">
<i class="icon-remove-sign icon-white"></i>
</button>
                  
                             
                             
                         </tr>
                         <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA B</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="center hidden-phone">Nome do Contato
                           <td class="center hidden-phone">
                           <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
<i class="icon-edit icon-white"></i>
</button>
  
<button data-original-title="Excluir" data-placement="left" class="btn tooltips">
<i class="icon-remove-sign icon-white"></i>
</button></tr>
                         <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA C</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="center hidden-phone">Nome do Contato
                           <td class="center hidden-phone">
                            <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
                            <i class="icon-edit icon-white"></i>
                            </button>
                            <button data-original-title="Excluir" data-placement="left" class="btn tooltips">
                            <i class="icon-remove-sign icon-white"></i>
                            </button>
                           </tr>
                         <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA D</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="center hidden-phone">Nome do Contato </td>
                           <td class="center hidden-phone"> 
                           <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
                            <i class="icon-edit icon-white"></i>
                            </button>
                            <button data-original-title="Excluir" data-placement="left" class="btn tooltips">
                            <i class="icon-remove-sign icon-white"></i>
                            </button></td>
                         </tr>
                         <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA E</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="hidden-phone"><span class="center hidden-phone">Nome do Contato </span></td>
                           <td class="hidden-phone"> <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
                            <i class="icon-edit icon-white"></i>
                            </button>
                            <button data-original-title="Excluir" data-placement="left" class="btn tooltips">
                            <i class="icon-remove-sign icon-white"></i>
                            </button></td>
                         </tr>
                        <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA E</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="hidden-phone"><span class="center hidden-phone">Nome do Contato </span></td>
                           <td class="hidden-phone"> <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
                            <i class="icon-edit icon-white"></i>
                            </button>
                            <button data-original-title="Excluir" data-placement="left" class="btn tooltips">
                            <i class="icon-remove-sign icon-white"></i>
                            </button></td>
                         </tr>
                         <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA E</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="hidden-phone"><span class="center hidden-phone">Nome do Contato </span></td>
                           <td class="hidden-phone"> <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
                            <i class="icon-edit icon-white"></i>
                            </button>
                            <button data-original-title="Excluir" data-placement="left" class="btn tooltips">
                            <i class="icon-remove-sign icon-white"></i>
                            </button></td>
                         </tr>
                         <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA E</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="hidden-phone"><span class="center hidden-phone">Nome do Contato </span></td>
                           <td class="hidden-phone"> <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
                            <i class="icon-edit icon-white"></i>
                            </button>
                            <button data-original-title="Excluir" data-placement="left" class="btn tooltips">
                            <i class="icon-remove-sign icon-white"></i>
                            </button></td>
                         </tr>
                         <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA E</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="hidden-phone"><span class="center hidden-phone">Nome do Contato </span></td>
                           <td class="hidden-phone"> <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
                            <i class="icon-edit icon-white"></i>
                            </button>
                            <button data-original-title="Excluir" data-placement="left" class="btn tooltips">
                            <i class="icon-remove-sign icon-white"></i>
                            </button></td>
                         </tr>
                         <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA E</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="hidden-phone"><span class="center hidden-phone">Nome do Contato </span></td>
                           <td class="hidden-phone"> <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
                            <i class="icon-edit icon-white"></i>
                            </button>
                            <button data-original-title="Excluir" data-placement="left" class="btn tooltips">
                            <i class="icon-remove-sign icon-white"></i>
                            </button></td>
                         </tr>
                         <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA E</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="hidden-phone"><span class="center hidden-phone">Nome do Contato </span></td>
                           <td class="hidden-phone"> <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
                            <i class="icon-edit icon-white"></i>
                            </button>
                            <button data-original-title="Excluir" data-placement="left" class="btn tooltips">
                            <i class="icon-remove-sign icon-white"></i>
                            </button></td>
                         </tr>
                         <tr class="odd gradeX">
                           <td class="hidden-phone">EMPRESA E</td>
                           <td class="hidden-phone">(85) 0000.0000</td>
                           <td class="hidden-phone">result@resultcomercial.com.br</td>
                           <td class="hidden-phone"><span class="center hidden-phone">Nome do Contato </span></td>
                           <td class="hidden-phone"> <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips">
                            <i class="icon-edit icon-white"></i>
                            </button>
                            <button data-original-title="Excluir" data-placement="left" class="btn tooltips">
                            <i class="icon-remove-sign icon-white"></i>
                            </button></td>
                         </tr>
                       </tbody>
                     </table>
                   </div>
                 </div>
               </div>
           </div></div>
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
    <script type="text/javascript" src="assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
   
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