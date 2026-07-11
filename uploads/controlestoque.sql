SET foreign_key_checks=0;


#
# Criação da Tabela : logs
#

CREATE TABLE `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `ip` varchar(15) NOT NULL,
  `mensagem` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hora` (`data`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `logs` VALUES ('1', '2025-05-13', '20:13:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 1| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 692,10| PRODUTOS: RGS3022(1.3), B789(2), 007(3), '),('2', '2025-05-13', '20:13:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/07/0005, NO VALOR DE: 130,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('3', '2025-05-13', '20:55:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 2| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 167,60| PRODUTOS: RGS3022(2.8), C345(2), '),('4', '2025-05-13', '20:55:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/07/0005, NO VALOR DE: 85,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('5', '2025-05-13', '21:02:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 3| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 649,40| PRODUTOS: B789(3), RGS3022(3.2), 106(1), '),('6', '2025-05-13', '21:02:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/07/0005, NO VALOR DE: 517,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('7', '2025-05-13', '21:06:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 4| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 320,00| PRODUTOS: C345(1), B23(2), B789(2), '),('8', '2025-05-13', '21:06:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/07/0006, NO VALOR DE: 148,50, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('9', '2025-05-13', '21:06:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 5| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 65,00| PRODUTOS: B789(1), '),('10', '2025-05-13', '21:06:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 07/05/2025, NO VALOR DE: 125,00, FORMA DE PAGAMENTO: Pix, CLIENTE: Avulso'),('11', '2025-05-13', '21:09:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 6| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 180,00| PRODUTOS: 007(1), '),('12', '2025-05-13', '21:09:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/08/0005, NO VALOR DE: 125,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('13', '2025-05-13', '21:09:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 7| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 60,00| PRODUTOS: C345(1), '),('14', '2025-05-13', '21:09:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/08/0005, NO VALOR DE: 297,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('15', '2025-05-13', '21:15:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 8| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 88,40| PRODUTOS: P-45(1), '),('16', '2025-05-13', '21:15:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/08/0005, NO VALOR DE: 580,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('17', '2025-05-13', '21:16:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 9| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 65,00| PRODUTOS: B789(1), '),('18', '2025-05-13', '21:16:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/08/0005, NO VALOR DE: 297,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('19', '2025-05-13', '21:19:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 10| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 117,00| PRODUTOS: 0009(1), '),('20', '2025-05-13', '21:19:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/08/0005, NO VALOR DE: 65,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('21', '2025-05-13', '21:21:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 11| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 65,00| PRODUTOS: B23(1), '),('22', '2025-05-13', '21:21:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/08/0005, NO VALOR DE: 362,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('23', '2025-05-13', '21:22:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 12| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 65,00| PRODUTOS: B23(1), '),('24', '2025-05-13', '21:22:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/08/0005, NO VALOR DE: 2.540,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('25', '2025-05-13', '21:23:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 13| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 117,00| PRODUTOS: 0009(1), '),('26', '2025-05-13', '21:23:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 08/06/2025, NO VALOR DE: 181,67, FORMA DE PAGAMENTO: Cr�dito, CLIENTE: Avulso'),('27', '2025-05-13', '21:25:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 14| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 60,00| PRODUTOS: C345(1), '),('28', '2025-05-13', '21:25:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 08/05/2025, NO VALOR DE: 55,25, FORMA DE PAGAMENTO: Cr�dito, CLIENTE: Avulso'),('29', '2025-05-13', '21:26:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 15| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 65,00| PRODUTOS: B789(1), '),('30', '2025-05-13', '21:26:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 12/06/2025, NO VALOR DE: 81,67, FORMA DE PAGAMENTO: Pix, CLIENTE: Avulso'),('31', '2025-05-13', '21:29:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 16| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 65,00| PRODUTOS: B23(1), '),('32', '2025-05-13', '21:29:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/12/0005, NO VALOR DE: 17,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('33', '2025-05-13', '21:30:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 17| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 88,40| PRODUTOS: P-45(1), '),('34', '2025-05-13', '21:30:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 05/12/0005, NO VALOR DE: 760,00, FORMA DE PAGAMENTO: , CLIENTE: Avulso'),('35', '2025-05-13', '21:31:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 18| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 190,00| PRODUTOS: B789(1), C345(1), B23(1), '),('36', '2025-05-13', '21:31:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 00/00/0000, NO VALOR DE: 190,00, FORMA DE PAGAMENTO: Cart�o, CLIENTE: Avulso'),('37', '2025-05-13', '21:35:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 19| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 340,00| PRODUTOS: RGS3022(20), '),('38', '2025-05-13', '21:35:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 00/00/0000, NO VALOR DE: 340,00, FORMA DE PAGAMENTO: Cart�o, CLIENTE: Avulso'),('39', '2025-05-13', '21:38:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 20| CLIENTE: Avulso| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 85,00| PRODUTOS: RGS3022(5), '),('40', '2025-05-13', '21:38:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 00/00/0000, NO VALOR DE: 85,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Avulso'),('41', '2025-05-13', '22:47:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 23| CLIENTE: ANGELA COSTA| DATA DO PEDIDO: 13/05/2025| VALOR DO PEDIDO: 125,00| PRODUTOS: C345(1), B789(1), '),('42', '2025-05-13', '22:48:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 13/06/2025, NO VALOR DE: 62,50, FORMA DE PAGAMENTO: Pix, CLIENTE: ANGELA COSTA'),('43', '2025-05-15', '21:24:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 22| CLIENTE: Maria An�lia| DATA DO PEDIDO: 15/05/2025| VALOR DO PEDIDO: 242,00| PRODUTOS: C345(1), 0009(1), B23(1), '),('44', '2025-05-15', '22:00:00', '::1', 'Etevaldo Jales -  ALTEROU O CLIENTE: Maria An?lia. DADOS ANTERIORES: NOME: Maria An?lia, EMAIL: analiajales@gmail.com, TELEFONE: (85) 3294-2735, ENDERE?O: Rua Humberto Lomeu, 3159 DADOS ATUAIS: NOME: Maria An?lia, EMAIL: analiajales@gmail.com, TELEFONE: (85) 3294-2735, ENDEREC?O: Rua Humberto Lomeu, 3159'),('45', '2025-05-17', '18:37:00', '::1', 'Etevaldo Jales - ALTEROU A EMPRESA DE: Loja - Demonstra��o PARA Loja - Demonstra��o'),('46', '2025-05-17', '18:38:00', '::1', 'Etevaldo Jales - ALTEROU A EMPRESA DE: Loja - Demonstração PARA Loja - Demonstra��o'),('47', '2025-05-17', '18:54:00', '::1', 'Etevaldo Jales - ALTEROU A EMPRESA DE: Loja - Demonstração PARA Loja - Demonstra��o'),('48', '2025-05-17', '18:59:00', '::1', 'Etevaldo Jales - ALTEROU A EMPRESA DE: Loja - Demonstração PARA Loja - Demonstração'),('49', '2025-05-17', '19:03:00', '::1', 'Etevaldo Jales - ALTEROU A EMPRESA DE: Loja - Demonstra�?§�?£o PARA Loja - Demonstra��o'),('50', '2025-05-17', '19:26:00', '::1', 'Etevaldo Jales -  EXCLUIU A empresa: Loja - Demonstra��o'),('51', '2025-05-17', '21:25:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 21| CLIENTE: Avulso| DATA DO PEDIDO: 17/05/2025| VALOR DO PEDIDO: 530,00| PRODUTOS: B789(1), B23(1), 106(1), '),('52', '2025-05-17', '21:25:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 00/00/0000, NO VALOR DE: 530,00, FORMA DE PAGAMENTO: Pix, CLIENTE: Avulso'),('53', '2025-05-17', '21:29:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 24| CLIENTE: Avulso| DATA DO PEDIDO: 17/05/2025| VALOR DO PEDIDO: 577,00| PRODUTOS: C345(1), 0009(1), 106(1), '),('54', '2025-05-17', '21:29:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 00/00/0000, NO VALOR DE: 577,00, FORMA DE PAGAMENTO: Pix, CLIENTE: Avulso'),('55', '2025-05-17', '21:33:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 25| CLIENTE: Avulso| DATA DO PEDIDO: 17/05/2025| VALOR DO PEDIDO: 517,00| PRODUTOS: 0009(1), 106(1), '),('56', '2025-05-17', '21:33:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 00/00/0000, NO VALOR DE: 517,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Avulso'),('57', '2025-05-17', '21:46:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 26| CLIENTE: Avulso| DATA DO PEDIDO: 17/05/2025| VALOR DO PEDIDO: 85,00| PRODUTOS: RGS3022(5), '),('58', '2025-05-17', '21:46:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 00/00/0000, NO VALOR DE: 85,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Avulso'),('59', '2025-05-17', '21:50:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 28| CLIENTE: Maria An�lia| DATA DO PEDIDO: 17/05/2025| VALOR DO PEDIDO: 562,20| PRODUTOS: P-45(3), 0009(1), 007(1), '),('60', '2025-05-17', '21:56:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 27| CLIENTE: Avulso| DATA DO PEDIDO: 17/05/2025| VALOR DO PEDIDO: 60,00| PRODUTOS: C345(1), '),('61', '2025-05-17', '21:56:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 00/00/0000, NO VALOR DE: 60,00, FORMA DE PAGAMENTO: Cart�o, CLIENTE: Avulso'),('62', '2025-05-21', '13:12:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 29| CLIENTE: Avulso| DATA DO PEDIDO: 21/05/2025| VALOR DO PEDIDO: 260,00| PRODUTOS: B789(1), B23(3), '),('63', '2025-05-21', '13:12:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 00/00/0000, NO VALOR DE: 260,00, FORMA DE PAGAMENTO: Pix, CLIENTE: Avulso'),('64', '2025-05-22', '20:55:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 32| CLIENTE: ANGELA COSTA| DATA DO PEDIDO: 22/05/2025| VALOR DO PEDIDO: 300,00| PRODUTOS: C345(2), 007(1), '),('65', '2025-05-22', '20:56:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 30| CLIENTE: Avulso| DATA DO PEDIDO: 22/05/2025| VALOR DO PEDIDO: 195,00| PRODUTOS: B789(3), '),('66', '2025-05-22', '20:56:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 00/00/0000, NO VALOR DE: 195,00, FORMA DE PAGAMENTO: Pix, CLIENTE: Avulso'),('67', '2025-05-23', '01:39:00', '::1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: Teste'),('68', '2025-05-23', '01:39:00', '::1', 'Etevaldo Jales -  ALTEROU A CATEGORIA DE: Teste PARA Testessss'),('69', '2025-05-23', '01:40:00', '::1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: Testessss'),('70', '2025-05-23', '01:42:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: Teste'),('71', '2025-05-23', '01:49:00', '::1', 'Etevaldo Jales -  ALTEROU O PRODUTO DE: Cal�a Jeans PARA Cal�a Jeans'),('72', '2025-05-23', '01:52:00', '::1', 'Etevaldo Jales -  CADASTROU O CLIENTE: Maria, ENDERE?O: Rua Tal, TELEFONE: (85) 99999-9999, EMAIL: '),('73', '2025-05-23', '01:54:00', '::1', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: 0009, QUANTIDADE: 20'),('74', '2025-05-23', '01:56:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 33| CLIENTE: Avulso| DATA DO PEDIDO: 23/05/2025| VALOR DO PEDIDO: 735,00| PRODUTOS: B789(3), C345(2), 106(1), '),('75', '2025-05-23', '01:56:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 00/00/0000, NO VALOR DE: 735,00, FORMA DE PAGAMENTO: Pix, CLIENTE: Avulso'),('76', '2025-05-23', '02:00:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 31| CLIENTE: Maria An�lia| DATA DO PEDIDO: 23/05/2025| VALOR DO PEDIDO: 1.010,00| PRODUTOS: 106(2), C345(3), '),('77', '2025-05-23', '02:01:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 23/05/2025, NO VALOR DE: 202,00, FORMA DE PAGAMENTO: Cr�dito, CLIENTE: Maria An�lia'),('78', '2025-05-23', '02:02:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 22/06/2025, NO VALOR DE: 100,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: ANGELA COSTA');

#
# Criação da Tabela : produto_fornecedor
#

CREATE TABLE `produto_fornecedor` (
  `id_produto` int(10) unsigned NOT NULL,
  `id_fornecedor` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_produto`,`id_fornecedor`),
  KEY `tblproduto_has_tblfornecedor_FKIndex1` (`id_produto`),
  KEY `tblproduto_has_tblfornecedor_FKIndex2` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : secoes
#

CREATE TABLE `secoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secao` varchar(100) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `posicao` int(11) NOT NULL DEFAULT 0,
  `icone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `secoes` VALUES ('1', 'Usu�rios', 'usuario.php', '8', 'icon-cog'),('3', 'Clientes', '', '5', 'icon-user'),('2', 'Cadastrar Produtos', 'produtos_cadastrar.php', '3', 'icon-gift'),('4', 'Pedidos', 'pedidos.php', '4', 'icon-shopping-cart'),('5', 'Relat�rios', '', '7', 'icon-pencil'),('7', 'Estoque', '', '2', 'icon-th-large'),('8', 'Cadastros', '', '6', 'icon-cogs'),('9', 'Auditoria', 'logs.php', '9', 'icon-comment'),('17', 'PDV', 'pdv.php', '1', 'icon-shopping-cart');

#
# Criação da Tabela : subsecoes
#

CREATE TABLE `subsecoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_secao` varchar(11) NOT NULL,
  `subsecao` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `subsecoes` VALUES ('1', '3', 'Cadastrar', 'clientes.php'),('2', '3', 'Vendas Realizadas', 'vendas_realizadas.php'),('3', '8', 'Categorias', 'categorias.php'),('4', '8', 'Fornecedores', 'fornecedor.php'),('5', '8', 'Marcas', 'marcas.php'),('6', '7', 'Cadastrar', 'estoque_cadastrar.php'),('7', '7', 'Listar', 'index.php'),('8', '5', 'Rel. Movimento', 'relatorios.php'),('9', '5', 'Prev. Receita', 'rel_prev_receitas.php'),('10', '5', 'Parc. Vencida', 'rel_parc_vencida.php'),('11', '5', 'Rel. Baixa', 'rel_baixa.php'),('12', '8', 'Bancos', 'bancos.php'),('21', '8', 'Empresa', 'empresa.php');

#
# Criação da Tabela : tblbancos
#

CREATE TABLE `tblbancos` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `funcao` varchar(60) DEFAULT NULL,
  `layout` varchar(60) DEFAULT NULL,
  `stselecionado` smallint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblbancos` VALUES ('1', 'include/funcoes_bb.php', 'include/layout_bb.php', '0'),('2', 'include/funcoes_cef.php', 'include/layout_cef.php', '1'),('3', 'include/funcoes_bradesco.php', 'include/layout_bradesco.php', '0'),('4', 'include/funcoes_itau.php', 'include/layout_itau.php', '0'),('5', 'include/funcoes_hsbc.php', 'include/layout_hsbc.php', '0'),('6', 'include/funcoes_real.php', 'include/layout_real.php', '0'),('7', 'include/funcoes_banespa.php', 'include/layout_banespa.php', '0'),('8', 'include/funcoes_banestes.php', 'include/layout_banestes.php', '0'),('9', 'include/funcoes_nossacaixa.php', 'include/layout_nossacaixa.php', '0'),('10', 'include/funcoes_bancoob.php', 'include/layout_bancoob.php', '0'),('11', 'include/funcoes_besc.php', 'include/layout_besc.php', '0'),('12', 'include/funcoes_santander_banespa.php', 'include/layout_santander_banespa.php', '0'),('13', 'include/funcoes_sicredi.php', 'include/layout_sicredi.php', '0'),('14', 'include/funcoes_sudameris.php', 'include/layout_sudameris.php', '0'),('15', 'include/funcoes_unibanco.php', 'include/funcoes_unibanco.php', '0'),('16', '', '', '0');

#
# Criação da Tabela : tblcategoria
#

CREATE TABLE `tblcategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(150) NOT NULL,
  `stativo` smallint(1) NOT NULL DEFAULT 0 COMMENT '1: Ativo; 0: Inativo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblcategoria` VALUES ('1', 'MASCULINA', '1'),('2', 'FEMININA', '1'),('3', 'PERFUMARIA', '1'),('4', 'ACESS�RIOS', '1'),('5', 'RA��O CANINA', '1'),('7', 'Testeefsff', '0'),('8', 'Testessss', '0');

#
# Criação da Tabela : tblcliente
#

CREATE TABLE `tblcliente` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `stativo` smallint(1) NOT NULL DEFAULT 0 COMMENT '0: Inativo; 1: Ativo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblcliente` VALUES ('1', 'Etevaldo Jales', '(85) 9894-9774', 'etevaldojales@gmail.com', 'Rua Humberto Lomeu 3159', '1'),('2', 'Maria An�lia', '(85) 3294-2735', 'analiajales@gmail.com', 'Rua Humberto Lomeu, 3159', '1'),('3', 'ANGELA COSTA', '(87) 9999-9999', 'angela@gmail.com', 'RUA DAS ACACIAS, 356 - NATAL', '1'),('4', 'Didi', '(85) 9999-9999', 'didi@gmail.com', 'Rua Tal,54 - Natal', '1'),('5', 'Avulso', '(85) 99999-9999', '', 'Rua XXXXXXXXXXXXXXXX, N� 999', '1'),('6', 'Maria', '(85) 99999-9999', '', 'Rua Tal', '1');

#
# Criação da Tabela : tblcredito
#

CREATE TABLE `tblcredito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `valor` float NOT NULL DEFAULT 0,
  `saldo` float NOT NULL DEFAULT 0,
  `data` date NOT NULL,
  `stcredito` smallint(1) DEFAULT 0 COMMENT '1: Credito; 2: Debito',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : tblempresa
#

CREATE TABLE `tblempresa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `telefone` varchar(25) DEFAULT NULL,
  `logo` varchar(60) DEFAULT NULL,
  `qrcode` varchar(60) DEFAULT NULL,
  `stativo` smallint(1) NOT NULL DEFAULT 1 COMMENT '1: Ativo; 0: Inativo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblempresa` VALUES ('1', 'Loja - Demonstra��o', 'Rua Humbero Lomeu, 3159 Granja Lisboa - Fortaleza / Ce', 'etevaldojales@gmail.com', '(85) 99626-8685', 'uploads/logo_6828c06a1381c.png', 'uploads/qrcode_6828c06a139ac.png', '1');

#
# Criação da Tabela : tblentrada
#

CREATE TABLE `tblentrada` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_forma_pag` int(5) NOT NULL,
  `valor` float NOT NULL,
  `vencimento` date NOT NULL,
  `valor_pag` float DEFAULT NULL,
  `data_pgto` date DEFAULT NULL,
  `valor_rec` float DEFAULT NULL,
  `multa` float DEFAULT NULL,
  `juros` float DEFAULT NULL,
  `flgstatus` smallint(2) NOT NULL COMMENT '1: Pendente; Pago',
  `recibo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : tblestoque
#

CREATE TABLE `tblestoque` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_produto` int(10) unsigned NOT NULL,
  `qtdentrada` int(10) unsigned DEFAULT NULL,
  `qtdsaida` int(10) unsigned DEFAULT NULL,
  `estoque_minimo` int(6) DEFAULT 0,
  `qtdacumulado` int(10) unsigned DEFAULT NULL,
  `data` date DEFAULT NULL,
  `num_nf` int(11) DEFAULT NULL COMMENT 'N�mero da Nota Fiscal',
  `cor` varchar(50) DEFAULT NULL,
  `tamanho` varchar(50) DEFAULT NULL,
  `stativo` smallint(1) NOT NULL DEFAULT 0 COMMENT '1: Ativo; 0: Inativo',
  PRIMARY KEY (`id`),
  KEY `tblestoque_FKIndex1` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblestoque` VALUES ('1', '1', '20', '0', '0', '20', '2015-09-01', '', '', '', '1'),('2', '2', '25', '0', '5', '25', '2015-09-01', '', '', '', '1'),('3', '1', '0', '10', '0', '10', '2015-09-04', '', '', '', '1'),('4', '2', '0', '15', '0', '10', '2015-09-04', '', '', '', '1'),('5', '1', '0', '5', '0', '5', '2015-09-05', '', '', '', '1'),('6', '1', '0', '3', '0', '2', '2015-09-12', '', '', '', '1'),('7', '2', '0', '1', '0', '9', '2015-09-12', '', '', '', '1'),('8', '1', '50', '0', '0', '52', '2015-09-12', '', '', '', '1'),('9', '1', '0', '6', '0', '46', '2015-09-22', '', '', '', '1'),('10', '2', '0', '8', '0', '1', '2015-09-22', '', '', '', '1'),('11', '3', '30', '0', '10', '30', '2015-10-10', '', '', '', '1'),('12', '3', '0', '10', '0', '20', '2015-10-10', '', '', '', '1'),('13', '2', '0', '1', '0', '0', '2015-10-10', '', '', '', '1'),('14', '2', '60', '0', '5', '60', '2015-10-10', '', '', '', '1'),('15', '3', '0', '20', '10', '0', '2015-10-21', '', '', '', '1'),('16', '3', '20', '0', '10', '20', '2015-10-21', '', '', '', '1'),('17', '1', '0', '5', '0', '41', '2015-10-24', '', '', '', '1'),('18', '3', '0', '2', '0', '18', '2015-10-24', '', '', '', '1'),('19', '1', '0', '10', '0', '31', '2015-11-13', '', '', '', '1'),('20', '2', '0', '5', '0', '55', '2015-11-13', '', '', '', '1'),('21', '4', '10', '0', '4', '10', '2017-01-29', '', '', '', '1'),('22', '1', '0', '1', '0', '30', '2017-01-29', '', '', '', '1'),('23', '3', '0', '1', '0', '17', '2017-01-29', '', '', '', '1'),('24', '1', '0', '1', '0', '29', '2017-01-29', '', '', '', '1'),('25', '3', '0', '1', '0', '16', '2017-01-29', '', '', '', '1'),('26', '1', '0', '1', '0', '28', '2017-01-29', '', '', '', '1'),('27', '3', '0', '1', '0', '15', '2017-01-29', '', '', '', '1'),('28', '1', '0', '1', '0', '27', '2017-01-29', '', '', '', '1'),('29', '3', '0', '1', '0', '14', '2017-01-29', '', '', '', '1'),('30', '4', '0', '6', '4', '4', '2017-01-29', '', '', '', '1'),('31', '4', '0', '6', '4', '4', '2017-01-29', '', '', '', '1'),('32', '3', '0', '3', '0', '11', '2017-01-30', '', '', '', '1'),('33', '3', '0', '3', '0', '8', '2017-01-30', '', '', '', '1'),('34', '3', '5', '0', '10', '13', '2017-01-30', '', '', '', '1'),('35', '5', '10', '0', '6', '10', '2017-01-30', '', '', '', '1'),('36', '1', '0', '3', '0', '24', '2017-01-30', '', '', '', '1'),('37', '5', '0', '2', '0', '8', '2017-01-30', '', '', '', '1'),('38', '5', '20', '0', '6', '28', '2017-01-30', '', '', '', '1'),('39', '5', '0', '2', '0', '26', '2017-01-30', '', '', '', '1'),('40', '2', '0', '3', '0', '52', '2017-01-30', '', '', '', '1'),('41', '5', '0', '5', '6', '21', '2017-01-30', '', '', '', '1'),('42', '1', '0', '4', '0', '20', '2017-01-30', '', '', '', '1'),('43', '5', '0', '1', '0', '20', '2017-01-30', '', '', '', '1'),('44', '5', '10', '0', '6', '30', '2017-02-12', '', '', '', '1'),('45', '4', '10', '0', '4', '14', '2017-02-14', '', '', '', '1'),('46', '6', '20', '0', '5', '20', '2017-02-18', '', '', '', '1'),('47', '6', '10', '0', '5', '30', '2017-02-18', '', '', '', '1'),('48', '6', '0', '3', '0', '27', '2017-02-18', '', '', '', '1'),('49', '1', '0', '2', '0', '18', '2017-02-18', '', '', '', '1'),('50', '6', '0', '23', '5', '4', '2017-02-18', '', '', '', '1'),('51', '3', '0', '10', '10', '3', '2017-04-09', '', '', '', '1'),('52', '1', '0', '3', '0', '15', '2017-04-14', '', '', '', '1'),('53', '2', '0', '5', '0', '47', '2017-04-14', '', '', '', '1'),('54', '6', '0', '1', '0', '3', '2017-04-14', '', '', '', '1'),('55', '7', '10', '0', '4', '10', '2017-05-07', '', '', '', '1'),('56', '1', '0', '2', '0', '13', '2017-05-07', '', '', '', '1'),('57', '7', '0', '1', '0', '9', '2017-05-07', '', '', '', '1'),('58', '4', '0', '1', '0', '13', '2017-07-22', '', '', '', '1'),('59', '3', '0', '1', '0', '2', '2017-07-22', '', '', '', '1'),('60', '2', '0', '5', '0', '42', '2017-07-22', '', '', '', '1'),('61', '1', '0', '3', '0', '10', '2017-07-22', '', '', '', '1'),('62', '1', '0', '3', '0', '7', '2017-07-22', '', '', '', '1'),('63', '1', '0', '1', '0', '6', '2018-03-17', '', '', '', '1'),('64', '1', '10', '0', '0', '16', '2021-03-20', '', '', '', '1'),('65', '2', '8', '0', '5', '50', '2023-11-18', '', '', '', '1'),('66', '1', '0', '2', '0', '14', '2025-04-22', '', '', '', '1'),('67', '2', '0', '3', '0', '47', '2025-04-22', '', '', '', '1'),('68', '4', '0', '2', '0', '11', '2025-04-22', '', '', '', '1'),('69', '6', '0', '1', '0', '2', '2025-04-22', '', '', '', '1'),('70', '2', '0', '1', '0', '46', '2025-04-22', '', '', '', '1'),('71', '1', '0', '2', '0', '12', '2025-04-23', '', '', '', '1'),('72', '1', '0', '1', '0', '11', '2025-04-23', '', '', '', '1'),('73', '2', '0', '1', '0', '45', '2025-04-23', '', '', '', '1'),('74', '3', '0', '1', '0', '1', '2025-04-23', '', '', '', '1'),('75', '1', '10', '0', '0', '21', '2025-04-24', '', '', '', '0'),('76', '3', '20', '0', '10', '21', '2025-04-24', '', '', '', '0'),('78', '6', '10', '0', '5', '12', '2025-04-25', '', '', '', '1'),('79', '7', '20', '0', '4', '29', '2025-04-25', '', '', '', '1'),('80', '8', '500', '0', '20', '500', '2025-04-26', '', '', '', '0');

#
# Criação da Tabela : tblformapagamento
#

CREATE TABLE `tblformapagamento` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblformapagamento` VALUES ('1', 'Dinheiro'),('2', 'Cart�o'),('3', 'Pix'),('4', 'Cr�dito');

#
# Criação da Tabela : tblfornecedor
#

CREATE TABLE `tblfornecedor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `stativo` smallint(1) NOT NULL DEFAULT 0 COMMENT '1: Ativo; 0: Inativo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblfornecedor` VALUES ('1', 'R2 DISTRIBUIDORA', '', '', '', '1'),('2', 'BOTICARIO', '', '', '', '1'),('3', 'AVON', '', '', '', '1'),('5', 'TESTE', '(85) 98949-7715', 'Rua Tal', 'teste@gmail.com', '0'),('6', 'DOG', '', '', '', '1');

#
# Criação da Tabela : tblitenspedido
#

CREATE TABLE `tblitenspedido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_produto` int(10) unsigned NOT NULL,
  `id_pedido` int(10) unsigned NOT NULL,
  `quantidade` float unsigned DEFAULT NULL,
  `valor_unitario_compra` float DEFAULT 0,
  `valor_unitario` float DEFAULT NULL,
  `valor_total` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tblitenspedido_FKIndex1` (`id_pedido`),
  KEY `tblitenspedido_FKIndex2` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblitenspedido` VALUES ('8', '8', '1', '1.3', '9', '17', '22.1'),('9', '2', '1', '2', '50', '65', '130'),('10', '5', '1', '3', '129.99', '180', '540'),('11', '8', '2', '2.8', '9', '17', '47.6'),('12', '1', '2', '2', '45', '60', '120'),('13', '2', '3', '3', '50', '65', '195'),('14', '8', '3', '3.2', '9', '17', '54.4'),('15', '6', '3', '1', '250', '400', '400'),('16', '1', '4', '1', '45', '60', '60'),('17', '7', '4', '2', '50', '65', '130'),('18', '2', '4', '2', '50', '65', '130'),('19', '2', '5', '1', '50', '65', '65'),('20', '5', '6', '1', '129.99', '180', '180'),('21', '1', '7', '1', '45', '60', '60'),('22', '3', '8', '1', '68', '88.4', '88.4'),('23', '2', '9', '1', '50', '65', '65'),('24', '4', '10', '1', '90', '117', '117'),('25', '7', '11', '1', '50', '65', '65'),('26', '7', '12', '1', '50', '65', '65'),('27', '4', '13', '1', '90', '117', '117'),('28', '1', '14', '1', '45', '60', '60'),('29', '2', '15', '1', '50', '65', '65'),('30', '7', '16', '1', '50', '65', '65'),('31', '3', '17', '1', '68', '88.4', '88.4'),('32', '2', '18', '1', '50', '65', '65'),('33', '1', '18', '1', '45', '60', '60'),('34', '7', '18', '1', '50', '65', '65'),('35', '8', '19', '20', '9', '17', '340'),('36', '8', '20', '5', '9', '17', '85'),('37', '1', '22', '1', '45', '60', '60'),('38', '1', '23', '1', '45', '60', '60'),('39', '2', '23', '1', '50', '65', '65'),('40', '4', '22', '1', '90', '117', '117'),('41', '7', '22', '1', '50', '65', '65'),('43', '2', '21', '1', '50', '65', '65'),('44', '7', '21', '1', '50', '65', '65'),('45', '6', '21', '1', '250', '400', '400'),('46', '1', '24', '1', '45', '60', '60'),('47', '4', '24', '1', '90', '117', '117'),('48', '6', '24', '1', '250', '400', '400'),('49', '4', '25', '1', '90', '117', '117'),('50', '6', '25', '1', '250', '400', '400'),('52', '8', '26', '5', '9', '17', '85'),('53', '3', '28', '3', '68', '88.4', '265.2'),('54', '4', '28', '1', '90', '117', '117'),('55', '5', '28', '1', '129.99', '180', '180'),('56', '1', '27', '1', '45', '60', '60'),('60', '2', '29', '1', '50', '65', '65'),('61', '7', '29', '3', '50', '65', '195'),('62', '6', '31', '2', '250', '400', '800'),('66', '2', '30', '3', '50', '65', '195'),('68', '1', '32', '2', '45', '60', '120'),('69', '5', '32', '1', '129.99', '180', '180'),('70', '2', '33', '3', '50', '65', '195'),('71', '1', '33', '2', '45', '70', '140'),('72', '6', '33', '1', '250', '400', '400'),('73', '1', '31', '3', '45', '70', '210');

#
# Criação da Tabela : tblmarca
#

CREATE TABLE `tblmarca` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  `stativo` smallint(1) NOT NULL COMMENT '1: Ativo; 0: Inativo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblmarca` VALUES ('1', 'MR2', '1'),('2', 'BOTICARIO', '1'),('3', 'BIC', '1'),('4', 'R2 - CANINA', '1'),('5', 'TESTESSSS', '0'),('6', 'Teste', '1');

#
# Criação da Tabela : tblparcela
#

CREATE TABLE `tblparcela` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_pedido` int(10) unsigned NOT NULL,
  `id_forma_pag` int(5) DEFAULT 0,
  `valor_parcela` float DEFAULT NULL,
  `vencimento` date DEFAULT NULL,
  `valor_pag` float DEFAULT NULL,
  `data_pgto` date DEFAULT NULL,
  `valor_rec` float DEFAULT NULL,
  `multa` float DEFAULT NULL,
  `juros` float DEFAULT NULL,
  `flgstatus` smallint(1) NOT NULL DEFAULT 1 COMMENT '1: Pendente; 2: Pago',
  `recibo` varchar(100) DEFAULT NULL,
  `nosso_numero` int(8) DEFAULT 0,
  `stEstorno` smallint(1) DEFAULT 0 COMMENT '0: N�o Estornado; 1: Estornado ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nosso_numero` (`nosso_numero`),
  KEY `tblparcela_FKIndex1` (`id_pedido`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblparcela` VALUES ('1', '1', '1', '0', '130', '0005-07-05', '130', '2025-05-13', '130', '0', '0', '2', '', '1', '0'),('2', '1', '2', '0', '85', '0005-07-05', '85', '2025-05-13', '85', '0', '0', '2', '', '2', '0'),('3', '1', '3', '0', '517', '0005-07-05', '517', '2025-05-13', '517', '0', '0', '2', '', '3', '0'),('4', '1', '5', '0', '125', '2025-05-07', '125', '2025-05-13', '125', '0', '0', '2', '', '4', '0'),('5', '1', '4', '0', '148.5', '0006-07-05', '148.5', '2025-05-13', '148.5', '0', '0', '2', '', '5', '0'),('6', '1', '4', '4', '148.5', '0007-07-05', '0', '0000-00-00', '0', '0', '0', '1', '', '6', '0'),('7', '1', '6', '0', '125', '0005-08-05', '125', '2025-05-13', '125', '0', '0', '2', '', '7', '0'),('8', '1', '7', '0', '297', '0005-08-05', '297', '2025-05-13', '297', '0', '0', '2', '', '8', '0'),('9', '1', '8', '0', '580', '0005-08-05', '580', '2025-05-13', '580', '0', '0', '2', '', '9', '0'),('10', '1', '9', '0', '297', '0005-08-05', '297', '2025-05-13', '297', '0', '0', '2', '', '10', '0'),('11', '1', '10', '0', '65', '0005-08-05', '65', '2025-05-13', '65', '0', '0', '2', '', '11', '0'),('12', '1', '11', '0', '362', '0005-08-05', '362', '2025-05-13', '362', '0', '0', '2', '', '12', '0'),('13', '1', '13', '0', '181.67', '2025-06-08', '181.67', '2025-05-13', '181.67', '0', '0', '2', '', '13', '0'),('14', '1', '13', '4', '181.67', '2025-07-08', '0', '0000-00-00', '0', '0', '0', '1', '', '14', '0'),('15', '1', '13', '4', '181.66', '2025-08-08', '0', '0000-00-00', '0', '0', '0', '1', '', '15', '0'),('16', '1', '12', '0', '2540', '0005-08-05', '2540', '2025-05-13', '2540', '0', '0', '2', '', '16', '0'),('17', '1', '14', '0', '55.25', '2025-05-08', '55.25', '2025-05-13', '55.25', '0', '0', '2', '', '17', '0'),('18', '1', '15', '0', '81.67', '2025-06-12', '81.67', '2025-05-13', '81.67', '0', '0', '2', '', '18', '0'),('19', '1', '15', '4', '81.67', '2025-07-12', '0', '0000-00-00', '0', '0', '0', '1', '', '19', '0'),('20', '1', '15', '4', '81.66', '2025-08-12', '0', '0000-00-00', '0', '0', '0', '1', '', '20', '0'),('21', '1', '16', '0', '17', '0005-12-05', '17', '2025-05-13', '17', '0', '0', '2', '', '21', '0'),('22', '1', '17', '0', '760', '0005-12-05', '760', '2025-05-13', '760', '0', '0', '2', '', '22', '0'),('23', '1', '1', '3', '692.1', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '23', '0'),('24', '1', '2', '2', '167.6', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '24', '0'),('25', '1', '3', '2', '649.4', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '25', '0'),('26', '1', '4', '2', '320', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '26', '0'),('27', '1', '5', '2', '65', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '27', '0'),('28', '1', '6', '2', '180', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '28', '0'),('29', '1', '7', '3', '60', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '29', '0'),('30', '1', '8', '2', '88.4', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '30', '0'),('31', '1', '9', '2', '65', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '31', '0'),('32', '1', '10', '2', '117', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '32', '0'),('33', '1', '11', '2', '65', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '33', '0'),('34', '1', '12', '3', '65', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '34', '0'),('35', '1', '13', '2', '117', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '35', '0'),('36', '1', '14', '2', '60', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '36', '0'),('37', '1', '15', '2', '65', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '37', '0'),('38', '1', '16', '3', '65', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '38', '0'),('39', '1', '17', '3', '88.4', '0000-00-00', '0', '0000-00-00', '0', '0', '0', '1', '', '39', '0'),('40', '1', '18', '0', '190', '0000-00-00', '190', '2025-05-13', '190', '0', '0', '2', '', '40', '0'),('41', '1', '19', '0', '340', '0000-00-00', '340', '2025-05-13', '340', '0', '0', '2', '', '41', '0'),('42', '1', '20', '0', '85', '0000-00-00', '85', '2025-05-13', '85', '0', '0', '2', '', '42', '0'),('43', '1', '23', '3', '62.5', '2025-06-13', '62.5', '2025-05-13', '62.5', '0', '0', '2', '', '43', '0'),('44', '1', '23', '4', '62.5', '2025-07-13', '0', '0000-00-00', '0', '0', '0', '1', '', '44', '0'),('45', '1', '22', '4', '60.5', '2025-06-15', '0', '0000-00-00', '0', '0', '0', '1', '', '45', '0'),('46', '1', '22', '4', '60.5', '2025-07-15', '0', '0000-00-00', '0', '0', '0', '1', '', '46', '0'),('47', '1', '22', '4', '60.5', '2025-08-15', '0', '0000-00-00', '0', '0', '0', '1', '', '47', '0'),('48', '1', '22', '4', '60.5', '2025-09-15', '0', '0000-00-00', '0', '0', '0', '1', '', '48', '0'),('49', '1', '21', '0', '530', '0000-00-00', '530', '2025-05-17', '530', '0', '0', '2', '', '49', '0'),('50', '1', '24', '0', '577', '0000-00-00', '577', '2025-05-17', '577', '0', '0', '2', '', '50', '0'),('51', '1', '25', '0', '517', '0000-00-00', '517', '2025-05-17', '517', '0', '0', '2', '', '51', '0'),('52', '1', '26', '0', '85', '0000-00-00', '85', '2025-05-17', '85', '0', '0', '2', '', '52', '0'),('53', '1', '28', '4', '140.55', '2025-06-17', '0', '0000-00-00', '0', '0', '0', '1', '', '53', '0'),('54', '1', '28', '4', '140.55', '2025-07-17', '0', '0000-00-00', '0', '0', '0', '1', '', '54', '0'),('55', '1', '28', '4', '140.55', '2025-08-17', '0', '0000-00-00', '0', '0', '0', '1', '', '55', '0'),('56', '1', '28', '4', '140.55', '2025-09-17', '0', '0000-00-00', '0', '0', '0', '1', '', '56', '0'),('57', '1', '27', '0', '60', '0000-00-00', '60', '2025-05-17', '60', '0', '0', '2', '', '57', '0'),('58', '1', '29', '0', '260', '0000-00-00', '260', '2025-05-21', '260', '0', '0', '2', '', '58', '0'),('59', '1', '32', '1', '100', '2025-06-22', '100', '2025-05-23', '100', '0', '0', '2', '', '59', '0'),('60', '1', '32', '4', '100', '2025-07-22', '0', '0000-00-00', '0', '0', '0', '1', '', '60', '0'),('61', '1', '32', '4', '100', '2025-08-22', '0', '0000-00-00', '0', '0', '0', '1', '', '61', '0'),('62', '1', '30', '0', '195', '0000-00-00', '195', '2025-05-22', '195', '0', '0', '2', '', '62', '0'),('63', '1', '33', '0', '735', '0000-00-00', '735', '2025-05-23', '735', '0', '0', '2', '', '63', '0'),('64', '1', '31', '4', '202', '2025-05-23', '202', '2025-05-23', '202', '0', '0', '2', '', '64', '0'),('65', '1', '31', '4', '202', '2025-06-23', '0', '0000-00-00', '0', '0', '0', '1', '', '65', '0'),('66', '1', '31', '4', '202', '2025-07-23', '0', '0000-00-00', '0', '0', '0', '1', '', '66', '0'),('67', '1', '31', '4', '202', '2025-08-23', '0', '0000-00-00', '0', '0', '0', '1', '', '67', '0'),('68', '1', '31', '4', '202', '2025-09-23', '0', '0000-00-00', '0', '0', '0', '1', '', '68', '0');

#
# Criação da Tabela : tblpedido
#

CREATE TABLE `tblpedido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(10) unsigned NOT NULL,
  `id_usuario` int(5) NOT NULL,
  `numero_pedido` int(10) unsigned NOT NULL DEFAULT 0,
  `data_pedido` date DEFAULT NULL,
  `primeiro_venc` date DEFAULT NULL,
  `num_parc` int(5) DEFAULT 0,
  `id_formapag` int(5) DEFAULT 0,
  `valor_custo` float DEFAULT 0,
  `valor_venda` float DEFAULT 0,
  `valor` float DEFAULT NULL,
  `status_pedido` smallint(1) unsigned NOT NULL COMMENT '1: Em aberto; 2: Concluido; 3: Cancelado',
  `observacao` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tblpedido_FKIndex1` (`id_cliente`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblpedido` VALUES ('1', '5', '1', '1', '2025-05-13', '2025-05-13', '1', '3', '501.67', '692.1', '692.1', '2', ''),('2', '5', '1', '2', '2025-05-13', '2025-05-13', '1', '2', '115.2', '167.6', '167.6', '2', ''),('3', '5', '1', '3', '2025-05-13', '2025-05-13', '1', '2', '428.8', '649.4', '649.4', '2', ''),('4', '5', '1', '4', '2025-05-13', '2025-05-13', '1', '2', '245', '320', '320', '2', ''),('5', '5', '1', '5', '2025-05-13', '2025-05-13', '1', '2', '50', '65', '65', '2', ''),('6', '5', '1', '6', '2025-05-13', '2025-05-13', '1', '2', '129.99', '180', '180', '2', ''),('7', '5', '1', '7', '2025-05-13', '2025-05-13', '1', '3', '45', '60', '60', '2', ''),('8', '5', '1', '8', '2025-05-13', '2025-05-13', '1', '2', '68', '88.4', '88.4', '2', ''),('9', '5', '1', '9', '2025-05-13', '2025-05-13', '1', '2', '50', '65', '65', '2', ''),('10', '5', '1', '10', '2025-05-13', '2025-05-13', '1', '2', '90', '117', '117', '2', ''),('11', '5', '1', '11', '2025-05-13', '2025-05-13', '1', '2', '50', '65', '65', '2', ''),('12', '5', '1', '12', '2025-05-13', '2025-05-13', '1', '3', '50', '65', '65', '2', ''),('13', '5', '1', '13', '2025-05-13', '2025-05-13', '1', '2', '90', '117', '117', '2', ''),('14', '5', '1', '14', '2025-05-13', '2025-05-13', '1', '2', '45', '60', '60', '2', ''),('15', '5', '1', '15', '2025-05-13', '2025-05-13', '1', '2', '50', '65', '65', '2', ''),('16', '5', '1', '16', '2025-05-13', '2025-05-13', '1', '3', '50', '65', '65', '2', ''),('17', '5', '1', '17', '2025-05-13', '2025-05-13', '1', '3', '68', '88.4', '88.4', '2', ''),('18', '5', '1', '18', '2025-05-13', '2025-05-13', '1', '2', '145', '190', '190', '2', ''),('19', '5', '1', '19', '2025-05-13', '2025-05-13', '1', '2', '180', '340', '340', '2', ''),('20', '5', '1', '20', '2025-05-13', '2025-05-13', '1', '1', '45', '85', '85', '2', ''),('21', '5', '1', '21', '2025-05-17', '2025-05-17', '1', '3', '350', '530', '530', '2', ''),('22', '2', '1', '22', '2025-05-15', '2025-06-15', '4', '4', '185', '242', '242', '2', ''),('23', '3', '1', '23', '2025-05-13', '2025-06-13', '2', '4', '95', '125', '125', '2', ''),('24', '5', '1', '24', '2025-05-17', '2025-05-17', '1', '3', '385', '577', '577', '2', ''),('25', '5', '1', '25', '2025-05-17', '2025-05-17', '1', '1', '340', '517', '517', '2', ''),('26', '5', '1', '26', '2025-05-17', '2025-05-17', '1', '1', '45', '85', '85', '2', ''),('27', '5', '1', '27', '2025-05-17', '2025-05-17', '1', '2', '45', '60', '60', '2', ''),('28', '2', '1', '28', '2025-05-17', '2025-06-17', '4', '4', '423.99', '562.2', '562.2', '2', ''),('29', '5', '1', '29', '2025-05-21', '2025-05-21', '1', '3', '200', '260', '260', '2', ''),('30', '5', '1', '30', '2025-05-22', '2025-05-22', '1', '3', '150', '195', '195', '2', ''),('31', '2', '1', '31', '2025-05-23', '2025-05-23', '5', '4', '635', '1010', '1010', '2', ''),('32', '3', '1', '32', '2025-05-22', '2025-06-22', '3', '4', '219.99', '300', '300', '2', ''),('33', '5', '1', '33', '2025-05-23', '2025-05-23', '1', '3', '490', '735', '735', '2', ''),('34', '5', '1', '34', '2025-05-23', '', '0', '0', '0', '0', '0', '1', '');

#
# Criação da Tabela : tblproduto
#

CREATE TABLE `tblproduto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `id_marca` int(10) unsigned NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `valor_compra` float NOT NULL,
  `valor` float DEFAULT NULL,
  `unidade` smallint(1) NOT NULL DEFAULT 1 COMMENT '1: Unidade; 2: Peso',
  `codigo` varchar(100) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `local_estoque` varchar(150) DEFAULT NULL,
  `stativo` smallint(1) NOT NULL DEFAULT 0 COMMENT '1: Ativo; 0: Inativo',
  PRIMARY KEY (`id`),
  KEY `tblproduto_FKIndex1` (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblproduto` VALUES ('1', '1', '1', '1', 'Cal�a Jeans', '45', '70', '1', 'C345', '2015-09-01', 'P-27', '1'),('2', '1', '1', '1', 'Bermuda Jeans', '50', '65', '1', 'B789', '2015-09-01', '02', '1'),('3', '1', '1', '1', 'Perfume', '68', '88.4', '1', 'P-45', '2015-10-10', '06', '1'),('4', '1', '1', '1', 'Malbeck', '90', '117', '1', '0009', '2017-01-29', 'P1', '1'),('5', '3', '2', '2', 'ZAAD', '129.99', '180', '1', '007', '2017-01-30', '1B', '1'),('6', '3', '2', '2', 'Polo', '250', '400', '1', '106', '2017-02-18', 'P5', '1'),('7', '2', '1', '1', 'Blusa', '50', '65', '1', 'B23', '2017-05-07', 'P1', '1'),('8', '5', '4', '6', 'Ra��o Golden Salm�o', '9', '17', '2', 'RGS3022', '2025-04-26', 'P2', '1');

#
# Criação da Tabela : tblservico
#

CREATE TABLE `tblservico` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pedido` int(10) DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblservico` VALUES ('3', '16', 'Encaderna��o', '100'),('4', '18', 'Estamparia', '150');

#
# Criação da Tabela : usuarios
#

CREATE TABLE `usuarios` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL DEFAULT '',
  `senha` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) DEFAULT NULL,
  `nome` varchar(150) NOT NULL,
  `telefone` varchar(25) DEFAULT NULL,
  `foto` varchar(60) DEFAULT NULL,
  `ativo` smallint(1) DEFAULT 0,
  `tipo_usuario` smallint(1) DEFAULT 0,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `usuarios` VALUES ('1', 'etevaldo', '6e25da606bab2c8e5908ef6b69b3c458', 'etevasldojales@gmail.com', 'Etevaldo Jales', '(85) 3294-2735', '', '1', '1'),('9', 'cliente', '4983a0ab83ed86e0e7213c8783940193', '', 'Cliente', '(85) 9999-9999', '', '1', '1'),('10', 'caixa 01', 'fcd8adee738c2da528633ee3e06d628d', '', 'Caixa 01', '', '', '1', '2'),('11', 'Funcionario', '81dc9bdb52d04dc20036dbd8313ed055', '', 'Funcionario', '', '', '1', '0'),('12', 'Dono', '81dc9bdb52d04dc20036dbd8313ed055', '', 'Dono', '', '', '1', '1');

#
# Criação da Tabela : usuarios_secoes
#

CREATE TABLE `usuarios_secoes` (
  `id_usuario_secoes` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT 0,
  `id_secoes` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_usuario_secoes`)
) ENGINE=MyISAM AUTO_INCREMENT=351 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `usuarios_secoes` VALUES ('350', '1', '9'),('349', '1', '1'),('348', '1', '5'),('347', '1', '5'),('346', '1', '5'),('345', '1', '5'),('344', '1', '8'),('343', '1', '8'),('342', '1', '8'),('341', '1', '8'),('340', '1', '3'),('339', '1', '3'),('338', '1', '4'),('337', '1', '2'),('336', '1', '7'),('335', '1', '7'),('64', '5', '9'),('63', '5', '1'),('62', '5', '5'),('61', '5', '5'),('60', '5', '5'),('59', '5', '5'),('58', '5', '8'),('57', '5', '8'),('56', '5', '8'),('55', '5', '8'),('54', '5', '3'),('53', '5', '3'),('52', '5', '4'),('51', '5', '2'),('50', '5', '7'),('49', '5', '7'),('88', '6', '8'),('87', '6', '8'),('86', '6', '8'),('85', '6', '3'),('84', '6', '3'),('83', '6', '4'),('82', '6', '2'),('81', '6', '7'),('80', '6', '7'),('118', '8', '3'),('117', '8', '3'),('116', '8', '4'),('115', '8', '2'),('114', '8', '7'),('113', '8', '7'),('112', '7', '8'),('111', '7', '8'),('110', '7', '8'),('109', '7', '3'),('108', '7', '3'),('107', '7', '4'),('106', '7', '2'),('105', '7', '7'),('104', '7', '7'),('119', '8', '8'),('120', '8', '8'),('121', '8', '8'),('122', '8', '8'),('123', '8', '5'),('124', '8', '5'),('125', '8', '5'),('126', '8', '5'),('127', '8', '1'),('128', '8', '9'),('334', '1', '17'),('210', '9', '17'),('211', '9', '7'),('212', '9', '7'),('213', '9', '2'),('214', '9', '4'),('215', '9', '4'),('216', '9', '3'),('217', '9', '3'),('218', '9', '8'),('219', '9', '8'),('220', '9', '8'),('221', '9', '5'),('222', '9', '5'),('223', '9', '5'),('224', '9', '5'),('225', '9', '1'),('226', '9', '9'),('236', '10', '17');

#
# Criação da Tabela : usuarios_subsecoes
#

CREATE TABLE `usuarios_subsecoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(8) NOT NULL,
  `id_secao` int(5) NOT NULL,
  `id_subsecao` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=350 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `usuarios_subsecoes` VALUES ('349', '1', '9', '0'),('348', '1', '1', '0'),('347', '1', '5', '11'),('346', '1', '5', '10'),('345', '1', '5', '9'),('344', '1', '5', '8'),('343', '1', '8', '21'),('342', '1', '8', '5'),('341', '1', '8', '4'),('340', '1', '8', '3'),('339', '1', '3', '2'),('338', '1', '3', '1'),('337', '1', '4', '0'),('336', '1', '2', '0'),('335', '1', '7', '7'),('334', '1', '7', '6'),('63', '5', '9', '0'),('62', '5', '1', '0'),('61', '5', '5', '11'),('60', '5', '5', '10'),('59', '5', '5', '9'),('58', '5', '5', '8'),('57', '5', '8', '12'),('56', '5', '8', '5'),('55', '5', '8', '4'),('54', '5', '8', '3'),('53', '5', '3', '2'),('52', '5', '3', '1'),('51', '5', '4', '0'),('50', '5', '2', '0'),('49', '5', '7', '7'),('48', '5', '7', '6'),('87', '6', '8', '5'),('86', '6', '8', '4'),('85', '6', '8', '3'),('84', '6', '3', '2'),('83', '6', '3', '1'),('82', '6', '4', '0'),('81', '6', '2', '0'),('80', '6', '7', '7'),('79', '6', '7', '6'),('117', '8', '3', '2'),('116', '8', '3', '1'),('115', '8', '4', '0'),('114', '8', '2', '0'),('113', '8', '7', '7'),('112', '8', '7', '6'),('111', '7', '8', '5'),('110', '7', '8', '4'),('109', '7', '8', '3'),('108', '7', '3', '2'),('107', '7', '3', '1'),('106', '7', '4', '0'),('105', '7', '2', '0'),('104', '7', '7', '7'),('103', '7', '7', '6'),('118', '8', '8', '3'),('119', '8', '8', '4'),('120', '8', '8', '5'),('121', '8', '8', '12'),('122', '8', '5', '8'),('123', '8', '5', '9'),('124', '8', '5', '10'),('125', '8', '5', '11'),('126', '8', '1', '0'),('127', '8', '9', '0'),('333', '1', '17', '0'),('209', '9', '17', '0'),('210', '9', '7', '6'),('211', '9', '7', '7'),('212', '9', '2', '0'),('213', '9', '4', '12'),('214', '9', '4', '13'),('215', '9', '3', '1'),('216', '9', '3', '2'),('217', '9', '8', '3'),('218', '9', '8', '4'),('219', '9', '8', '5'),('220', '9', '5', '8'),('221', '9', '5', '9'),('222', '9', '5', '10'),('223', '9', '5', '11'),('224', '9', '1', '0'),('225', '9', '9', '0'),('235', '10', '17', '0');
