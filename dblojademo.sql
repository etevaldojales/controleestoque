-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.34


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema lojademo
--

CREATE DATABASE IF NOT EXISTS lojademo;
USE lojademo;

--
-- Definition of table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `ip` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `mensagem` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hora` (`data`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `logs`
--

/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` (`id`,`data`,`hora`,`ip`,`mensagem`) VALUES 
 (1,'2014-12-23','20:01:00','::1','Raul Rodrigues -  CADASTROU O PEDIDO NUMERO: 1| CLIENTE: JALES S.A| DATA DO PEDIDO: 23/12/2014| VALOR DO PEDIDO: 1.326,00| PRODUTOS: C-210(5), 10 13 4560(8), '),
 (2,'2014-12-23','23:56:00','127.0.0.1','Raul Rodrigues -  CADASTROU O PEDIDO NUMERO: 1| CLIENTE: EMPRESA A| DATA DO PEDIDO: 23/12/2014| VALOR DO PEDIDO: 1.648,80| PRODUTOS: C-210(6), 10 13 4560(10), '),
 (3,'2014-12-27','14:49:00','127.0.0.1','Raul Rodrigues -  ALTEROU O PRODUTO DE: C-210 PARA C-210'),
 (4,'2014-12-27','16:17:00','127.0.0.1','Raul Rodrigues -  ALTEROU O PRODUTO DE: 10 13 4560 PARA 10 13 4560'),
 (5,'2014-12-27','16:22:00','127.0.0.1','Raul Rodrigues -  ALTEROU O PRODUTO DE: C-210 PARA C-210'),
 (6,'2014-12-27','16:27:00','127.0.0.1','Raul Rodrigues -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: , QUANTIDADE: 30'),
 (7,'2014-12-27','16:28:00','127.0.0.1','Raul Rodrigues -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: , QUANTIDADE: 45'),
 (8,'2014-12-27','16:40:00','127.0.0.1','Raul Rodrigues -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: C-210, QUANTIDADE: 15'),
 (9,'2014-12-27','16:52:00','127.0.0.1','Raul Rodrigues -  CADASTROU O PEDIDO NUMERO: 1| CLIENTE: JALES S.A| DATA DO PEDIDO: 27/12/2014| VALOR DO PEDIDO: 1.138,80| PRODUTOS: C-210(10), 10 13 4560(4), '),
 (10,'2014-12-27','16:57:00','127.0.0.1','Raul Rodrigues -  CADASTROU O PEDIDO NUMERO: 2| CLIENTE: EMPRESA A| DATA DO PEDIDO: 27/12/2014| VALOR DO PEDIDO: 184,80| PRODUTOS: C-210(1), 10 13 4560(1), '),
 (11,'2014-12-27','16:58:00','127.0.0.1','Raul Rodrigues -  CADASTROU O PEDIDO NUMERO: 2| CLIENTE: JALES S.A| DATA DO PEDIDO: 27/12/2014| VALOR DO PEDIDO: 1.317,00| PRODUTOS: C-210(5), 10 13 4560(8), '),
 (12,'2014-12-27','17:19:00','127.0.0.1','Raul Rodrigues -  CADASTROU O PEDIDO NUMERO: 3| CLIENTE: JALES S.A| DATA DO PEDIDO: 27/12/2014| VALOR DO PEDIDO: 182,40| PRODUTOS: C-210(1), 10 13 4560(1), '),
 (13,'2014-12-27','17:20:00','127.0.0.1','Raul Rodrigues -  CADASTROU O PEDIDO NUMERO: 4| CLIENTE: EMPRESA A| DATA DO PEDIDO: 27/12/2014| VALOR DO PEDIDO: 673,20| PRODUTOS: C-210(3), 10 13 4560(4), '),
 (14,'2014-12-28','17:19:00','127.0.0.1','Etevaldo Jales -  ALTEROU A MARCA DE: BANDO PARA MR2'),
 (15,'2014-12-28','17:19:00','127.0.0.1','Etevaldo Jales -  ALTEROU A MARCA DE: DAYCO PARA SKYLER'),
 (16,'2014-12-28','17:20:00','127.0.0.1','Etevaldo Jales -  ALTEROU A MARCA DE: GOODYEAR PARA HANDARA'),
 (17,'2014-12-28','17:20:00','127.0.0.1','Etevaldo Jales -  EXCLUIU A MARCA JASON'),
 (18,'2014-12-28','17:20:00','127.0.0.1','Etevaldo Jales -  EXCLUIU A MARCA OPTIBELT'),
 (19,'2014-12-28','17:20:00','127.0.0.1','Etevaldo Jales -  EXCLUIU A MARCA RPP SILVER'),
 (20,'2014-12-28','17:20:00','127.0.0.1','Etevaldo Jales -  EXCLUIU A MARCA SUNBELT'),
 (21,'2014-12-28','17:21:00','127.0.0.1','Etevaldo Jales -  ALTEROU A CATEGORIA DE: Correias PARA MASCULINO'),
 (22,'2014-12-28','17:21:00','127.0.0.1','Etevaldo Jales -  ALTEROU A CATEGORIA DE: Rolamentos PARA FEMININO'),
 (23,'2014-12-28','17:21:00','127.0.0.1','Etevaldo Jales -  CADASTROU A CATEGORIA: INFANTIL'),
 (24,'2014-12-28','17:22:00','127.0.0.1','Etevaldo Jales -  CADASTROU A CATEGORIA: PERFUMES'),
 (25,'2014-12-28','17:22:00','127.0.0.1','Etevaldo Jales -  ALTEROU A CATEGORIA DE: PERFUMES PARA PERFUMARIA'),
 (26,'2014-12-28','17:22:00','127.0.0.1','Etevaldo Jales -  CADASTROU A CATEGORIA: ACESS?RIOS'),
 (27,'2014-12-28','17:23:00','127.0.0.1','Etevaldo Jales -  CADASTROU O FORNECEDOR: TESTE FORNECEDOR'),
 (28,'2014-12-28','22:23:00','127.0.0.1','Etevaldo Jales -  CADASTROU O PRODUTO: 37251'),
 (29,'2014-12-28','22:23:00','127.0.0.1','Etevaldo Jales -  CADASTROU O PRODUTO: 37251'),
 (30,'2015-02-16','13:58:00','127.0.0.1','Etevaldo Jales -  CADASTROU O PRODUTO: Per-356'),
 (31,'2015-02-16','14:19:00','127.0.0.1','Etevaldo Jales -  ALTEROU O PRODUTO DE: Per-356 PARA Per-356'),
 (32,'2015-02-16','14:20:00','127.0.0.1','Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: Per-356, QUANTIDADE: 10'),
 (33,'2015-02-16','14:35:00','127.0.0.1','Etevaldo Jales -  CADASTROU O PRODUTO: P-257'),
 (34,'2015-02-16','14:36:00','127.0.0.1','Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: P-257, QUANTIDADE: 10'),
 (35,'2015-02-16','14:37:00','127.0.0.1','Etevaldo Jales -  ALTEROU O PRODUTO DE: Per-356 PARA P-356'),
 (36,'2015-02-16','14:59:00','127.0.0.1','Etevaldo Jales -  ALTEROU O CLIENTE: EMPRESA A. DADOS ANTERIORES: NOME: EMPRESA A, EMAIL: raul@enjoydesign.com.br, TELEFONE: (85) 9112-9442, ENDERE?O: Raul DADOS ATUAIS: NOME: Ducileide (Deinha), EMAIL: deinhadesousa@yahoo.com.br, TELEFONE: (85) 9840-3012, ENDEREC?O: Rua Humberto Lomeu, 3159 Cearazinho'),
 (37,'2015-02-16','15:00:00','127.0.0.1','Etevaldo Jales -  ALTEROU O CLIENTE: JALES S.A. DADOS ANTERIORES: NOME: JALES S.A, EMAIL: etevaldojales@gmail.com, TELEFONE: (85) 8949-7715, ENDERE?O: Anália DADOS ATUAIS: NOME: JALES S.A, EMAIL: etevaldojales@gmail.com, TELEFONE: (85) 8949-7715, ENDEREC?O: Rua Humberto Lomeu, 3159 Cearazinho'),
 (38,'2015-02-16','15:02:00','127.0.0.1','Etevaldo Jales -  CADASTROU O CLIENTE: Maria de F?tima Gomes da Costa, ENDERE?O: Av. Central, 3587 Conj. Cear?, TELEFONE: (85) 3287-4463, EMAIL: fatima@gmail.com'),
 (39,'2015-02-16','15:03:00','127.0.0.1','Etevaldo Jales -  CADASTROU O CLIENTE: Teste, ENDERE?O: Tesste, TELEFONE: (88) 8888-8888, EMAIL: xxx@gmail.com'),
 (40,'2015-02-16','15:03:00','127.0.0.1','Etevaldo Jales -  EXCLUIU A CLIENTE '),
 (41,'2015-02-16','15:53:00','127.0.0.1','Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 1| CLIENTE: | DATA DO PEDIDO: 16/02/2015| VALOR DO PEDIDO: 530,00| PRODUTOS: P-356(3), P-257(2), '),
 (42,'2015-02-17','19:07:00','127.0.0.1','Carina -  CADASTROU O PEDIDO NUMERO: 2| CLIENTE: | DATA DO PEDIDO: 17/02/2015| VALOR DO PEDIDO: 630,00| PRODUTOS: P-356(4), P-257(2), '),
 (43,'2015-02-17','20:00:00','127.0.0.1','Carina -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: P-257, QUANTIDADE: 10'),
 (44,'2015-02-18','13:38:00','127.0.0.1','Carina -  CADASTROU O PRODUTO: P358'),
 (45,'2015-02-18','13:40:00','127.0.0.1','Carina -  CADASTROU O PEDIDO NUMERO: 3| CLIENTE: | DATA DO PEDIDO: 18/02/2015| VALOR DO PEDIDO: 455,00| PRODUTOS: P-356(1), P-257(1), P358(2), '),
 (46,'2015-02-18','13:49:00','127.0.0.1','Carina -  CADASTROU O PEDIDO NUMERO: 4| CLIENTE: | DATA DO PEDIDO: 18/02/2015| VALOR DO PEDIDO: 475,00| PRODUTOS: P-257(1), P358(3), '),
 (47,'2015-02-18','13:52:00','127.0.0.1','Carina -  CADASTROU O PEDIDO NUMERO: 5| CLIENTE: | DATA DO PEDIDO: 18/02/2015| VALOR DO PEDIDO: 575,00| PRODUTOS: P-356(1), P-257(1), P358(3), '),
 (48,'2015-02-18','13:55:00','127.0.0.1','Carina -  CADASTROU O PEDIDO NUMERO: 6| CLIENTE: | DATA DO PEDIDO: 18/02/2015| VALOR DO PEDIDO: 335,00| PRODUTOS: P-356(1), P-257(1), P358(1), '),
 (49,'2015-02-18','14:41:00','127.0.0.1','Carina -  CADASTROU A CATEGORIA: Teste'),
 (50,'2015-02-18','14:41:00','127.0.0.1','Carina -  ALTEROU A CATEGORIA DE: Teste PARA Testedfsdgfg'),
 (51,'2015-02-18','14:42:00','127.0.0.1','Carina -  EXCLUIU A CATEGORIA: Testedfsdgfg'),
 (52,'2015-02-18','14:42:00','127.0.0.1','Carina -  CADASTROU O FORNECEDOR: NATURA'),
 (53,'2015-02-18','14:44:00','127.0.0.1','Carina -  CADASTROU O PRODUTO: P-325'),
 (54,'2015-02-18','14:45:00','127.0.0.1','Carina -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: P-325, QUANTIDADE: 10'),
 (55,'2015-02-18','14:46:00','127.0.0.1','Carina -  CADASTROU O CLIENTE: Carina, ENDERE?O: Rua tal, TELEFONE: (85) 8888-8888, EMAIL: '),
 (56,'2015-02-18','14:47:00','127.0.0.1','Carina -  CADASTROU O PEDIDO NUMERO: 7| CLIENTE: | DATA DO PEDIDO: 18/02/2015| VALOR DO PEDIDO: 655,00| PRODUTOS: P-356(3), P-257(1), P358(2), '),
 (57,'2015-02-18','16:02:00','127.0.0.1','Carina -  ALTEROU O PRODUTO DE:  PARA Cal?a Jeans'),
 (58,'2015-02-18','16:03:00','127.0.0.1','Carina -  ALTEROU O PRODUTO DE:  PARA Camisa Regata'),
 (59,'2015-02-18','16:03:00','127.0.0.1','Carina -  CADASTROU A MARCA: BOTIC?RIO'),
 (60,'2015-02-18','16:04:00','127.0.0.1','Carina -  ALTEROU O PRODUTO DE:  PARA COFFE'),
 (61,'2015-02-18','16:04:00','127.0.0.1','Carina -  ALTEROU O PRODUTO DE: COFFE PARA PERFUME COFFE'),
 (62,'2015-02-18','16:05:00','127.0.0.1','Carina -  CADASTROU A MARCA: ?GUA DE CHEIRO'),
 (63,'2015-02-18','16:06:00','127.0.0.1','Carina -  ALTEROU O PRODUTO DE:  PARA ESSENCIAL'),
 (64,'2015-02-18','16:15:00','127.0.0.1','Carina -  CADASTROU O PEDIDO NUMERO: 8| CLIENTE: | DATA DO PEDIDO: 18/02/2015| VALOR DO PEDIDO: 635,00| PRODUTOS: P-356(1), P-325(3), P358(2), P-257(1), '),
 (65,'2015-02-20','19:26:00','127.0.0.1','Etevaldo Jales -  CADASTROU O CLIENTE: Maria Ducineide Pereira de Sousa, ENDERE?O: Rua Humberto Lomeu, 3201, TELEFONE: (85) 9999-9999, EMAIL: cinhadesousa@yahoo.com.br'),
 (66,'2015-02-21','19:01:00','127.0.0.1','Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: P358, QUANTIDADE: 10'),
 (67,'2015-02-21','19:01:00','127.0.0.1','Etevaldo Jales -  ALTEROU O PRODUTO DE: Calça Jeans PARA Cal?a Jeans'),
 (68,'2015-02-21','19:04:00','127.0.0.1','Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 9| CLIENTE: | DATA DO PEDIDO: 21/02/2015| VALOR DO PEDIDO: 445,00| PRODUTOS: P-356(1), P-257(3), '),
 (69,'2015-02-21','20:08:00','127.0.0.1','Etevaldo Jales -  ALTEROU O FORNECEDOR DE: NOME DA LOJA PARA NOME DO FORNECEDOR'),
 (70,'2015-02-21','20:09:00','127.0.0.1','Etevaldo Jales -  ALTEROU O FORNECEDOR DE: NOME DO FORNECEDOR PARA JR DISTRIBUIDOR'),
 (71,'2015-02-21','20:12:00','127.0.0.1','Etevaldo Jales -  ALTEROU O CLIENTE: Carina. DADOS ANTERIORES: NOME: Carina, EMAIL: , TELEFONE: (85) 8888-8888, ENDERE?O: Rua tal DADOS ATUAIS: NOME: Carina Fernandes da Silva, EMAIL: , TELEFONE: (85) 8888-8888, ENDEREC?O: Av. Central, 569 Conj. Cear? Fortaleza - Ce'),
 (72,'2015-02-21','20:18:00','127.0.0.1','Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 1| CLIENTE: | DATA DO PEDIDO: 21/02/2015| VALOR DO PEDIDO: 395,00| PRODUTOS: P-356(1), P-257(1), P358(1), P-325(1), '),
 (73,'2015-02-21','20:21:00','127.0.0.1','Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 1| CLIENTE: | DATA DO PEDIDO: 21/02/2015| VALOR DO PEDIDO: 455,00| PRODUTOS: P-356(1), P-257(1), P358(1), P-325(2), '),
 (74,'2015-02-22','16:42:00','127.0.0.1','Etevaldo Jales -  CADASTROU A CATEGORIA: Teste'),
 (75,'2015-02-22','16:42:00','127.0.0.1','Etevaldo Jales -  ALTEROU A CATEGORIA DE: Teste PARA Testeweeqeq'),
 (76,'2015-02-22','16:42:00','127.0.0.1','Etevaldo Jales -  EXCLUIU A CATEGORIA: Testeweeqeq'),
 (77,'2015-02-22','16:42:00','127.0.0.1','Etevaldo Jales -  ALTEROU O FORNECEDOR DE: TESTE FORNECEDOR PARA Botic?rio'),
 (78,'2015-02-22','16:44:00','127.0.0.1','Etevaldo Jales -  CADASTROU O CLIENTE: Maria An?lia de Sousa Jales, ENDERE?O: Rua Humberto Lomeu, TELEFONE: (85) 8888-8888, EMAIL: '),
 (79,'2015-02-22','16:47:00','127.0.0.1','Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 2| CLIENTE: | DATA DO PEDIDO: 22/02/2015| VALOR DO PEDIDO: 575,00| PRODUTOS: P-356(1), P-257(1), P358(3), '),
 (80,'2015-02-22','16:56:00','127.0.0.1','Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: P-325, QUANTIDADE: 10'),
 (81,'2015-03-01','22:47:00','127.0.0.1','Etevaldo Jales -  CADASTROU A CATEGORIA: Teste'),
 (82,'2015-03-01','22:48:00','127.0.0.1','Etevaldo Jales -  ALTEROU A CATEGORIA DE: Teste PARA Testeddqwewqeqeq'),
 (83,'2015-03-01','22:48:00','127.0.0.1','Etevaldo Jales -  EXCLUIU A CATEGORIA: Testeddqwewqeqeq'),
 (84,'2015-03-01','22:48:00','127.0.0.1','Etevaldo Jales -  ALTEROU O FORNECEDOR DE: Boticário PARA BOTIC?RIO'),
 (85,'2015-03-12','17:35:00','127.0.0.1','Etevaldo Jales -  CADASTROU A CATEGORIA: TESTE'),
 (86,'2015-03-12','17:36:00','127.0.0.1','Etevaldo Jales -  ALTEROU A CATEGORIA DE: TESTE PARA TESTESSS'),
 (87,'2015-03-12','17:36:00','127.0.0.1','Etevaldo Jales -  EXCLUIU A CATEGORIA: TESTESSS'),
 (88,'2015-03-12','17:38:00','127.0.0.1','Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: P358, QUANTIDADE: 10'),
 (89,'2015-03-12','17:44:00','127.0.0.1','Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 3| CLIENTE: | DATA DO PEDIDO: 12/03/2015| VALOR DO PEDIDO: 750,00| PRODUTOS: P-356(1), P-257(2), P358(3), P-325(1), '),
 (90,'2015-03-25','17:07:00','127.0.0.1','Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 4| CLIENTE: | DATA DO PEDIDO: 25/03/2015| VALOR DO PEDIDO: 235,00| PRODUTOS: P-257(1), P358(1), ');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;


