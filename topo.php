<link href="css/toast.css?v=2" rel="stylesheet" />
   <script src="js/toast.js?v=2"></script>
   <script src="js/saida.js"></script>	
   <script src="lib/js/ajax.js"></script>	
   <div id="header" class="navbar navbar-inverse navbar-fixed-top">
       <!-- BEGIN TOP NAVIGATION BAR -->
       <div class="navbar-inner">
           <div class="container-fluid">
               <!-- BEGIN LOGO -->
               <a class="brand" href="index.php" style="color:#FFF;font-size:22px">
                   Painel - Adm 
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
                               
                           <span class="username"><?=$_SESSION["nome_usuario"]?></span>
                               <b class="caret"></b>
                           </a>
                           <ul class="dropdown-menu">
                               <li><a href="javascript: void(0)" onClick="abrirMeusDados()"><i class="icon-user"></i>&nbsp;&nbsp;Meus Dados</a></li>
                               <li><a href="javascript: void(0)" onClick="logout()"><i class="icon-key"></i> Sair</a></li>
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
