<?php
include("config_inicio.php");
require_once($lib."classes/class.utilidades.php");
require_once($lib."classes/class.parcela.php");
require_once($lib."classes/class.pedido.php");

$_util	 	= new utilidades();
$_class 	= new parcela($dbase);
$_pedido  	= new pedido($dbase);

$datai 		= $_POST["datai"] != "" ? $_util->dataPhp2MySql($_POST["datai"]) : "";
$dataf 		= $_POST["dataf"] != "" ? $_util->dataPhp2MySql($_POST["dataf"]) : "";
$dados 		= $_class->getListDadosVenc($datai,$dataf);
?>
<style>
table.bordasimples {border-collapse: collapse;}

table.bordasimples tr td {border:1px solid #000;}
</style>
<h3 class="page-title">
	Relatório de Parcelas Vencida
</h3>

<div class="linhas" id="produtos_servicos_edicao">
<table width="100%" cellpadding="2" cellspacing="2" background="0">
	<tr bgcolor="#CCCCCC">
    	<td width="27%" align="center" style="line-height: 25px; font-size: 14px;"><b>Nome</b></td>
    	<td width="27%" align="center" style="line-height: 25px; font-size: 14px;"><b>Entrada</b></td>
        <td width="10%" align="center" style="line-height: 25px; font-size: 14px;"><b><nobr>Parcelas - Valor</nobr></b></td>
      	<td width="8%" align="center" style="line-height: 25px; font-size: 14px;"><b><nobr>Valor a Pagar</nobr></b></td>
    	<td width="6%" align="center" style="line-height: 25px; font-size: 14px;"><b>Telefone</b></td>
    	<td width="6%" align="center" style="line-height: 25px; font-size: 14px;"><b>E-mail</b></td>
    	<td width="6%" align="center" style="line-height: 25px; font-size: 14px;"><b>Observação</b></td>
    </tr>
    <?
    if(is_array($dados)) {
		$i = 0;
		$total = 0;
		$n = 1;
		$x = 1;
		$dtatual = date("Y/m/d");
		$valor = 0;
		$status = "";
		$z = 0;
		foreach($dados as $d) {
			$periodo = "";
			$valor = 0;
			$venc = $_class->getParcVencida($d['pedido'],$datai,$dataf);
			if(is_array($venc)) {
				if($_pedido->verificaEntrada($d['pedido']) > 0) {
					$entrada = $_pedido->getDadosEntrada($d['pedido']);
					$valor_entrada = $entrada['valor'] > 0 ? "R$ ".number_format($entrada['valor'],2,",",".") : " - ";
					if($entrada['flgstatus'] == 1 && $entrada['valor'] > 0) {
						$valor_entrada = "<font color='#FF0000'>".$valor_entrada."</font>";		
					}
					else {
						$valor_entrada = "<font color='#006666'>".$valor_entrada."</font>";		
					}
				}
				else {
					$valor_entrada = " - ";
				}
				$corlinha = $z%2 == 0 ? "#FFFFFF" :  "#CCCCCC";
				?>
				<tr bgcolor="<?=$corlinha?>">
                    <td align="left" style="line-height: 25px; font-size: 14px;">
                        <nobr><?=$d['nome']?></nobr>
                    </td>
                    <td align="center" style="line-height: 25px; font-size: 14px;">
                        <nobr><?=$valor_entrada?></nobr>
                    </td>
                    <td align="center" style="line-height: 25px; font-size: 14px;">
                    <table width="200" class="bordasimples" cellpadding="0" cellspacing="0">
                        <tr bgcolor="">
                        <?
                        if(is_array($venc)) {
                            foreach($venc as $v) {
                                $v['dia'] = $v['dia'] < 10 ? "0".$v['dia'] : $v['dia'];
                                $v['mes'] = $v['mes'] < 10 ? "0".$v['mes'] : $v['mes'];
                                $dias_atraso = diffData($v['vencimento'],$dtatual);
                                if($dias_atraso > 0 && $v['status'] == 1) {
                                    $cor = "#FF0000";
                                }
                                $periodo = "<font color='".$cor."'>".$v['dia']."/".$v['mes']."</font>";
                                $dias_atraso = diffData($v['vencimento'],$dtatual);
                                if($dias_atraso > 0 && $v['status'] == 1) {
                                    $valor_atualizado = calcularJuros($v['valor_parcela'],$dias_atraso);	
                                    $valor += $valor_atualizado;
                                    $valor_atualizado = "R$ ".number_format($valor_atualizado,2,",",".")."</p>";
                                    $cor = "#FF0000";
                                    $status = "";
                                }
                                $valor_parcela = "<font color='".$cor."'>".$valor_atualizado."</font>";
                                if(($dias_atraso > 0 && $v['status'] == 1) || ($v['status'] == 2)) {
                                ?>
                                    <td style="line-height: 25px; font-size: 14px;" width="150px" align="center">
                                    <nobr><?=$periodo?> - <?=$valor_parcela?></nobr>
                                    </td>
                                <?
                                }
                            }
                        }
                        ?>    
                        </tr>
                    </table>
                    </td>
                    <td align="center" style="line-height: 25px; font-size: 14px;">
                    <?
                    if($valor > 0) {
                    ?>
                        <font color="#FF0000"><nobr>R$ <?=number_format($valor,2,",",".")?></nobr></font>
                    <?
                    }
                    elseif($status == "A Vencer") {
                    ?>
                        <nobr><font color="#000000">A Vencer</font></nobr>
                    <?
                    }
                    elseif($v['status'] == 2 && $status == "") {
                    ?>
                        <nobr><font color="#006666">Quitado</font></nobr>
                    <?
                    }
                    ?>
                    </td>
                    <td align="center" style="line-height: 25px; font-size: 14px;">
                        <nobr><?=$d['telefone']?></nobr>
                    </td>
                    <td align="left" style="line-height: 25px; font-size: 14px;">
                        <nobr><?=$d['email']?></nobr>
                    </td>
                    <td align="left" style="line-height: 25px; font-size: 14px;">
                        <nobr><?=utf8_decode($d['observacao'])?></nobr>
                    </td>
				</tr>
			<?
            $i++;
            $z++;
            }
		}
	}
	?>
</table>   
<script>
window.print();
</script>
<?php
function diffData($data_inicial,$data_final) { // formato Y/m/d
	// Usa a função strtotime() e pega o timestamp das duas datas:
	$time_inicial = strtotime($data_inicial);
	$time_final = strtotime($data_final);
	// Calcula a diferença de segundos entre as duas datas:
	$diferenca = $time_final - $time_inicial; // 19522800 segundos
	// Calcula a diferença de dias
	$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
	// Exibe uma mensagem de resultado:
	return $dias;
}

function calcularJuros($valor_parcela,$dias_atraso) {
	$valor_multa = number_format((($valor_parcela * 2) / 100),2);
	//$perc_juros  = number_format(((10/30) / 100),2);
	$perc_juros  = (10/30);
	$valor_juros = number_format((($valor_parcela * $perc_juros) / 100),2);
	$valor_juros = ($valor_juros * $dias_atraso);
	$retorno	 = $valor_parcela + $valor_multa + $valor_juros;
	return $retorno;
}