--
-- Definition of table `produto_fornecedor`
--

DROP TABLE IF EXISTS `produto_fornecedor`;
CREATE TABLE `produto_fornecedor` (
  `id_produto` int(10) unsigned NOT NULL,
  `id_fornecedor` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_produto`,`id_fornecedor`),
  KEY `tblproduto_has_tblfornecedor_FKIndex1` (`id_produto`),
  KEY `tblproduto_has_tblfornecedor_FKIndex2` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produto_fornecedor`
--

/*!40000 ALTER TABLE `produto_fornecedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `produto_fornecedor` ENABLE KEYS */;


--
-- Definition of table `secoes`
--

DROP TABLE IF EXISTS `secoes`;
CREATE TABLE `secoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secao` varchar(100) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `posicao` int(11) NOT NULL DEFAULT '0',
  `icone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secoes`
--

/*!40000 ALTER TABLE `secoes` DISABLE KEYS */;
INSERT INTO `secoes` (`id`,`secao`,`url`,`posicao`,`icone`) VALUES 
 (1,'Usuários','usuario.php',7,'icon-cog'),
 (3,'Clientes','',4,'icon-user'),
 (2,'Cadastrar Produtos','produtos_cadastrar.php',2,'icon-gift'),
 (4,'Pedidos','vendas.php',3,'icon-shopping-cart'),
 (5,'Relatórios','',6,'icon-pencil'),
 (7,'Estoque','',1,'icon-th-large'),
 (8,'Configuração',NULL,5,'icon-cogs');
/*!40000 ALTER TABLE `secoes` ENABLE KEYS */;


--
-- Definition of table `subsecoes`
--

DROP TABLE IF EXISTS `subsecoes`;
CREATE TABLE `subsecoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_secao` varchar(11) NOT NULL,
  `subsecao` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subsecoes`
--

/*!40000 ALTER TABLE `subsecoes` DISABLE KEYS */;
INSERT INTO `subsecoes` (`id`,`id_secao`,`subsecao`,`url`) VALUES 
 (1,'3','Cadastrar','clientes.php'),
 (2,'3','Vendas Realizadas','vendas_realizadas.php'),
 (3,'8','Categorias','categorias.php'),
 (4,'8','Fornecedores','fornecedor.php'),
 (5,'8','Marcas','marcas.php'),
 (6,'7','Cadastrar','estoque_cadastrar.php'),
 (7,'7','Listar','index.php'),
 (8,'5','Rel. Movimento','relatorios.php'),
 (9,'5','Prev. Receita','rel_prev_receitas.php'),
 (10,'5','Parc. Vencida','rel_parc_vencida.php'),
 (11,'5','Rel. Baixa','rel_baixa.php'),
 (12,'8','Bancos','bancos.php');
/*!40000 ALTER TABLE `subsecoes` ENABLE KEYS */;


--
-- Definition of table `tblbancos`
--

DROP TABLE IF EXISTS `tblbancos`;
CREATE TABLE `tblbancos` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `funcao` varchar(60) DEFAULT NULL,
  `layout` varchar(60) DEFAULT NULL,
  `stselecionado` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbancos`
--

/*!40000 ALTER TABLE `tblbancos` DISABLE KEYS */;
INSERT INTO `tblbancos` (`id`,`funcao`,`layout`,`stselecionado`) VALUES 
 (1,'include/funcoes_bb.php','include/layout_bb.php',0),
 (2,'include/funcoes_cef.php','include/layout_cef.php',0),
 (3,'include/funcoes_bradesco.php','include/layout_bradesco.php',1),
 (4,'include/funcoes_itau.php','include/layout_itau.php',0),
 (5,'include/funcoes_hsbc.php','include/layout_hsbc.php',0),
 (6,'include/funcoes_real.php','include/layout_real.php',0),
 (7,'include/funcoes_banespa.php','include/layout_banespa.php',0),
 (8,'include/funcoes_banestes.php','include/layout_banestes.php',0),
 (9,'include/funcoes_nossacaixa.php','include/layout_nossacaixa.php',0),
 (10,'include/funcoes_bancoob.php','include/layout_bancoob.php',0),
 (11,'include/funcoes_besc.php','include/layout_besc.php',0),
 (12,'include/funcoes_santander_banespa.php','include/layout_santander_banespa.php',0),
 (13,'include/funcoes_sicredi.php','include/layout_sicredi.php',0),
 (14,'include/funcoes_sudameris.php','include/layout_sudameris.php',0),
 (15,'include/funcoes_unibanco.php','include/funcoes_unibanco.php',0),
 (16,NULL,NULL,0);
/*!40000 ALTER TABLE `tblbancos` ENABLE KEYS */;


--
-- Definition of table `tblcategoria`
--

DROP TABLE IF EXISTS `tblcategoria`;
CREATE TABLE `tblcategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcategoria`
--

/*!40000 ALTER TABLE `tblcategoria` DISABLE KEYS */;
INSERT INTO `tblcategoria` (`id`,`descricao`) VALUES 
 (1,'FEMININO'),
 (2,'MASCULINO'),
 (3,'INFANTIL'),
 (4,'PERFUMARIA'),
 (5,'ACESSÓRIOS');
/*!40000 ALTER TABLE `tblcategoria` ENABLE KEYS */;


--
-- Definition of table `tblcliente`
--

DROP TABLE IF EXISTS `tblcliente`;
CREATE TABLE `tblcliente` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `stativo` smallint(1) NOT NULL DEFAULT '0' COMMENT '0: Inativo; 1: Ativo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcliente`
--

/*!40000 ALTER TABLE `tblcliente` DISABLE KEYS */;
INSERT INTO `tblcliente` (`id`,`nome`,`telefone`,`email`,`endereco`,`stativo`) VALUES 
 (2,'Ducileide (Deinha)','(85) 9840-3012','deinhadesousa@yahoo.com.br','Rua Humberto Lomeu, 3159 Cearazinho',1),
 (3,'JALES S.A','(85) 8949-7715','etevaldojales@gmail.com','Rua Humberto Lomeu, 3159 Cearazinho',1),
 (4,'Maria de Fátima Gomes da Costa','(85) 3287-4463','fatima@gmail.com','Av. Central, 3587 Conj. Ceará',1),
 (5,'Carina Fernandes da Silva','(85) 8888-8888','','Av. Central, 569 Conj. Ceará Fortaleza - Ce',1),
 (6,'Maria Ducineide Pereira de Sousa','(85) 9999-9999','cinhadesousa@yahoo.com.br','Rua Humberto Lomeu, 3201',1),
 (7,'Maria Anália de Sousa Jales','(85) 8888-8888','','Rua Humberto Lomeu',1);
/*!40000 ALTER TABLE `tblcliente` ENABLE KEYS */;


--
-- Definition of table `tblcredito`
--

DROP TABLE IF EXISTS `tblcredito`;
CREATE TABLE `tblcredito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `valor` float NOT NULL DEFAULT '0',
  `saldo` float NOT NULL DEFAULT '0',
  `data` date NOT NULL,
  `stcredito` smallint(1) DEFAULT '0' COMMENT '1: Credito; 2: Debito',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcredito`
--

/*!40000 ALTER TABLE `tblcredito` DISABLE KEYS */;
INSERT INTO `tblcredito` (`id`,`id_cliente`,`valor`,`saldo`,`data`,`stcredito`) VALUES 
 (1,5,58.33,58.33,'2015-02-22',1);
/*!40000 ALTER TABLE `tblcredito` ENABLE KEYS */;


--
-- Definition of table `tblempresa`
--

DROP TABLE IF EXISTS `tblempresa`;
CREATE TABLE `tblempresa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblempresa`
--

/*!40000 ALTER TABLE `tblempresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblempresa` ENABLE KEYS */;


--
-- Definition of table `tblentrada`
--

DROP TABLE IF EXISTS `tblentrada`;
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblentrada`
--

/*!40000 ALTER TABLE `tblentrada` DISABLE KEYS */;
INSERT INTO `tblentrada` (`id`,`id_usuario`,`id_pedido`,`id_forma_pag`,`valor`,`vencimento`,`valor_pag`,`data_pgto`,`valor_rec`,`multa`,`juros`,`flgstatus`,`recibo`) VALUES 
 (1,2,3,4,100,'2015-03-12',100,'2015-03-12',100,0,0,2,'R01');
/*!40000 ALTER TABLE `tblentrada` ENABLE KEYS */;


--
-- Definition of table `tblestoque`
--

DROP TABLE IF EXISTS `tblestoque`;
CREATE TABLE `tblestoque` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_produto` int(10) unsigned NOT NULL,
  `qtdentrada` int(10) unsigned DEFAULT NULL,
  `qtdsaida` int(10) unsigned DEFAULT NULL,
  `qtdacumulado` int(10) unsigned DEFAULT NULL,
  `data` date DEFAULT NULL,
  `cor` varchar(50) NOT NULL,
  `tamanho` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tblestoque_FKIndex1` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblestoque`
--

/*!40000 ALTER TABLE `tblestoque` DISABLE KEYS */;
INSERT INTO `tblestoque` (`id`,`id_produto`,`qtdentrada`,`qtdsaida`,`qtdacumulado`,`data`,`cor`,`tamanho`) VALUES 
 (1,1,10,0,10,'2015-02-16','',''),
 (2,1,10,0,20,'2015-02-16','',''),
 (3,2,12,0,12,'2015-02-16','',''),
 (4,2,10,0,22,'2015-02-16','',''),
 (5,1,0,3,17,'2015-02-16','',''),
 (6,2,0,2,20,'2015-02-16','',''),
 (7,1,0,4,13,'2015-02-17','',''),
 (8,2,0,2,18,'2015-02-17','',''),
 (9,2,10,0,28,'2015-02-17','',''),
 (10,3,10,0,10,'2015-02-18','',''),
 (11,1,0,1,12,'2015-02-18','',''),
 (12,2,0,1,27,'2015-02-18','',''),
 (13,3,0,2,8,'2015-02-18','',''),
 (14,2,0,1,26,'2015-02-18','',''),
 (15,3,0,3,5,'2015-02-18','',''),
 (16,1,0,1,11,'2015-02-18','',''),
 (17,2,0,1,25,'2015-02-18','',''),
 (18,3,0,3,2,'2015-02-18','',''),
 (19,1,0,1,10,'2015-02-18','',''),
 (20,2,0,1,24,'2015-02-18','',''),
 (21,3,0,1,1,'2015-02-18','',''),
 (22,4,10,0,10,'2015-02-18','',''),
 (23,4,10,0,20,'2015-02-18','',''),
 (24,1,0,3,7,'2015-02-18','',''),
 (25,2,0,1,23,'2015-02-18','',''),
 (26,3,0,2,0,'2015-02-18','',''),
 (27,1,0,1,6,'2015-02-18','',''),
 (28,4,0,3,17,'2015-02-18','',''),
 (29,3,0,2,0,'2015-02-18','',''),
 (30,2,0,1,22,'2015-02-18','',''),
 (31,3,10,0,10,'2015-02-21','',''),
 (32,1,0,1,5,'2015-02-21','',''),
 (33,2,0,3,19,'2015-02-21','',''),
 (34,1,0,1,4,'2015-02-21','',''),
 (35,2,0,1,18,'2015-02-21','',''),
 (36,3,0,1,9,'2015-02-21','',''),
 (37,4,0,1,16,'2015-02-21','',''),
 (38,1,0,1,3,'2015-02-21','',''),
 (39,2,0,1,17,'2015-02-21','',''),
 (40,3,0,1,8,'2015-02-21','',''),
 (41,4,0,2,14,'2015-02-21','',''),
 (42,1,0,1,2,'2015-02-22','',''),
 (43,2,0,1,16,'2015-02-22','',''),
 (44,3,0,3,5,'2015-02-22','',''),
 (45,4,10,0,24,'2015-02-22','',''),
 (46,3,10,0,15,'2015-03-12','',''),
 (47,1,0,1,1,'2015-03-12','',''),
 (48,2,0,2,14,'2015-03-12','',''),
 (49,3,0,3,12,'2015-03-12','',''),
 (50,4,0,1,23,'2015-03-12','',''),
 (51,2,0,1,13,'2015-03-25','',''),
 (52,3,0,1,11,'2015-03-25','','');
/*!40000 ALTER TABLE `tblestoque` ENABLE KEYS */;


--
-- Definition of table `tblformapagamento`
--

DROP TABLE IF EXISTS `tblformapagamento`;
CREATE TABLE `tblformapagamento` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblformapagamento`
--

/*!40000 ALTER TABLE `tblformapagamento` DISABLE KEYS */;
INSERT INTO `tblformapagamento` (`id`,`descricao`) VALUES 
 (1,'Boleto'),
 (2,'Cartão de crédito'),
 (3,'Cheque'),
 (4,'Dinheiro'),
 (5,'PagSeguro'),
 (6,'Cartão (Débito)');
/*!40000 ALTER TABLE `tblformapagamento` ENABLE KEYS */;


--
-- Definition of table `tblfornecedor`
--

DROP TABLE IF EXISTS `tblfornecedor`;
CREATE TABLE `tblfornecedor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblfornecedor`
--

/*!40000 ALTER TABLE `tblfornecedor` DISABLE KEYS */;
INSERT INTO `tblfornecedor` (`id`,`descricao`) VALUES 
 (5,'JR DISTRIBUIDOR'),
 (6,'BOTICÁRIO'),
 (7,'NATURA');
/*!40000 ALTER TABLE `tblfornecedor` ENABLE KEYS */;


--
-- Definition of table `tblitenspedido`
--

DROP TABLE IF EXISTS `tblitenspedido`;
CREATE TABLE `tblitenspedido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_produto` int(10) unsigned NOT NULL,
  `id_pedido` int(10) unsigned NOT NULL,
  `quantidade` int(10) unsigned DEFAULT NULL,
  `valor_unitario_compra` float DEFAULT '0',
  `valor_unitario` float DEFAULT NULL,
  `valor_total` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tblitenspedido_FKIndex1` (`id_pedido`),
  KEY `tblitenspedido_FKIndex2` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblitenspedido`
--

/*!40000 ALTER TABLE `tblitenspedido` DISABLE KEYS */;
INSERT INTO `tblitenspedido` (`id`,`id_produto`,`id_pedido`,`quantidade`,`valor_unitario_compra`,`valor_unitario`,`valor_total`) VALUES 
 (1,1,1,1,70,100,100),
 (2,2,1,1,78,115,115),
 (3,3,1,1,78,120,120),
 (4,4,1,2,45,60,120),
 (5,1,2,1,70,100,100),
 (6,2,2,1,78,115,115),
 (7,3,2,3,78,120,360),
 (8,1,3,1,70,100,100),
 (9,2,3,2,78,115,230),
 (10,3,3,3,78,120,360),
 (11,4,3,1,45,60,60),
 (12,2,4,1,78,115,115),
 (13,3,4,1,78,120,120);
/*!40000 ALTER TABLE `tblitenspedido` ENABLE KEYS */;


--
-- Definition of table `tblmarca`
--

DROP TABLE IF EXISTS `tblmarca`;
CREATE TABLE `tblmarca` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblmarca`
--

/*!40000 ALTER TABLE `tblmarca` DISABLE KEYS */;
INSERT INTO `tblmarca` (`id`,`descricao`) VALUES 
 (15,'SKYLER'),
 (18,'S/MARCA'),
 (20,'HANDARA'),
 (22,'MR2'),
 (23,'BOTICÁRIO'),
 (24,'ÁGUA DE CHEIRO');
/*!40000 ALTER TABLE `tblmarca` ENABLE KEYS */;


--
-- Definition of table `tblparcela`
--

DROP TABLE IF EXISTS `tblparcela`;
CREATE TABLE `tblparcela` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_pedido` int(10) unsigned NOT NULL,
  `id_forma_pag` int(5) DEFAULT '0',
  `valor_parcela` float DEFAULT NULL,
  `vencimento` date DEFAULT NULL,
  `valor_pag` float DEFAULT NULL,
  `data_pgto` date DEFAULT NULL,
  `valor_rec` float DEFAULT NULL,
  `multa` float DEFAULT NULL,
  `juros` float DEFAULT NULL,
  `flgstatus` smallint(1) NOT NULL DEFAULT '1' COMMENT '1: Pendente; 2: Pago',
  `recibo` varchar(100) DEFAULT NULL,
  `nosso_numero` int(8) DEFAULT '0',
  `stEstorno` smallint(1) DEFAULT '0' COMMENT '0: Não Estornado; 1: Estornado ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nosso_numero` (`nosso_numero`),
  KEY `tblparcela_FKIndex1` (`id_pedido`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblparcela`
--

/*!40000 ALTER TABLE `tblparcela` DISABLE KEYS */;
INSERT INTO `tblparcela` (`id`,`id_usuario`,`id_pedido`,`id_forma_pag`,`valor_parcela`,`vencimento`,`valor_pag`,`data_pgto`,`valor_rec`,`multa`,`juros`,`flgstatus`,`recibo`,`nosso_numero`,`stEstorno`) VALUES 
 (1,2,1,2,151.67,'2015-03-30',0,'0000-00-00',0,0,0,1,NULL,1,0),
 (2,2,1,2,151.67,'2015-04-30',0,'0000-00-00',0,0,0,1,NULL,2,0),
 (3,2,1,2,151.66,'2015-05-30',0,'0000-00-00',0,0,0,1,NULL,3,0),
 (4,2,2,4,191.67,'2015-03-30',191.67,'2015-02-22',191.67,0,0,2,'R01',4,0),
 (5,2,2,4,191.67,'2015-04-30',191.67,'2015-03-01',191.67,0,0,2,'R2',5,0),
 (6,2,2,1,191.66,'2015-05-30',0,'0000-00-00',0,0,0,1,NULL,6,0),
 (7,2,3,4,162.5,'2015-04-13',162.5,'2015-03-12',162.5,0,0,2,'R02',7,0),
 (8,2,3,1,162.5,'2015-05-13',0,'0000-00-00',0,0,0,1,NULL,8,0),
 (9,2,3,1,162.5,'2015-06-13',0,'0000-00-00',0,0,0,1,NULL,9,0),
 (10,2,3,1,162.5,'2015-07-13',0,'0000-00-00',0,0,0,1,NULL,10,0),
 (11,2,4,1,78.33,'2015-04-30',0,'0000-00-00',0,0,0,1,NULL,11,0),
 (12,2,4,1,78.33,'2015-05-30',0,'0000-00-00',0,0,0,1,NULL,12,0),
 (13,2,4,1,78.34,'2015-06-30',0,'0000-00-00',0,0,0,1,NULL,13,0);
/*!40000 ALTER TABLE `tblparcela` ENABLE KEYS */;


--
-- Definition of table `tblpedido`
--

DROP TABLE IF EXISTS `tblpedido`;
CREATE TABLE `tblpedido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(10) unsigned NOT NULL,
  `numero_pedido` int(10) unsigned NOT NULL DEFAULT '0',
  `data_pedido` date DEFAULT NULL,
  `primeiro_venc` date DEFAULT NULL,
  `num_parc` int(5) DEFAULT '0',
  `id_formapag` int(5) DEFAULT '0',
  `valor_custo` float DEFAULT '0',
  `valor_venda` float DEFAULT '0',
  `valor` float DEFAULT NULL,
  `status_pedido` smallint(1) unsigned NOT NULL COMMENT '1: Em aberto; 2: Concluido; 3: Cancelado',
  `observacao` text,
  PRIMARY KEY (`id`),
  KEY `tblpedido_FKIndex1` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpedido`
--

/*!40000 ALTER TABLE `tblpedido` DISABLE KEYS */;
INSERT INTO `tblpedido` (`id`,`id_cliente`,`numero_pedido`,`data_pedido`,`primeiro_venc`,`num_parc`,`id_formapag`,`valor_custo`,`valor_venda`,`valor`,`status_pedido`,`observacao`) VALUES 
 (1,6,1,'2015-02-21',NULL,0,0,316,455,455,2,''),
 (2,5,2,'2015-02-22',NULL,0,0,382,575,575,2,''),
 (3,6,3,'2015-03-12',NULL,0,0,505,750,750,2,'Observação do pedido'),
 (4,7,4,'2015-03-25',NULL,0,0,156,235,235,2,'');
/*!40000 ALTER TABLE `tblpedido` ENABLE KEYS */;


--
-- Definition of table `tblproduto`
--

DROP TABLE IF EXISTS `tblproduto`;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblproduto`
--

/*!40000 ALTER TABLE `tblproduto` DISABLE KEYS */;
INSERT INTO `tblproduto` (`id`,`id_categoria`,`id_marca`,`id_fornecedor`,`nome`,`valor_compra`,`valor`,`codigo`,`data_cadastro`,`local_estoque`) VALUES 
 (1,2,22,5,'Calça Jeans',70,100,'P-356','2015-02-16','2015/02/21'),
 (2,2,15,5,'Camisa Regata',78,115,'P-257','2015-02-16','2015/02/18'),
 (3,4,23,5,'PERFUME COFFE',78,120,'P358','2015-02-18','2015/02/18'),
 (4,4,24,7,'ESSENCIAL',45,60,'P-325','2015-02-18','2015/02/18');
/*!40000 ALTER TABLE `tblproduto` ENABLE KEYS */;


--
-- Definition of table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL DEFAULT '',
  `senha` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `telefone` varchar(25) NOT NULL,
  `foto` varchar(60) DEFAULT NULL,
  `ativo` smallint(1) DEFAULT '0',
  `tipo_usuario` smallint(1) DEFAULT '0',
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id_usuario`,`login`,`senha`,`email`,`nome`,`telefone`,`foto`,`ativo`,`tipo_usuario`) VALUES 
 (76,'carina','e68b262dfb5013ae634b182f5d390db8','carina@gmail.com','Carina','(85) 9999-9999','',1,2),
 (2,'etevaldo','6e25da606bab2c8e5908ef6b69b3c458','etevaldojales@gmail.com','Etevaldo Jales','(85) 3294-2735','20140219_tigre.jpg',1,1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;


--
-- Definition of table `usuarios_secoes`
--

DROP TABLE IF EXISTS `usuarios_secoes`;
CREATE TABLE `usuarios_secoes` (
  `id_usuario_secoes` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT '0',
  `id_secoes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario_secoes`)
) ENGINE=MyISAM AUTO_INCREMENT=386 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios_secoes`
--

/*!40000 ALTER TABLE `usuarios_secoes` DISABLE KEYS */;
INSERT INTO `usuarios_secoes` (`id_usuario_secoes`,`id_usuario`,`id_secoes`) VALUES 
 (238,1,1),
 (237,1,6),
 (236,1,5),
 (235,1,8),
 (234,1,8),
 (233,1,8),
 (232,1,3),
 (384,2,5),
 (383,2,5),
 (382,2,5),
 (381,2,5),
 (380,2,8),
 (379,2,8),
 (311,75,5),
 (231,1,3),
 (378,2,8),
 (230,1,2),
 (377,2,8),
 (19,0,7),
 (20,0,7),
 (310,75,5),
 (22,0,4),
 (23,0,2),
 (24,0,3),
 (25,0,3),
 (26,0,8),
 (27,0,8),
 (28,0,8),
 (29,0,5),
 (30,0,1),
 (31,0,7),
 (32,0,7),
 (33,0,7),
 (309,75,8),
 (35,0,4),
 (36,0,2),
 (37,0,3),
 (38,0,3),
 (39,0,8),
 (40,0,8),
 (41,0,8),
 (42,0,5),
 (43,0,1),
 (229,1,4),
 (308,75,8),
 (227,1,7),
 (226,1,7),
 (376,2,3),
 (375,2,3),
 (374,2,4),
 (373,2,2),
 (307,75,8),
 (306,75,3),
 (305,75,3),
 (304,75,4),
 (303,75,2),
 (302,75,7),
 (301,75,7),
 (372,2,7),
 (371,2,7),
 (312,75,5),
 (313,75,5),
 (314,75,1),
 (385,2,1),
 (370,76,5),
 (369,76,8),
 (368,76,8),
 (367,76,8),
 (366,76,3),
 (365,76,3),
 (364,76,4),
 (363,76,2),
 (362,76,7);
/*!40000 ALTER TABLE `usuarios_secoes` ENABLE KEYS */;


--
-- Definition of table `usuarios_subsecoes`
--

DROP TABLE IF EXISTS `usuarios_subsecoes`;
CREATE TABLE `usuarios_subsecoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(8) NOT NULL,
  `id_secao` int(5) NOT NULL,
  `id_subsecao` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1523 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios_subsecoes`
--

/*!40000 ALTER TABLE `usuarios_subsecoes` DISABLE KEYS */;
INSERT INTO `usuarios_subsecoes` (`id`,`id_usuario`,`id_secao`,`id_subsecao`) VALUES 
 (1375,1,1,0),
 (1374,1,6,0),
 (1373,1,5,0),
 (1372,1,8,5),
 (1371,1,8,4),
 (1448,75,5,9),
 (1521,2,5,11),
 (1520,2,5,10),
 (1370,1,8,3),
 (1369,1,3,2),
 (1157,0,7,6),
 (1158,0,7,7),
 (1447,75,5,8),
 (1160,0,4,0),
 (1161,0,2,0),
 (1162,0,3,1),
 (1163,0,3,2),
 (1164,0,8,3),
 (1165,0,8,4),
 (1166,0,8,5),
 (1167,0,5,0),
 (1168,0,1,0),
 (1169,0,7,6),
 (1170,0,7,7),
 (1446,75,8,5),
 (1172,0,4,0),
 (1173,0,2,0),
 (1174,0,3,1),
 (1175,0,3,2),
 (1176,0,8,3),
 (1177,0,8,4),
 (1178,0,8,5),
 (1179,0,5,0),
 (1180,0,1,0),
 (1368,1,3,1),
 (1367,1,2,0),
 (1366,1,4,0),
 (1445,75,8,4),
 (1364,1,7,7),
 (1363,1,7,6),
 (1519,2,5,9),
 (1518,2,5,8),
 (1517,2,8,12),
 (1516,2,8,5),
 (1515,2,8,4),
 (1514,2,8,3),
 (1513,2,3,2),
 (1512,2,3,1),
 (1511,2,4,0),
 (1510,2,2,0),
 (1444,75,8,3),
 (1443,75,3,2),
 (1442,75,3,1),
 (1441,75,4,0),
 (1440,75,2,0),
 (1439,75,7,7),
 (1438,75,7,6),
 (1509,2,7,7),
 (1508,2,7,6),
 (1449,75,5,10),
 (1450,75,5,11),
 (1451,75,1,0),
 (1522,2,1,0),
 (1507,76,5,10),
 (1506,76,8,5),
 (1505,76,8,4),
 (1504,76,8,3),
 (1503,76,3,2),
 (1502,76,3,1),
 (1501,76,4,0),
 (1500,76,2,0),
 (1499,76,7,7);
/*!40000 ALTER TABLE `usuarios_subsecoes` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
