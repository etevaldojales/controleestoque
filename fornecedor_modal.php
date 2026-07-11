<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel1">Cadastro de Fornecedor</h3>
    </div>
    <div class="modal-body">
    <p>
    <form name="frmCadFornMod" id="frmCadFornMod" method="post" action="#">
		<table width="1231" class="table table-bordered table-hover">
			<tr>
				<td align="left">
					<b>Fornecedor:</b>
					<input type="text" name="nmfornecedor" id="nmfornecedor">
				</td>
			</tr>
			<tr>
				<td class="2">
					<button type="button" class="btn btn-success" onClick="cadastrarFornecedor()" id="btnCadForn">Cadastrar</button>
				</td>
			</tr>
		</table>
    </form
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true" id="btnCloseModal">Fechar</button>
	</div>
</div>    