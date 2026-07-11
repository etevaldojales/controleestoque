<?php
include("config_inicio.php");
require_once($lib . 'classes/class.fornecedor.php');
require_once($lib . 'classes/class.marca.php');
require_once($lib . 'classes/class.categoria.php');

$_forn = new fornecedor($dbase);
$_cat = new categoria($dbase);
$_marca = new marca($dbase);
require_once($lib . 'classes/class.utilidades.php');
$_util = new utilidades();

$where = "where stativo = 1";
$ordem = 'order by descricao';
$forns = $_forn->getList($where, '', $ordem);
$marcas = $_marca->getList($where, '', $ordem);
$cats = $_cat->getList($where, '', $ordem);
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
    <link rel="stylesheet" type="text/css" href="assets/jquery-ui/jquery-ui-1.10.1.custom.min.css" />
    <script src="js/jquery-1.8.3.min.js"></script>

    <script src="lib/js/ajax.js"></script>
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
            include("menu.php");
            ?>
            <script language="javascript" src="js/produtos.js?v=4" charset="utf-8"></script>
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
                            Cadastrar Produtos<small></small>
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
                                    <a href="javascript:;" class="icon-chevron-down"></a> <a href="javascript:;"
                                        class="icon-remove"></a>
                                </span>
                            </div>
                            <div class="widget-body">
                                <form action="#" class="form-horizontal" name="frmCadProd" id="frmCadProd" method="post"
                                    enctype="multipart/form-data" onsubmit="return validar();">
                                    <?= $_util->get_csrf_token_html() ?>
                                    <div class="row-fluid">
                                    <div class="span6">
                                        <!-- INICIO COLUNA A -->
                                        <div class="control-group">
                                            <label class="control-label">Produto</label>
                                            <input type="text" class="span10" name="nome" id="nome" tabindex="6"
                                                required />
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Preço Compra</label>
                                            <input type="text" style="width:30%;text-align:right;" name="valor_compra"
                                                id="valor_compra" onKeyPress="return(MascaraMoeda(this,'.',',',event))"
                                                tabindex="2" required />
                                            &nbsp;&nbsp;
                                            <a onClick="showCalculadora()" data-toggle="modal" href="#myModal1"
                                                style="text-decoration:none">
                                                <img src="img/calculator.png" border="0" title="Calculadora">
                                            </a>
                                            &nbsp;&nbsp;
                                            <label class="control-label" style="margin-left:36%;margin-top:-60px">Preço
                                                Venda</label>
                                            <input type="text" style="width:30%;text-align:right;" name="valor"
                                                id="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))"
                                                tabindex="2" required />
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Marca</label>
                                            <select class="chosen" style="width:60%;" data-placeholder="Selecione"
                                                name="marca" id="marca" tabindex="7" required>
                                                <option value=""></option>
                                                <?php
                                                if (is_array($marcas)) {
                                                    foreach ($marcas as $m) {
                                                        ?>
                                                        <option value="<?= $m['id'] ?>"><?= $m['descricao'] ?></option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <a onClick="showMarca()" data-toggle="modal" href="#myModal1"
                                                style="text-decoration:none">
                                                <img src="img/novo.png" style="margin-left: 10px;margin-top: -20px;">
                                            </a>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Categoria</label>
                                            <select class="chosen" style="width:60%;" data-placeholder="Selecione"
                                                tabindex="1" name="categoria" id="categoria" required>
                                                <option value=""></option>
                                                <?php
                                                if (is_array($cats)) {
                                                    foreach ($cats as $c) {
                                                        ?>
                                                        <option value="<?= $c['id'] ?>"><?= $c['descricao'] ?></option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <a onClick="showCategoria()" data-toggle="modal" href="#myModal1"
                                                style="text-decoration:none">
                                                <img src="img/novo.png" style="margin-left: 10px;margin-top: -20px;">
                                            </a>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Imagem</label>
                                            <input type="file" name="imagem" id="imagem" tabindex="5"
                                                style="width:50%;" />
                                            <div id="imagem-link" style="margin-top: 5px;"></div>
                                        </div>

                                        <!-- Modal for displaying product image -->
                                        <div id="imagemModal" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="imagemModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document"
                                                style="max-width: 600px;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="imagemModalLabel">Imagem do Produto
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img id="imagemModalImg" src="" alt="Imagem do Produto"
                                                            style="max-width: 100%; height: auto;" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--FIM COLUNA A-->
                                    <div class="span6"> <!-- INICIO COLUNA B -->
                                        <div class="control-group">
                                            <label class="control-label">Código</label>
                                            <input type="number" style="width:90%;" name="codigo" id="codigo"
                                                tabindex="3" required /><br>
                                            <span id="codigo-exists-msg"
                                                style="font-size: 12px; margin-left: 5px;"></span>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Local Físico</label>
                                            <input type="text" style="width:50%;" name="local" id="local"
                                                tabindex="4" />
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Fornecedor</label>
                                            <select class="chosen" style="width:60%;" data-placeholder="Selecione"
                                                name="fornecedor" id="fornecedor" tabindex="8" required>
                                                <option value=""></option>
                                                <?php
                                                if (is_array($forns)) {
                                                    foreach ($forns as $f) {
                                                        ?>
                                                        <option value="<?= $f['id'] ?>"><?= $f['descricao'] ?></option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <a onClick="showFornecedor()" data-toggle="modal" href="#myModal1"
                                                style="text-decoration:none">
                                                <img src="img/novo.png" style="margin-left: 10px;margin-top: -20px;">
                                            </a>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Qtd. <span style="margin-left:93px;">Estoque
                                                    Mínimo</span> <span style="margin-left:29px;">Und.
                                                    Medida</span><span style="margin-left:95px;">Nº NF</span></label>
                                            <input type="number" style="width:15%;" name="qtd" id="qtd" tabindex="6"
                                                onClick="this.value=''" />
                                            &nbsp;&nbsp;
                                            <input type="number" style="width:15%;" name="estqmin" id="estqmin"
                                                tabindex="7" value="0" onClick="this.value=''" />
                                            &nbsp;&nbsp;
                                            <select name="unidade" id="unidade" style="width:25%;">
                                                <option value="">Selecione</option>
                                                <option value="1">Unidade</option>
                                                <option value="2">Peso (Kg)</option>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="number" name="num_nf" id="num_nf" style="width:15%;"
                                                onClick="this.value=''">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success" id="btnCad">Cadastrar</button>
                                        <button type="button" class="btn" onClick="limpacampos()">Cancelar</button>
                                    </div>
                                    <input type="hidden" name="id" id="id" value="0">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnFechaModal"
                                        style="display: none">Fechar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget">
                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i>PRODUTOS CADASTRADOS</h4>
                            </div>
                            <div class="widget-body">
                                <div class="invoice-date-range span12 form">
                                    <div class="control-group span2">
                                        <input type="text" placeholder="Pesquisar" class="control-label"
                                            style="margin-right:20px;" data-provide="typeahead" data-items="4"
                                            name="parametro" id="parametro" onClick="this.value=''"
                                            onKeyPress="pesquisarPNome(this.value)" />
                                    </div>
                                    <div class="btn-group" style="vertical-align: 100%;margin-left:10%">
                                        <select class="control-label" style="margin-left:14px;"
                                            data-placeholder="Selecione" tabindex="1" name="tipo" id="tipo">
                                            <option value="1">Nome</option>
                                            <option value="2">codigo</option>
                                            <option value="3">Fornecedor</option>
                                            <option value="4">Marca</option>
                                            <option value="5">Categoria</option>
                                        </select>
                                        <button class="btn btn-primary" onClick="pesquisar()"
                                            style="margin-top:-10px;margin-left:5px;">Buscar</button>
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
            <!--MODAL-->
            <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
                aria-hidden="true"></div>
            <!--FIM MODAL-->
            <!-- END PAGE CONTAINER-->
        </div>
        <!-- END PAGE -->
    </div>
    <?php
    include("rodape.php");
    ?>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS -->
    <!-- Load javascripts at bottom, this will reduce page load time -->
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
        jQuery(document).ready(function () {
            // initiate layout and plugins
            App.init();
        });
    </script>
    <!-- END JAVASCRIPTS -->

    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>

    <script src="js/scripts.js"></script>


</body>
<!-- END BODY -->
<script>
    $(document).ready(function () {
        $('#codigo').on('blur', function () {
            checkCodigoExists();
        });
    });
</script>

</html>