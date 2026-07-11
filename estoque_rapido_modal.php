<?php
include("config_inicio.php");
require_once($lib . 'classes/class.produto.php');
require_once($lib . 'classes/class.estoque.php');
require_once($lib . 'classes/class.utilidades.php');
$util = new utilidades();

$_produto = new produto($dbase);
$_estoque = new estoque($dbase);

$id = (int)($_POST['id'] ?? 0);
$codigo = $_POST['codigo'] ?? '';

$produto = null;
if ($id > 0) {
    $produto = $_produto->get($id);
} else if (!empty($codigo)) {
    $produto = $_produto->getBycodigo($codigo);
}

if (!$produto) {
    ?>
    <div class="modal-header" style="background-color: #ef4444; color: #fff; border-top-left-radius: 6px; border-top-right-radius: 6px; padding: 15px 20px;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff; opacity: 0.8; font-size: 24px; line-height: 20px; font-weight: bold; background: transparent; border: 0;">×</button>
        <h3 style="margin: 0; font-weight: 600; font-size: 1.4rem;">Produto não encontrado</h3>
    </div>
    <div class="modal-body" style="padding: 20px;">
        <p>Não foi possível carregar as informações do produto.</p>
    </div>
    <div class="modal-footer" style="padding: 15px 20px; text-align: right; background-color: #f3f4f6;">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
    </div>
    <?php
    exit;
}

$id = $produto['id'];
$estq_list = $_estoque->getList("where e.id_produto = " . intval($id));
$estq = !empty($estq_list) ? $estq_list[0] : null;
$qtdacumulada = $produto['qtdacumulado'] ?? 0;
$estqmin = $estq ? $estq['estoque_minimo'] : 0;
?>
<div class="modal-header" style="background: linear-gradient(135deg, #0ea5e9, #0284c7); color: #fff; border-top-left-radius: 6px; border-top-right-radius: 6px; padding: 15px 20px;">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff; opacity: 0.8; font-size: 24px; line-height: 20px; font-weight: bold; background: transparent; border: 0;">×</button>
    <h3 id="myModalLabel1" style="margin: 0; font-weight: 600; font-size: 1.4rem; line-height: 1.5; color: #fff;">Entrada de Estoque</h3>
</div>
<div class="modal-body" style="padding: 20px; background-color: #f9fafb;">
    <form name="frmEstoqueRapido" id="frmEstoqueRapido" method="post" action="#" class="form-horizontal" style="margin: 0;">
        <?= $util->get_csrf_token_html() ?>
        <input type="hidden" name="produto" id="modal_estq_produto_id" value="<?= $id ?>">
        <input type="hidden" name="qtdsaida" id="modal_estq_qtdsaida" value="0">
        
        <div class="row-fluid" style="margin-bottom: 8px;">
            <div class="span12">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 11px; text-transform: uppercase;">Produto:</label>
                <input type="text" readonly value="<?= htmlspecialchars($produto['codigo'] . ' - ' . $produto['nome']) ?>" class="span12" style="height: 30px; border-radius: 4px; background-color: #e5e7eb; border: 1px solid #d1d5db; padding: 4px 8px; box-sizing: border-box; font-size: 12px; color: #4b5563;">
            </div>
        </div>

        <div class="row-fluid" style="margin-bottom: 8px;">
            <div class="span6">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 11px; text-transform: uppercase;">Quantidade Entrada *</label>
                <input type="number" step="any" name="qtdentrada" id="modal_estq_qtdentrada" required class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px 8px; box-sizing: border-box; font-size: 12px; background-color: #fff;">
            </div>
            <div class="span6">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 11px; text-transform: uppercase;">Nº Nota Fiscal</label>
                <input type="number" name="num_nf" id="modal_estq_num_nf" class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px 8px; box-sizing: border-box; font-size: 12px; background-color: #fff;" placeholder="NF">
            </div>
        </div>

        <div class="row-fluid">
            <div class="span6">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 11px; text-transform: uppercase;">Estoque Mínimo *</label>
                <input type="number" step="any" name="estoque_minimo" id="modal_estq_minimo" value="<?= $estqmin ?>" required class="span12" style="height: 30px; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px 8px; box-sizing: border-box; font-size: 12px; background-color: #fff;">
            </div>
            <div class="span6">
                <label style="font-weight: bold; margin-bottom: 3px; color: #374151; font-size: 11px; text-transform: uppercase;">Estoque Atual</label>
                <input type="number" readonly id="modal_estq_acumulada" value="<?= $qtdacumulada ?>" class="span12" style="height: 30px; border-radius: 4px; background-color: #e5e7eb; border: 1px solid #d1d5db; padding: 4px 8px; box-sizing: border-box; font-size: 12px; color: #4b5563;">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer" style="background-color: #f3f4f6; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; padding: 15px 20px; text-align: right; border-top: 1px solid #e5e7eb;">
    <button class="btn" data-dismiss="modal" aria-hidden="true" style="border-radius: 6px; padding: 8px 18px; font-weight: 500; font-size: 13px;">Cancelar</button>
    <button type="button" class="btn btn-info" onClick="cadastrarEstoqueRapido()" id="btnSalvarEstqRapido" style="border-radius: 6px; padding: 8px 24px; font-weight: 600; font-size: 13px; background-color: #0284c7; background-image: none; border: none; text-shadow: none; box-shadow: none; color: #fff;">Salvar Estoque</button>
</div>
