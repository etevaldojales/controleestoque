<?php
include("config_inicio.php");
$_usu = new usuario($dbase);
$_secoes 	= new secoes($dbase);
$cdusu 		= $_POST["id"] != "" ? $_POST["id"] : 0;
$sec 		= $_secoes->getSecSub($cdusu);
$usu 		= $_usu->getList('where 1 = 1','order by nome'); 
?>
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="css/style.css" rel="stylesheet" />
   <link href="css/style_responsive.css" rel="stylesheet" />
   <link href="css/style_gray.css" rel="stylesheet" type="text/css" id="style_color" />
   <link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />

   <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
   <link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <script src="lib/js/ajax.js"></script>
   <script src="js/usuario.js" charset="ISO-8859-1"></script>

<div class="widget-title">
    <h4><i class="icon-user"></i>Permissões</h4>
</div>

<!-- BEGIN FORM-->
<form action="#" class="form-horizontal" name="frmPerm" id="frmPerm" method="post">
    <div class="control-group" id="permissoes" style="margin-left:15px;">
    <?php
    if(is_array($sec)) {
        foreach($sec as $s) {
            if($s['subsecao'] != "") {
				if($_secoes->getSubSecaoUsuario($cdusu,$s['idsub'])) {
					$checksb = "checked"; 
				}
				else {
					$checksb = ""; 
				}
				?>
				<label class="control-label"><nobr><?=$s['secao']?> - <?=$s['subsecao']?></nobr></label>
				<div class="controls">
					<div class="basic-toggle-button">
						<input type="checkbox" class="toggle" <?=$checksb?> name="chksecao[]" id="chksecao" 
						value="<?=$s['id']."_".$s['idsub']?>"/>
					</div>
				</div>
				<?php	
            }
            else {
				if($_secoes->getSecaoUsuario($cdusu,$s['id'])) {
					$checks = "checked"; 
				}
				else {
					$checks = ""; 
				}
				?>
				<label class="control-label"><nobr><?=$s['secao']?></nobr></label>
				<div class="controls">
					<div class="basic-toggle-button">
						<input type="checkbox" class="toggle" <?=$checks?> name="chksecao[]" id="chksecao" 
						value="<?=$s['id']?>"/>
					</div>
				</div>
				<?php
            }
        }
    }
    ?>
    </div>
    <div class="form-actions">
        <button type="button" class="btn btn-success" onClick="cadastrarPermissoes()" id="btnPermissao">Cadastrar</button>
        <button type="reset" class="btn" id="btnCancela">Cancel</button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span id="loadperm" style="display:none"><img src="img/loading.gif">&nbsp;&nbsp;Processando...</span>
    </div>
    <input type="hidden" name="usuario" id="usuario" value="<?=$cdusu?>">
</form>
<form name="frmgperm" id="frmgperm" action="usuarios.php" method="post">
    <input type="hidden" name="codigo" id="codigo">
</form>
<div class="space20"></div>

   <!-- END FOOTER -->
   <!-- BEGIN JAVASCRIPTS -->    
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="js/jquery-1.8.2.min.js"></script>    
   <script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap/js/bootstrap-fileupload.js"></script>
   <script src="js/jquery.blockui.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="assets/clockface/js/clockface.js"></script>
   <script type="text/javascript" src="assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>   
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
   <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
   <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
   <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
   <script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
   <script src="js/scripts.js"></script>
   <script>
      jQuery(document).ready(function() {       
         // initiate layout and plugins
         App.init();
      });
   </script>
   <!-- END JAVASCRIPTS -->   
