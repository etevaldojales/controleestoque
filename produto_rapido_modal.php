<?php
include("config_inicio.php");
require_once($lib . 'classes/class.fornecedor.php');
require_once($lib . 'classes/class.marca.php');
require_once($lib . 'classes/class.categoria.php');
require_once($lib . 'classes/class.utilidades.php');
$util = new utilidades();

$_forn = new fornecedor($dbase);
$_cat = new categoria($dbase);
$_marca = new marca($dbase);

$where = "where stativo = 1";
$ordem = 'order by descricao';
$forns = $_forn->getList($where, '', $ordem);
$marcas = $_marca->getList($where, '', $ordem);
$cats = $_cat->getList($where, '', $ordem);

$codigo_pesquisado = $_POST['codigo'] ?? '';
?>
<div class="modal-header" style="background: linear-gradient(135deg, #4b5563, #1f2937); color: #fff; border-top-left-radius: 6px; border-top-right-radius: 6px; padding: 10px 20px;">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff; opacity: 0.8; font-size: 24px; line-height: 20px; font-weight: bold; background: transparent; border: 0;">×</button>
    <h3 id="myModalLabel1" style="margin: 0; font-weight: 600; font-size: 1.2rem; line-height: 1.5; color: #fff;">Cadastrar Novo Produto</h3>
</div>
<div class="modal-body" style="padding: 15px 20px; background-color: #f9fafb; overflow: hidden;">
    <form name="frmCadProdRapido" id="frmCadProdRapido" method="post" action="#" class="form-horizontal" style="margin: 0;">
        <?= $util->get_csrf_token_html() ?>
        <input type="hidden" name="id" value="0">
        
        <!-- Linha 1: Código e Nome -->
        <div class="row-fluid" style="margin-bottom: 8px;">
            <div class="span3">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 10px; text-transform: uppercase;">Código / Ref *</label>
                <input type="text" name="codigo" id="modal_codigo" value="<?= htmlspecialchars($codigo_pesquisado) ?>" required class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px 8px; box-sizing: border-box; font-size: 12px; background-color: #fff; line-height: 20px;">
            </div>
            <div class="span9">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 10px; text-transform: uppercase;">Nome do Produto *</label>
                <input type="text" name="nome" id="modal_nome" required class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px 8px; box-sizing: border-box; font-size: 12px; background-color: #fff; line-height: 20px;">
            </div>
        </div>

        <!-- Linha 2: Preço Compra, Preço Venda, Unidade -->
        <div class="row-fluid" style="margin-bottom: 8px;">
            <div class="span4">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 10px; text-transform: uppercase;">Preço Compra *</label>
                <input type="text" name="valor_compra" id="modal_valor_compra" onKeyPress="return(MascaraMoeda(this,'.',',',event))" required class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; text-align: right; padding: 4px 8px; box-sizing: border-box; font-size: 12px; background-color: #fff; line-height: 20px;">
            </div>
            <div class="span4">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 10px; text-transform: uppercase;">Preço Venda *</label>
                <input type="text" name="valor" id="modal_valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" required class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; text-align: right; padding: 4px 8px; box-sizing: border-box; font-size: 12px; background-color: #fff; line-height: 20px;">
            </div>
            <div class="span4">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 10px; text-transform: uppercase;">Unidade *</label>
                <select name="unidade" id="modal_unidade" required class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px; font-size: 12px; background-color: #fff; line-height: 20px;">
                    <option value="1">Unidade (Und)</option>
                    <option value="2">Quilo (Kg)</option>
                </select>
            </div>
        </div>

        <!-- Linha 3: Marca, Categoria, Fornecedor -->
        <div class="row-fluid" style="margin-bottom: 8px;">
            <div class="span4">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 10px; text-transform: uppercase;">Marca *</label>
                <select name="marca" id="modal_marca" required class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px; font-size: 12px; background-color: #fff; line-height: 20px;">
                    <option value="">Selecione</option>
                    <?php if (is_array($marcas)): foreach ($marcas as $m): ?>
                        <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['descricao']) ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
            <div class="span4">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 10px; text-transform: uppercase;">Categoria *</label>
                <select name="categoria" id="modal_categoria" required class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px; font-size: 12px; background-color: #fff; line-height: 20px;">
                    <option value="">Selecione</option>
                    <?php if (is_array($cats)): foreach ($cats as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['descricao']) ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
            <div class="span4">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 10px; text-transform: uppercase;">Fornecedor *</label>
                <select name="fornecedor" id="modal_fornecedor" required class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px; font-size: 12px; background-color: #fff; line-height: 20px;">
                    <option value="">Selecione</option>
                    <?php if (is_array($forns)): foreach ($forns as $f): ?>
                        <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['descricao']) ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
        </div>

        <!-- Linha 4: Qtd Inicial e Estoque Mínimo -->
        <div class="row-fluid">
            <div class="span6">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 10px; text-transform: uppercase;">Qtd Inicial Estoque</label>
                <input type="number" step="any" name="qtd" id="modal_qtd" value="0" class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px 8px; box-sizing: border-box; font-size: 12px; background-color: #fff; line-height: 20px;">
            </div>
            <div class="span6">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 10px; text-transform: uppercase;">Estoque Mínimo</label>
                <input type="number" step="any" name="estqmin" id="modal_estqmin" value="0" class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px 8px; box-sizing: border-box; font-size: 12px; background-color: #fff; line-height: 20px;">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer" style="background-color: #f3f4f6; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; padding: 10px 20px; text-align: right; border-top: 1px solid #e5e7eb;">
    <button class="btn" data-dismiss="modal" aria-hidden="true" style="border-radius: 6px; padding: 6px 14px; font-weight: 500; font-size: 12px;">Cancelar</button>
    <button type="button" class="btn btn-success" onClick="cadastrarProdutoRapido()" id="btnSalvarProdRapido" style="border-radius: 6px; padding: 6px 18px; font-weight: 600; font-size: 12px; background-color: #059669; background-image: none; border: none; text-shadow: none; box-shadow: none; color: #fff;">Salvar Produto</button>
</div>
