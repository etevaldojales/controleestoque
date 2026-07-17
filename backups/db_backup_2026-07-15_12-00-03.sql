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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : produto_fornecedor
#

CREATE TABLE `produto_fornecedor` (
  `id_produto` int(10) unsigned NOT NULL,
  `id_fornecedor` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_produto`,`id_fornecedor`),
  KEY `tblproduto_has_tblfornecedor_FKIndex1` (`id_produto`),
  KEY `tblproduto_has_tblfornecedor_FKIndex2` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `secoes` VALUES ('1', 'Usuários', 'usuario.php', '8', 'icon-cog'),('3', 'Clientes', '', '5', 'icon-user'),('2', 'Cadastrar Produtos', 'produtos_cadastrar.php', '3', 'icon-gift'),('4', 'Pedidos', 'pedidos.php', '4', 'icon-shopping-cart'),('5', 'Relatórios', '', '7', 'icon-pencil'),('7', 'Estoque', '', '2', 'icon-th-large'),('8', 'Cadastros', '', '6', 'icon-cogs'),('9', 'Auditoria', 'logs.php', '9', 'icon-comment'),('17', 'PDV', 'pdv.php', '1', 'icon-shopping-cart');

#
# Criação da Tabela : subsecoes
#

CREATE TABLE `subsecoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_secao` varchar(11) NOT NULL,
  `subsecao` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `subsecoes` VALUES ('1', '3', 'Cadastrar', 'clientes.php'),('2', '3', 'Vendas Realizadas', 'vendas_realizadas.php'),('3', '8', 'Categorias', 'categorias.php'),('4', '8', 'Fornecedores', 'fornecedor.php'),('5', '8', 'Marcas', 'marcas.php'),('6', '7', 'Cadastrar', 'estoque_cadastrar.php'),('7', '7', 'Listar', 'estoque_listar.php'),('8', '5', 'Rel. Movimento', 'relatorios.php'),('9', '5', 'Prev. Receita', 'rel_prev_receitas.php'),('10', '5', 'Parc. Vencida', 'rel_parc_vencida.php'),('11', '5', 'Rel. Baixa', 'rel_baixa.php'),('12', '8', 'Bancos', 'bancos.php'),('21', '8', 'Empresa', 'empresa.php'),('22', '5', 'Rel. Sintético', 'rel_sintetico.php');

#
# Criação da Tabela : tblbancos
#

CREATE TABLE `tblbancos` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `funcao` varchar(60) DEFAULT NULL,
  `layout` varchar(60) DEFAULT NULL,
  `stselecionado` smallint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblempresa` VALUES ('1', 'Delícias Dulce', NULL, NULL, NULL, NULL, NULL, '1');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

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
  `cor` varchar(50) NOT NULL,
  `tamanho` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tblestoque_FKIndex1` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : tblformapagamento
#

CREATE TABLE `tblformapagamento` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `tblformapagamento` VALUES ('1', 'Dinheiro'),('2', 'Cartão'),('3', 'Pix'),('4', 'Crédito');

#
# Criação da Tabela : tblfornecedor
#

CREATE TABLE `tblfornecedor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : tblitenspedido
#

CREATE TABLE `tblitenspedido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_produto` int(10) unsigned NOT NULL,
  `id_pedido` int(10) unsigned NOT NULL,
  `quantidade` int(10) unsigned DEFAULT NULL,
  `valor_unitario_compra` float DEFAULT 0,
  `valor_unitario` float DEFAULT NULL,
  `valor_total` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tblitenspedido_FKIndex1` (`id_pedido`),
  KEY `tblitenspedido_FKIndex2` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : tblmarca
#

CREATE TABLE `tblmarca` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : tblpedido
#

CREATE TABLE `tblpedido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(10) unsigned NOT NULL,
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
  KEY `tblpedido_FKIndex1` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#


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
  `codigo` varchar(100) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `local_estoque` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tblproduto_FKIndex1` (`id_marca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : tblservico
#

CREATE TABLE `tblservico` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pedido` int(10) DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : usuarios
#

CREATE TABLE `usuarios` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL DEFAULT '',
  `senha` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `telefone` varchar(25) NOT NULL,
  `foto` varchar(60) DEFAULT NULL,
  `ativo` smallint(1) DEFAULT 0,
  `tipo_usuario` smallint(1) DEFAULT 0,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `usuarios` VALUES ('1', 'admin', '0192023a7bbd73250516f069df18b500', 'admin@localhost.com', 'Etevaldo Jales', '', '', '1', '1');

#
# Criação da Tabela : usuarios_secoes
#

CREATE TABLE `usuarios_secoes` (
  `id_usuario_secoes` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT 0,
  `id_secoes` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_usuario_secoes`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `usuarios_secoes` VALUES ('1', '1', '1'),('2', '1', '2'),('3', '1', '3'),('4', '1', '4'),('5', '1', '5'),('6', '1', '7'),('7', '1', '8'),('8', '1', '9'),('9', '1', '17');

#
# Criação da Tabela : usuarios_subsecoes
#

CREATE TABLE `usuarios_subsecoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(8) NOT NULL,
  `id_secao` int(5) NOT NULL,
  `id_subsecao` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO `usuarios_subsecoes` VALUES ('1', '1', '3', '1'),('2', '1', '3', '2'),('3', '1', '8', '3'),('4', '1', '8', '4'),('5', '1', '8', '5'),('6', '1', '7', '6'),('7', '1', '7', '7'),('8', '1', '5', '8'),('9', '1', '5', '9'),('10', '1', '5', '10'),('11', '1', '5', '11'),('12', '1', '8', '12'),('13', '1', '8', '21'),('14', '1', '5', '22'),('15', '1', '1', '0'),('16', '1', '2', '0'),('17', '1', '4', '0'),('18', '1', '9', '0'),('19', '1', '17', '0');
