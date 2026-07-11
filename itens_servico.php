<?php
include("config_inicio.php");
require_once($lib.'classes/class.cliente.php');
require_once($lib.'classes/class.produto.php');
require_once($lib.'classes/class.pedido.php');

$_class    	= new cliente($dbase);
$_pedido   	= new pedido($dbase);
$_produto  	= new produto($dbase);
;

$idcli		= $_POST['idcliente'];
$cliente	= $_class->get($idcli);
// verificar pedido do cliente em aberto
$pedido 	= $_pedido->getPedido($idcli);
if(is_array($pedido)) {
	//carregar o id do pedido
	$idpedido 	= $pedido['id'];
}
else {
	//cadastrar pedido para o cliente
	$numpedido = $_pedido->getUltimoNumeroPedido();
	$data 		= date("Y/m/d");
	$idpedido = $_pedido->insert($idcli,$numpedido,$data,0,0,0,1,'');
}
$itens 		= $_pedido->getItens($idpedido);
$servico 	= $_pedido->getServico($idpedido);
?>
<div class="span12">
    <!-- BEGIN EXAMPLE TABLE widget-->
    <div class="widget">
        <div class="widget-title">
            <h4><i class="icon-reorder"></i>ITENS</h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>
                <a href="javascript:;" class="icon-remove"></a>
            </span>
        </div>
        <div class="widget-body">
            <div class="portlet-body">
              <div class="space15"></div>
              <div class="span4">
                <h4><b><?=$cliente['nome']?></b></h4>
                <p>
                	Endereço: <?=$cliente['endereco']?><br> 
                  	E-mail: <?=$cliente['email']?><br>
                  	Telefone: <?=$cliente['telefone']?><br>
                </p>
              </div>
                <div class="row-fluid"></div>
                <div class="row-fluid">
                    <div class="span12">
                      <h4>&nbsp;</h4>
                        <table class="table table-hover invoice-input">
                            <tr>
                                <th width="36">&nbsp;</th>
                                <th width="51">QTD</th>
                                <th width="116">NOME</th>
                                <th width="116">REFERÊNCIA</th>
                                <th width="190">MARCA</th>
                                <th width="180">FORNECEDOR</th>
                                <th width="114">PREÇO VENDA</th>
                                <th width="36">&nbsp;</th>
                                <th width="106">PREÇO FINAL</th>
                            </tr>
                            <?php
                            if(is_array($itens)) {
								$total = 0;
								$total_custo = 0;
								$total_venda = 0;
								$x = 1;
								foreach($itens as $i) {
									$produto = $_produto->get($i['id_produto']);			
									$marca	 = $_produto->getMarca($produto['id_marca']);  
									$forn	 = $_produto->getFornecedor($produto['id_fornecedor']);
									$ipi	 = $i['ipi'] > 0 ? ($i['ipi'] / 100) : 0;
									$valorv = $i['valor_unitario'] == 0 ? "" : number_format($i['valor_unitario'],2,",",".");
									$total 	+= $i['valor_total']; 
									$total_custo += ($i['valor_unitario_compra'] * $i['quantidade']);
									$total_venda += ($i['valor_unitario'] * $i['quantidade']);
								?>
								<tr>
                                    <td><button data-placement="left" class="btn btn-danger" onClick="excluirItem(<?=$i['id']?>)"> 
                                        <i class="icon-remove icon-white"></i></button>
                                    </td>
									<td>
                                    	<input type="text" class="input-mini" name="qtdi" id="qtdi<?=$x?>" value="<?=$i['quantidade']?>" style="width:30px;" 
                                        onKeyDown="capturarQtd(event, <?=$i['id']?>, this.value)">
                                    </td>
									<td><?=$produto['nome']?></td>
									<td><?=$produto['codigo']?></td>
									<td><?=$marca?></td>
									<td><?=$forn?></td>
									<td>
                                    	<input type="text" class="maskMoeda" name="valor_venda" id="valor_venda<?=$x?>" value="<?=$valorv?>" 
                                        style="width:60px;text-align:right" 
                                        onchange="alterarValorVenda(<?=$i['id']?>,<?=$i['valor_unitario_compra']?>,document.getElementById('qtdi<?=$x?>').value,this.value)" />
                                    </td>
                                    <td width="36">
                                        <a onClick="showCalculadora(<?=$i['id']?>,<?=$i['valor_unitario_compra']?>,document.getElementById('qtdi<?=$x?>').value,document.getElementById('valor_venda<?=$x?>').value)"
                                        data-toggle="modal" href="#myModal1" style="text-decoration:none">
                                            <img src="img/calculator.png" border="0" title="Calculadora">
                                        </a>
                                    </td>
									<td>R$ <?=number_format($i['valor_total'],2,",",".")?></td>
								</tr>
								<?php
								$x++;
								}
								$servico['valor'] = $servico['valor'] > 0 ? $servico['valor'] : "";
								?>
                               <tr>
                               		<td colspan="9">
                                        <div class="span4">
                                            <label class="control-label">Descrição Serviço</label>
                                            <div class="controls">
												<input type="text" class="span8" name="descricao" id="descricao" value="<?=$servico['descricao']?>"/>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <label class="control-label">Valor Serviço</label>
                                            <div class="controls">
												<input type="text" class="span5" name="valor_servico" id="valor_servico" 
                                           		onKeyPress="return(MascaraMoeda(this,'.',',',event))" style="text-align: right" 
                                           		value="<?=number_format($servico['valor'],2,",",".")?>"/>
                                            </div>
                                        </div>
                                        <div class="span4" style="margin-top: 25px;margin-left: -160px;">
                                            <a class="btn btn-primary" href="javascript: void(0)" 
                                            onClick="addServico(<?=$idpedido?>,document.getElementById('valor_servico').value,document.getElementById('descricao').value)">Adicionar</a>
                                        </div>
                               		</td>
                               </tr>
                                <tr>
                                	<td colspan="9">
                                        <div class="span4">
                                            <label class="control-label">Observações</label>
                                            <div class="controls">
                                                <textarea rows="3" class="input-xlarge" name="obs" id="obs"></textarea>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <label class="control-label">Data Pedido</label>
                                            <div class="input-append date date-picker" data-date="01-01-2014" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                                <input class=" m-ctrl-medium date-picker" size="16" type="text" value="<?=date("d/m/Y")?>" name="data" id="data" 
                                                data-date-format="dd/mm/yyyy"/>
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
								$total = $total + $servico['valor'];
								?>
                                <tr>
                                	<td colspan="9">
                                        <div class="span4 invoice-block pull-right">
                                            <ul class="unstyled amounts">
                                                <li><strong>Total :</strong> R$ <?=number_format($total,2,",",".")?></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="9">
                                        <div class="row-fluid text-center">
                                            <a class="btn btn-primary btn-large hidden-print" href="javascript: void(0)" 
                                            onClick="concluirPedido(<?=$idpedido?>,<?=$total?>,<?=$total_custo?>,<?=$total_venda?>)">Fechar Pedido</a>
                                        </div>
                                    </td>
                                </tr>
							<?php
							}
							else {
								$_pedido->deleteServico($idpedido);	
							?>
								<tr>
									<td colspan="9">Não há itens cadastrados para esse pedido</td>
								</tr>
							<?php		
							}
							?>
                        </table>
                  </div>
              </div>
          </div>
        </div>
    </div>
    <!-- END EXAMPLE TABLE widget-->
</div>
