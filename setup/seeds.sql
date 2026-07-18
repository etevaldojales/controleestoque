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
,('21', '8', 'Empresa', 'empresa.php')
,('22', '5', 'Rel. Sintético', 'rel_sintetico.php');

#
# Dados a serem incluídos na tabela
#


#
# Dados a serem incluídos na tabela
#

INSERT INTO tblformapagamento VALUES ('1', 'Dinheiro')
,('2', 'Cartão')
,('3', 'Pix')
,('4', 'Crédito')
,('5', 'Múltiplas Formas');
