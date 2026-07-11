<?php
include("config_inicio.php");
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
            <!-- BEGIN SIDEBAR MENU -->
            <?php
            include("menu.php");
            ?>
            <script src="js/marca.js" charset="utf-8"></script>
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
                            Marcas
                            <small></small>
                        </h3>
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <br>

                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
                    <div class="span6 sortable">
                        <!-- BEGIN SAMPLE FORMPORTLET-->
                        <div class="widget">
                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i>Cadastrar nova Marca</h4>
                                <span class="tools">
                                    <a href="javascript:;" class="icon-chevron-down"></a>
                                    <a href="javascript:;" class="icon-remove"></a>
                                </span>
                            </div>
                            <div class="widget-body">
                                <!-- BEGIN FORM-->
                                <form action="#" class="form-horizontal" name="frmMarca" id="frmMarca" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Nome da Marca</label>
                                        <div class="controls">
                                            <input type="text" class="input-large" name="marca" id="marca" />
                                            <span class="help-inline"></span>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="button" class="btn blue" id="btnCad" onClick="validar()"><i
                                                class="icon-ok"></i>Cadastrar</button>
                                        <button type="button" class="btn" onClick="limpacampos()"><i
                                                class=" icon-remove"></i>Cancelar</button>
                                    </div>
                                    <input type="hidden" name="id" id="id" value="0">
                                </form>
                                <!-- END FORM-->
                            </div>
                        </div>
                        <!-- END SAMPLE FORM PORTLET-->
                    </div>
                    <div class="span6">
                        <div class="widget">
                            <div class="widget-title">
                                <h4><i class="icon-user"></i>Marcas Cadastradas</h4>
                            </div>
                            <div class="widget-body">
                                <div class="control-group span4">
                                    <input type="radio" name="status" id="ativo" checked> Ativo
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="status" id="inativo"> Inativo
                                </div>
                                <div class="invoice-date-range span12 form">
                                    <div class="control-group span4">
                                        <input type="text" placeholder="Pesquisar" class="control-label"
                                            style="margin-left: -15px" data-provide="typeahead" data-items="4"
                                            name="parametro" id="parametro" onClick="this.value=''" />
                                    </div>
                                    <div class="btn-group" style="vertical-align: 77%; margin-left: 35px;">
                                        <button class="btn btn-primary" onClick="pesquisar()">Buscar</button>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                                <div id="lista"></div>
                                <script>listar(1);</script>
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
        jQuery(document).ready(function () {
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