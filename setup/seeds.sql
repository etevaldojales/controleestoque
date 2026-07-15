SET foreign_key_checks = 0;

#
# Dados a serem incluídos na tabela
#

INSERT INTO secoes VALUES ('1', 'Usuários', 'usuario.php', '8', 'icon-cog')
,('3', 'Clientes', '', '5', 'icon-user')
,('2', 'Cadastrar Produtos', 'produtos_cadastrar.php', '3', 'icon-gift')
,('4', 'Pedidos', 'pedidos.php', '4', 'icon-shopping-cart')
,('5', 'Relatórios', '', '7', 'icon-pencil')
,('7', 'Estoque', '', '2', 'icon-th-large')
,('8', 'Cadastros', '', '6', 'icon-cogs')
,('9', 'Auditoria', 'logs.php', '9', 'icon-comment')
,('17', 'PDV', 'pdv.php', '1', 'icon-shopping-cart');

#
# Dados a serem incluídos na tabela
#

INSERT INTO subsecoes VALUES ('1', '3', 'Cadastrar', 'clientes.php')
,('2', '3', 'Vendas Realizadas', 'vendas_realizadas.php')
,('3', '8', 'Categorias', 'categorias.php')
,('4', '8', 'Fornecedores', 'fornecedor.php')
,('5', '8', 'Marcas', 'marcas.php')
,('6', '7', 'Cadastrar', 'estoque_cadastrar.php')
,('7', '7', 'Listar', 'estoque_listar.php')
,('8', '5', 'Rel. Movimento', 'relatorios.php')
,('9', '5', 'Prev. Receita', 'rel_prev_receitas.php')
,('10', '5', 'Parc. Vencida', 'rel_parc_vencida.php')
,('11', '5', 'Rel. Baixa', 'rel_baixa.php')
,('12', '8', 'Bancos', 'bancos.php')
,('21', '8', 'Empresa', 'empresa.php')
,('22', '5', 'Rel. Sintético', 'rel_sintetico.php');

#
# Dados a serem incluídos na tabela
#

INSERT INTO tblbancos VALUES ('1', 'include/funcoes_bb.php', 'include/layout_bb.php', '0')
,('2', 'include/funcoes_cef.php', 'include/layout_cef.php', '1')
,('3', 'include/funcoes_bradesco.php', 'include/layout_bradesco.php', '0')
,('4', 'include/funcoes_itau.php', 'include/layout_itau.php', '0')
,('5', 'include/funcoes_hsbc.php', 'include/layout_hsbc.php', '0')
,('6', 'include/funcoes_real.php', 'include/layout_real.php', '0')
,('7', 'include/funcoes_banespa.php', 'include/layout_banespa.php', '0')
,('8', 'include/funcoes_banestes.php', 'include/layout_banestes.php', '0')
,('9', 'include/funcoes_nossacaixa.php', 'include/layout_nossacaixa.php', '0')
,('10', 'include/funcoes_bancoob.php', 'include/layout_bancoob.php', '0')
,('11', 'include/funcoes_besc.php', 'include/layout_besc.php', '0')
,('12', 'include/funcoes_santander_banespa.php', 'include/layout_santander_banespa.php', '0')
,('13', 'include/funcoes_sicredi.php', 'include/layout_sicredi.php', '0')
,('14', 'include/funcoes_sudameris.php', 'include/layout_sudameris.php', '0')
,('15', 'include/funcoes_unibanco.php', 'include/funcoes_unibanco.php', '0')
,('16', '', '', '0');

#
# Dados a serem incluídos na tabela
#

INSERT INTO tblformapagamento VALUES ('1', 'Dinheiro')
,('2', 'Cartão')
,('3', 'Pix')
,('4', 'Crédito');