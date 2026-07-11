<?php
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.usuario.php');


$_class    	= new usuario($dbase);
;

$parametro	= isset($_POST['parametro']) ? $_POST['parametro'] : "";


$where 		= "where 1 = 1";
if($parametro) {
	$where .= " and nome like '%$parametro%' ";	
}
$ordem		= 'order by nome';
$total    	= $_class->countRec($where);
$num      	= 10;
$paginas  	= ceil($total/$num);
$pag      	= $_POST["pagina"] != "" ? $_POST["pagina"] : 1;
$inicio   	= ($pag * $num) - $num; 
$limit   	= "LIMIT $inicio,$num"; 
//$inicio 	= 0;

$prox = $pag + 1;
$ant = $pag - 1;
$ultima_pag = ceil($total / $num);
$penultima = $ultima_pag - 1;	
$adjacentes = 2;
$dados 		= $_class->getList($where,$limit,$ordem);
?>
<link href="css/estilo.css" rel="stylesheet" />
<div class="widget">
    <div class="widget-body">
        <table class="table table-striped table-bordered" id="sample_1" width="100%">
            <tr>
                <td width="86%" class="hidden-phone">USUÁRIOS</td>
                <td width="14%" class="hidden-phone">OPÇÕES</td>
            </tr>
             <?php
             if(is_array($dados)) {
				 foreach($dados as $d) {
				 ?>
				 <tr class="odd gradeX">
                    <td class="hidden-phone"><?=$d['nome']?></td>
                    <td class="center hidden-phone">
                        <nobr>
                        <button data-original-title="Editar" data-placement="left" class="btn btn-danger tooltips" onClick="editar(<?=$d['id_usuario']?>)">
                            <i class="icon-edit icon-white"></i>
                        </button>
                        <button data-original-title="Excluir" data-placement="left" class="btn tooltips" onClick="excluir(<?=$d['id_usuario']?>)">
                            <i class="icon-remove-sign icon-white"></i> 
                        </button>
                        </nobr>
                    </td>  
				 </tr>
				 <?php
				 }
			 }
			 else {
				 ?>
				 <tr class="odd gradeX">
                    <td class="hidden-phone" colspan="2" style="text-align:center">NENHUM USUÁRIO CADASTRADO</td>
				 </tr>
				 <?php
			 }
			 ?>
        </table>
         <br>
        <div align="center">
        <?php
        if($paginas > 1) {
            include("paginacao.php");
        }
        ?>
        </div>
    </div>
</div>
