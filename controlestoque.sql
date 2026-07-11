set foreign_key_checks=0;


#
# Criação da Tabela : logs
#

CREATE TABLE `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `ip` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `mensagem` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hora` (`data`)
) ENGINE=MyISAM AUTO_INCREMENT=163 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO logs VALUES ('1', '2015-08-29', '13:35:00', '127.0.0.1', 'Etevaldo Jales -  EXCLUIU O USUARIO Analia Jales')
,('2', '2015-09-01', '00:39:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU A MARCA: MR2')
,('3', '2015-09-01', '00:39:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU O FORNECEDOR: R2 DISTRIBUIDORA')
,('4', '2015-09-01', '00:40:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: MASCULINA')
,('5', '2015-09-01', '00:41:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: Cal?a Jeans, QUANTIDADE: 20')
,('6', '2015-09-01', '00:42:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: Bermuda Jeans, QUANTIDADE: 25')
,('7', '2015-09-01', '00:42:00', '127.0.0.1', 'Etevaldo Jales -  ALTEROU O PRODUTO DE: Cal�a Jeans PARA Cal?a Jeans')
,('8', '2015-09-01', '01:30:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU O CLIENTE: Etevaldo Jales, ENDERE?O: Rua Humberto Lomeu 3159, TELEFONE: (85) 9894-9774, EMAIL: etevaldojales@gmail.com')
,('9', '2015-09-01', '01:31:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU O CLIENTE: Maria An?lia, ENDERE?O: Rua Humberto Lomeu, 3159, TELEFONE: (85) 3294-2735, EMAIL: larissa_dos_santos_luz@hotmail.com')
,('10', '2015-09-04', '23:44:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 2| CLIENTE: Maria An�lia| DATA DO PEDIDO: 04/09/2015| VALOR DO PEDIDO: 1.800,00| PRODUTOS: C345(10), B789(15), ')
,('11', '2015-09-04', '23:47:00', '127.0.0.1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 04/10/2015, NO VALOR DE: 450,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Maria An�lia')
,('12', '2015-09-04', '23:55:00', '127.0.0.1', 'Etevaldo Jales -  EXCLUIU O USUARIO Jorge Lins')
,('13', '2015-09-05', '00:26:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU SA�DA NO ESTOQUE O PRODUTO: C345, QUANTIDADE: 5')
,('14', '2015-09-12', '22:54:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: teste')
,('15', '2015-09-12', '22:54:00', '127.0.0.1', 'Etevaldo Jales -  ALTEROU A CATEGORIA DE: teste PARA testerfewrwe')
,('16', '2015-09-12', '22:54:00', '127.0.0.1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: testerfewrwe')
,('17', '2015-09-12', '22:58:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 3| CLIENTE: Maria An�lia| DATA DO PEDIDO: 12/09/2015| VALOR DO PEDIDO: 245,00| PRODUTOS: C345(3), B789(1), ')
,('18', '2015-09-12', '23:00:00', '127.0.0.1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 10/10/2015, NO VALOR DE: 122,50, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Maria An�lia')
,('19', '2015-09-12', '23:03:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: C345, QUANTIDADE: 50')
,('20', '2015-09-22', '00:47:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 4| CLIENTE: Maria An�lia| DATA DO PEDIDO: 22/09/2015| VALOR DO PEDIDO: 1.068,60| PRODUTOS: C345(6), B789(8), ')
,('21', '2015-09-22', '00:49:00', '127.0.0.1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 21/10/2015, NO VALOR DE: 356,20, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Maria An�lia')
,('22', '2015-10-10', '13:58:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: Teste')
,('23', '2015-10-10', '13:58:00', '127.0.0.1', 'Etevaldo Jales -  ALTEROU A CATEGORIA DE: Teste PARA Testefgfdgdg')
,('24', '2015-10-10', '13:58:00', '127.0.0.1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: Testefgfdgdg')
,('25', '2015-10-10', '14:00:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: Perfume, QUANTIDADE: 30')
,('26', '2015-10-10', '14:03:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 5| CLIENTE: Maria An�lia| DATA DO PEDIDO: 10/10/2015| VALOR DO PEDIDO: 904,80| PRODUTOS: P-45(10), B789(1), ')
,('27', '2015-10-10', '14:04:00', '127.0.0.1', 'Etevaldo Jales -  RECEBEU ENTRADA NO VALOR DE: 100,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: ')
,('28', '2015-10-10', '14:04:00', '127.0.0.1', 'Etevaldo Jales -  RECEBEU ENTRADA NO VALOR DE: 100,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: ')
,('29', '2015-10-10', '14:10:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: B789, QUANTIDADE: 60')
,('30', '2015-10-21', '23:09:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU SA�DA NO ESTOQUE O PRODUTO: P-45, QUANTIDADE: 20')
,('31', '2015-10-21', '23:12:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: P-45, QUANTIDADE: 20')
,('32', '2015-10-24', '14:30:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 6| CLIENTE: Maria An�lia| DATA DO PEDIDO: 24/10/2015| VALOR DO PEDIDO: 461,80| PRODUTOS: C345(5), P-45(2), ')
,('33', '2015-11-13', '22:44:00', '127.0.0.1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 1| CLIENTE: Etevaldo Jales| DATA DO PEDIDO: 13/11/2015| VALOR DO PEDIDO: 925,00| PRODUTOS: C345(10), B789(5), ')
,('34', '2015-11-13', '22:47:00', '127.0.0.1', 'Etevaldo Jales -  RECEBEU ENTRADA NO VALOR DE: 150,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: ')
,('35', '2015-11-13', '22:47:00', '127.0.0.1', 'Etevaldo Jales -  RECEBEU ENTRADA NO VALOR DE: 150,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: ')
,('36', '2017-01-29', '13:37:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: Malbeck, QUANTIDADE: 10')
,('37', '2017-01-29', '13:41:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 8| CLIENTE: Etevaldo Jales| DATA DO PEDIDO: 29/01/2017| VALOR DO PEDIDO: 148,40| PRODUTOS: C345(1), P-45(1), ')
,('38', '2017-01-29', '13:41:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 8| CLIENTE: Etevaldo Jales| DATA DO PEDIDO: 29/01/2017| VALOR DO PEDIDO: 148,40| PRODUTOS: C345(1), P-45(1), ')
,('39', '2017-01-29', '13:41:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 8| CLIENTE: Etevaldo Jales| DATA DO PEDIDO: 29/01/2017| VALOR DO PEDIDO: 148,40| PRODUTOS: C345(1), P-45(1), ')
,('40', '2017-01-29', '13:41:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 8| CLIENTE: Etevaldo Jales| DATA DO PEDIDO: 29/01/2017| VALOR DO PEDIDO: 148,40| PRODUTOS: C345(1), P-45(1), ')
,('41', '2017-01-29', '13:48:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU SA�DA NO ESTOQUE O PRODUTO: 0009, QUANTIDADE: 6')
,('42', '2017-01-29', '13:48:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU SA�DA NO ESTOQUE O PRODUTO: 0009, QUANTIDADE: 6')
,('43', '2017-01-30', '00:33:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 7| CLIENTE: Maria An�lia| DATA DO PEDIDO: 30/01/2017| VALOR DO PEDIDO: 265,20| PRODUTOS: P-45(3), ')
,('44', '2017-01-30', '00:45:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 7| CLIENTE: Maria An�lia| DATA DO PEDIDO: 30/01/2017| VALOR DO PEDIDO: 265,20| PRODUTOS: P-45(3), ')
,('45', '2017-01-30', '00:48:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: P-45, QUANTIDADE: 5')
,('46', '2017-01-30', '00:50:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU A CATEGORIA: FEMININA')
,('47', '2017-01-30', '00:51:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU A CATEGORIA: PERFUMARIA')
,('48', '2017-01-30', '00:51:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O FORNECEDOR: BOTICARIO')
,('49', '2017-01-30', '00:53:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU A MARCA: BOYICARIO')
,('50', '2017-01-30', '00:53:00', '131.255.157.70', 'Etevaldo Jales -  ALTEROU A MARCA DE: BOYICARIO PARA BOTICARIO')
,('51', '2017-01-30', '00:55:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: ZAAD, QUANTIDADE: 10')
,('52', '2017-01-30', '00:58:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O CLIENTE: ANGELA COSTA, ENDERE?O: RUA DAS ACACIAS, 356 - NATAL, TELEFONE: (87) 9999-9999, EMAIL: angela@gmail.com')
,('53', '2017-01-30', '00:59:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 9| CLIENTE: ANGELA COSTA| DATA DO PEDIDO: 30/01/2017| VALOR DO PEDIDO: 540,00| PRODUTOS: C345(3), 007(2), ')
,('54', '2017-01-30', '01:01:00', '131.255.157.70', 'Etevaldo Jales -  RECEBEU ENTRADA NO VALOR DE: 100,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: ')
,('55', '2017-01-30', '01:01:00', '131.255.157.70', 'Etevaldo Jales -  RECEBEU ENTRADA NO VALOR DE: 100,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: ')
,('56', '2017-01-30', '01:04:00', '131.255.157.70', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 15/03/2017, NO VALOR DE: 146,67, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: ANGELA COSTA')
,('57', '2017-01-30', '07:58:00', '187.125.107.34', 'Etevaldo Jales -  ALTEROU O CLIENTE: Maria An�lia. DADOS ANTERIORES: NOME: Maria An�lia, EMAIL: larissa_dos_santos_luz@hotmail.com, TELEFONE: (85) 3294-2735, ENDERE?O: Rua Humberto Lomeu, 3159 DADOS ATUAIS: NOME: Maria An?lia, EMAIL: analiajales@gmail.com, TELEFONE: (85) 3294-2735, ENDEREC?O: Rua Humberto Lomeu, 3159')
,('58', '2017-01-30', '08:02:00', '187.125.107.34', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: 007, QUANTIDADE: 20')
,('59', '2017-01-30', '08:05:00', '187.125.107.34', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 10| CLIENTE: Etevaldo Jales| DATA DO PEDIDO: 30/01/2017| VALOR DO PEDIDO: 519,00| PRODUTOS: 007(2), B789(3), ')
,('60', '2017-01-30', '09:25:00', '187.125.107.34', 'Etevaldo Jales -  CADASTROU SA�DA NO ESTOQUE O PRODUTO: 007, QUANTIDADE: 5')
,('61', '2017-01-30', '09:27:00', '187.125.107.34', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 11| CLIENTE: Etevaldo Jales| DATA DO PEDIDO: 30/01/2017| VALOR DO PEDIDO: 396,00| PRODUTOS: C345(4), 007(1), ')
,('62', '2017-01-30', '20:39:00', '131.255.157.70', 'Etevaldo Jales -  EXCLUIU O USUARIO Teste')
,('63', '2017-02-12', '08:27:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: 007, QUANTIDADE: 10')
,('64', '2017-02-14', '14:31:00', '187.125.107.34', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: 0009, QUANTIDADE: 10')
,('65', '2017-02-18', '15:09:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU A CATEGORIA: teste')
,('66', '2017-02-18', '15:09:00', '131.255.157.70', 'Etevaldo Jales -  ALTEROU A CATEGORIA DE: teste PARA testesdsadfdd')
,('67', '2017-02-18', '15:09:00', '131.255.157.70', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: testesdsadfdd')
,('68', '2017-02-18', '15:12:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: Polo, QUANTIDADE: 20')
,('69', '2017-02-18', '15:13:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: 106, QUANTIDADE: 10')
,('70', '2017-02-18', '15:15:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O CLIENTE: Didi, ENDERE?O: Rua Tal,54 - Natal, TELEFONE: (85) 9999-9999, EMAIL: didi@gmail.com')
,('71', '2017-02-18', '15:16:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 12| CLIENTE: Didi| DATA DO PEDIDO: 18/02/2017| VALOR DO PEDIDO: 1.320,00| PRODUTOS: 106(3), C345(2), ')
,('72', '2017-02-18', '15:17:00', '131.255.157.70', 'Etevaldo Jales -  RECEBEU ENTRADA NO VALOR DE: 200,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: ')
,('73', '2017-02-18', '15:17:00', '131.255.157.70', 'Etevaldo Jales -  RECEBEU ENTRADA NO VALOR DE: 200,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: ')
,('74', '2017-02-18', '15:20:00', '131.255.157.70', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 15/03/2017, NO VALOR DE: 280,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Didi')
,('75', '2017-02-18', '15:21:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU SA�DA NO ESTOQUE O PRODUTO: 106, QUANTIDADE: 23')
,('76', '2017-04-09', '10:44:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU SA�DA NO ESTOQUE O PRODUTO: P-45, QUANTIDADE: 10')
,('77', '2017-04-09', '11:08:00', '131.255.157.70', 'Etevaldo Jales -  EXCLUIU O USUARIO Didiail.com')
,('78', '2017-04-14', '18:12:00', '143.255.236.18', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 14| CLIENTE: Maria An�lia| DATA DO PEDIDO: 14/04/2017| VALOR DO PEDIDO: 905,00| PRODUTOS: C345(3), B789(5), 106(1), ')
,('79', '2017-05-07', '20:57:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: Blusa, QUANTIDADE: 10')
,('80', '2017-05-07', '20:59:00', '131.255.157.70', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 15| CLIENTE: Maria An�lia| DATA DO PEDIDO: 07/05/2017| VALOR DO PEDIDO: 178,50| PRODUTOS: C345(2), B23(1), ')
,('81', '2017-05-07', '21:02:00', '131.255.157.70', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 07/06/2017, NO VALOR DE: 59,50, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Maria An�lia')
,('82', '2017-07-19', '04:12:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: BIC')
,('83', '2017-07-20', '01:36:00', '::1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: Acess?rios')
,('84', '2017-07-20', '01:36:00', '::1', 'Etevaldo Jales -  ALTEROU A CATEGORIA DE: Acess�rios PARA ACESS?RIOS')
,('85', '2017-07-20', '01:47:00', '::1', 'Etevaldo Jales -  CADASTROU O FORNECEDOR: AVON')
,('86', '2017-07-22', '17:28:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 16| CLIENTE: Etevaldo Jales| DATA DO PEDIDO: 22/07/2017| VALOR DO PEDIDO: 217,00| PRODUTOS: 0009(1), ')
,('87', '2017-07-22', '17:30:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 22/07/2017, NO VALOR DE: 217,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Etevaldo Jales')
,('88', '2017-07-22', '17:41:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 18| CLIENTE: Maria An�lia| DATA DO PEDIDO: 22/07/2017| VALOR DO PEDIDO: 238,40| PRODUTOS: P-45(1), ')
,('89', '2017-07-22', '17:53:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 17| CLIENTE: Etevaldo Jales| DATA DO PEDIDO: 22/07/2017| VALOR DO PEDIDO: 325,00| PRODUTOS: B789(5), ')
,('90', '2017-07-22', '19:29:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 20| CLIENTE: Etevaldo Jales| DATA DO PEDIDO: 22/07/2017| VALOR DO PEDIDO: 180,00| PRODUTOS: C345(3), ')
,('91', '2017-07-22', '19:31:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 22/07/2017, NO VALOR DE: 200,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Etevaldo Jales')
,('92', '2017-07-22', '19:39:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 22/07/2017, NO VALOR DE: 200,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Etevaldo Jales')
,('93', '2017-07-22', '19:51:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 22/07/2017, NO VALOR DE: 250,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Etevaldo Jales')
,('94', '2017-07-22', '19:53:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 22/07/2017, NO VALOR DE: 200,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Etevaldo Jales')
,('95', '2017-07-22', '19:54:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 22/07/2017, NO VALOR DE: 180,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Etevaldo Jales')
,('96', '2017-07-22', '19:54:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 22/07/2017, NO VALOR DE: 180,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Etevaldo Jales')
,('97', '2017-07-22', '20:02:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 13| CLIENTE: ANGELA COSTA| DATA DO PEDIDO: 22/07/2017| VALOR DO PEDIDO: 180,00| PRODUTOS: C345(3), ')
,('98', '2017-07-22', '20:02:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 22/07/2017, NO VALOR DE: 210,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: ANGELA COSTA')
,('99', '2017-07-22', '20:41:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 22/07/2017, NO VALOR DE: 250,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Etevaldo Jales')
,('100', '2017-07-22', '20:41:00', '::1', 'Etevaldo Jales -  DEU BAIXA NA PARCELA DE VENCIMENTO: 22/07/2017, NO VALOR DE: 180,00, FORMA DE PAGAMENTO: Dinheiro, CLIENTE: Etevaldo Jales')
,('101', '2017-08-12', '20:07:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: Teste')
,('102', '2017-08-12', '20:16:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: teste2')
,('103', '2017-08-12', '20:18:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: teste3')
,('104', '2017-08-12', '20:19:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: cggdgdfgdf')
,('105', '2017-08-12', '20:23:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: zzzzzz')
,('106', '2017-08-12', '20:27:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: nnnnnnn')
,('107', '2017-08-12', '20:30:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA cggdgdfgdf')
,('108', '2017-08-12', '20:30:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA nnnnnnn')
,('109', '2017-08-12', '20:30:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA Teste')
,('110', '2017-08-12', '20:30:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA teste2')
,('111', '2017-08-12', '20:30:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA teste3')
,('112', '2017-08-12', '20:30:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA zzzzzz')
,('113', '2017-08-12', '20:30:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: Teste')
,('114', '2017-08-12', '20:33:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: Teste2')
,('115', '2017-08-12', '20:33:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: Teste3')
,('116', '2017-08-12', '20:38:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA Teste')
,('117', '2017-08-12', '20:38:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA Teste2')
,('118', '2017-08-12', '20:39:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA Teste3')
,('119', '2017-08-12', '20:39:00', '::1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: teste')
,('120', '2017-08-12', '20:40:00', '::1', 'Etevaldo Jales -  CADASTROU O FORNECEDOR: Teste')
,('121', '2017-08-12', '20:40:00', '::1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: teste2')
,('122', '2017-08-12', '20:41:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: teste')
,('123', '2017-08-12', '20:41:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: teste3')
,('124', '2017-08-12', '20:41:00', '::1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: teste3')
,('125', '2017-08-12', '20:43:00', '::1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: teste')
,('126', '2017-08-12', '20:43:00', '::1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: teste2')
,('127', '2017-08-12', '20:43:00', '::1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: teste3')
,('128', '2017-08-12', '20:43:00', '::1', 'Etevaldo Jales -  EXCLUIU O FORNECEDOR Teste')
,('129', '2017-08-12', '20:44:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA teste')
,('130', '2017-08-12', '20:44:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA teste3')
,('131', '2017-08-12', '20:44:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: Teste')
,('132', '2017-08-12', '20:45:00', '::1', 'Etevaldo Jales -  CADASTROU A MARCA: Teste2')
,('133', '2017-08-12', '20:45:00', '::1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: Teste')
,('134', '2017-08-12', '20:49:00', '::1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: Teste2')
,('135', '2017-08-12', '20:51:00', '::1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: Teste3')
,('136', '2017-08-12', '20:52:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA Teste')
,('137', '2017-08-12', '20:52:00', '::1', 'Etevaldo Jales -  EXCLUIU A MARCA Teste2')
,('138', '2017-08-12', '20:52:00', '::1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: Teste')
,('139', '2017-08-12', '20:52:00', '::1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: Teste2')
,('140', '2017-08-12', '20:52:00', '::1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: Teste3')
,('141', '2017-08-12', '20:57:00', '::1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: tteste')
,('142', '2017-08-12', '20:58:00', '::1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: teste2')
,('143', '2017-08-12', '20:59:00', '::1', 'Etevaldo Jales -  CADASTROU A CATEGORIA: teste3')
,('144', '2017-08-12', '20:59:00', '::1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: teste2')
,('145', '2017-08-12', '20:59:00', '::1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: teste3')
,('146', '2017-08-12', '20:59:00', '::1', 'Etevaldo Jales -  EXCLUIU A CATEGORIA: tteste')
,('147', '2017-08-12', '21:03:00', '::1', 'Etevaldo Jales -  CADASTROU O FORNECEDOR: Teste')
,('148', '2018-03-17', '16:47:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 21| CLIENTE: Etevaldo Jales| DATA DO PEDIDO: 17/03/2018| VALOR DO PEDIDO: 60,00| PRODUTOS: C345(1), ')
,('149', '2021-03-20', '16:45:00', '::1', 'Etevaldo Jales -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: C345, QUANTIDADE: 10')
,('150', '2021-03-20', '18:19:00', '::1', 'Etevaldo Jales -  CADASTROU SA�DA NO ESTOQUE O PRODUTO: B23, QUANTIDADE: 6')
,('151', '2021-03-20', '18:20:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 19| CLIENTE: Maria An�lia| DATA DO PEDIDO: 20/03/2021| VALOR DO PEDIDO: 425,75| PRODUTOS: B789(3), B23(4), ')
,('152', '2021-03-20', '18:21:00', '::1', 'Etevaldo Jales -  CADASTROU O PEDIDO NUMERO: 19| CLIENTE: Maria An�lia| DATA DO PEDIDO: 20/03/2021| VALOR DO PEDIDO: 425,75| PRODUTOS: B789(3), B23(4), ')
,('153', '2021-03-20', '18:36:00', '::1', 'Etevaldo Jales -  EXCLUIU O USUARIO Cicero')
,('154', '2021-03-20', '18:40:00', '::1', 'Carina -  ALTEROU O PRODUTO DE: Cal�a Jeans PARA Cal?a Jeans')
,('155', '2021-03-20', '18:48:00', '::1', 'Carina -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: C345, QUANTIDADE: 20')
,('156', '2021-03-20', '18:50:00', '::1', 'Carina -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: C345, QUANTIDADE: 20')
,('157', '2021-03-20', '18:55:00', '::1', '')
,('158', '2021-03-20', '18:58:00', '::1', '')
,('159', '2021-03-20', '19:01:00', '::1', 'Carina -  CADASTROU ENTRADA NO ESTOQUE O PRODUTO: C345, QUANTIDADE: 20')
,('160', '2021-03-20', '19:02:00', '::1', 'Carina -  CADASTROU O PEDIDO NUMERO: 1| CLIENTE: Maria An�lia| DATA DO PEDIDO: 20/03/2021| VALOR DO PEDIDO: 60,00| PRODUTOS: C345(1), ')
,('161', '2021-03-20', '19:14:00', '::1', 'Carina -  ALTEROU O PRODUTO DE: Cal�a Jeans PARA Cal?a Jeans')
,('162', '2021-03-20', '19:52:00', '::1', 'Carina -  ALTEROU O CLIENTE: Etevaldo Jales. DADOS ANTERIORES: NOME: Etevaldo Jales, EMAIL: etevaldojales@gmail.com, TELEFONE: (85) 9894-9774, ENDERE?O: Rua Humberto Lomeu 3159 DADOS ATUAIS: NOME: Etevaldo Jales, EMAIL: etevaldojales@gmail.com, TELEFONE: (85) 98549-3742, ENDEREC?O: Rua Humberto Lomeu 3159')
;

#
# Criação da Tabela : produto_fornecedor
#

CREATE TABLE `produto_fornecedor` (
  `id_produto` int(10) unsigned NOT NULL,
  `id_fornecedor` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_produto`,`id_fornecedor`),
  KEY `tblproduto_has_tblfornecedor_FKIndex1` (`id_produto`),
  KEY `tblproduto_has_tblfornecedor_FKIndex2` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

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
  `posicao` int(11) NOT NULL DEFAULT '0',
  `icone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO secoes VALUES ('1', 'Usu�rios', 'usuario.php', '7', 'icon-cog')
,('3', 'Clientes', '', '4', 'icon-user')
,('2', 'Cadastrar Produtos', 'produtos_cadastrar.php', '2', 'icon-gift')
,('4', 'Pedidos', '', '3', 'icon-shopping-cart')
,('5', 'Relat�rios', '', '6', 'icon-pencil')
,('7', 'Estoque', '', '1', 'icon-th-large')
,('8', 'Cadastros', '', '5', 'icon-cogs')
,('9', 'Auditoria', 'logs.php', '8', 'icon-comment')
;

#
# Criação da Tabela : subsecoes
#

CREATE TABLE `subsecoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_secao` varchar(11) NOT NULL,
  `subsecao` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 ;

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
,('12', '4', 'Produtos', 'index.php')
;

#
# Criação da Tabela : tblbancos
#

CREATE TABLE `tblbancos` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `funcao` varchar(60) DEFAULT NULL,
  `layout` varchar(60) DEFAULT NULL,
  `stselecionado` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 ;

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
,('16', '', '', '0')
;

#
# Criação da Tabela : tblcategoria
#

CREATE TABLE `tblcategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO tblcategoria VALUES ('1', 'MASCULINA')
,('2', 'FEMININA')
,('3', 'PERFUMARIA')
,('4', 'ACESS�RIOS')
;

#
# Criação da Tabela : tblcliente
#

CREATE TABLE `tblcliente` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `stativo` smallint(1) NOT NULL DEFAULT '0' COMMENT '0: Inativo; 1: Ativo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO tblcliente VALUES ('1', 'Etevaldo Jales', '(85) 98549-3742', 'etevaldojales@gmail.com', 'Rua Humberto Lomeu 3159', '1')
,('2', 'Maria An�lia', '(85) 3294-2735', 'analiajales@gmail.com', 'Rua Humberto Lomeu, 3159', '1')
,('3', 'ANGELA COSTA', '(87) 9999-9999', 'angela@gmail.com', 'RUA DAS ACACIAS, 356 - NATAL', '1')
;

#
# Criação da Tabela : tblcredito
#

CREATE TABLE `tblcredito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `valor` float NOT NULL DEFAULT '0',
  `saldo` float NOT NULL DEFAULT '0',
  `data` date NOT NULL,
  `stcredito` smallint(1) DEFAULT '0' COMMENT '1: Credito; 2: Debito',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : tblempresa
#

CREATE TABLE `tblempresa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

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
  `estoque_minimo` int(6) DEFAULT '0',
  `qtdacumulado` int(10) unsigned DEFAULT NULL,
  `data` date DEFAULT NULL,
  `cor` varchar(50) NOT NULL,
  `tamanho` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tblestoque_FKIndex1` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO tblformapagamento VALUES ('1', 'Boleto')
,('2', 'Cart�o de cr�dito')
,('3', 'Cheque')
,('4', 'Dinheiro')
,('5', 'PagSeguro')
,('6', 'Cart�o (D�bito)')
;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO tblfornecedor VALUES ('1', 'R2 DISTRIBUIDORA', '', '', '')
,('2', 'BOTICARIO', '', '', '')
,('3', 'AVON', '', '', '')
,('5', 'Teste', '(85) 98949-7715', 'Rua Tal', 'teste@gmail.com')
;

#
# Criação da Tabela : tblitenspedido
#

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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO tblitenspedido VALUES ('1', '1', '2', '10', '45', '75', '750')
,('2', '2', '2', '15', '50', '70', '1050')
,('3', '1', '3', '3', '45', '60', '180')
,('4', '2', '3', '1', '50', '65', '65')
,('13', '1', '4', '6', '45', '71.5', '429')
,('14', '2', '4', '8', '50', '79.95', '639.6')
,('15', '3', '5', '10', '68', '83.98', '839.8')
,('16', '2', '5', '1', '50', '65', '65')
,('18', '1', '6', '5', '45', '57', '285')
,('19', '3', '6', '2', '68', '88.4', '176.8')
,('22', '1', '8', '1', '45', '60', '60')
,('23', '3', '8', '1', '68', '88.4', '88.4')
,('24', '3', '7', '3', '68', '88.4', '265.2')
,('25', '1', '9', '3', '45', '60', '180')
,('26', '5', '9', '2', '129.99', '180', '360')
,('27', '5', '10', '2', '129.99', '162', '324')
,('28', '2', '10', '3', '50', '65', '195')
,('29', '1', '11', '4', '45', '54', '216')
,('30', '5', '11', '1', '129.99', '180', '180')
,('31', '6', '12', '3', '250', '400', '1200')
,('32', '1', '12', '2', '45', '60', '120')
,('33', '1', '14', '3', '45', '60', '180')
,('34', '2', '14', '5', '50', '65', '325')
,('35', '6', '14', '1', '250', '400', '400')
,('36', '1', '15', '2', '45', '60', '120')
,('37', '7', '15', '1', '50', '58.5', '58.5')
,('50', '4', '16', '1', '90', '117', '117')
,('51', '3', '18', '1', '68', '88.4', '88.4')
,('52', '2', '17', '5', '50', '65', '325')
,('53', '1', '20', '3', '45', '60', '180')
,('55', '1', '13', '3', '45', '60', '180')
,('56', '1', '21', '1', '45', '60', '60')
,('57', '2', '19', '3', '50', '55.25', '165.75')
,('59', '7', '19', '4', '50', '65', '260')
,('60', '1', '23', '1', '45', '60', '60')
;

#
# Criação da Tabela : tblmarca
#

CREATE TABLE `tblmarca` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO tblmarca VALUES ('1', 'MR2')
,('2', 'BOTICARIO')
,('3', 'BIC')
;

#
# Criação da Tabela : tblparcela
#

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
  `stEstorno` smallint(1) DEFAULT '0' COMMENT '0: N�o Estornado; 1: Estornado ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nosso_numero` (`nosso_numero`),
  KEY `tblparcela_FKIndex1` (`id_pedido`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#


#
# Criação da Tabela : tblpedido
#

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO tblpedido VALUES ('1', '2', '1', '2021-03-20', '', '0', '0', '0', '0', '0', '1', '')
;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO tblproduto VALUES ('1', '1', '1', '1', 'Cal�a Jeans', '45', '60', 'C345', '2015-09-01', '2021/03/20')
,('2', '1', '1', '1', 'Bermuda Jeans', '50', '65', 'B789', '2015-09-01', '02')
,('3', '1', '1', '1', 'Perfume', '68', '88.4', 'P-45', '2015-10-10', '06')
,('4', '1', '1', '1', 'Malbeck', '90', '117', '0009', '2017-01-29', 'P1')
,('5', '3', '2', '2', 'ZAAD', '129.99', '180', '007', '2017-01-30', '1B')
,('6', '3', '2', '2', 'Polo', '250', '400', '106', '2017-02-18', 'P5')
,('7', '2', '1', '1', 'Blusa', '50', '65', 'B23', '2017-05-07', 'P1')
;

#
# Criação da Tabela : tblservico
#

CREATE TABLE `tblservico` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pedido` int(10) DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO tblservico VALUES ('3', '16', 'Encaderna��o', '100')
,('4', '18', 'Estamparia', '150')
;

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
  `ativo` smallint(1) DEFAULT '0',
  `tipo_usuario` smallint(1) DEFAULT '0',
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO usuarios VALUES ('1', 'etevaldo', '6e25da606bab2c8e5908ef6b69b3c458', 'etevasldojales@gmail.com', 'Etevaldo Jales', '(85) 3294-2735', '', '1', '1')
,('9', 'carina', 'e68b262dfb5013ae634b182f5d390db8', 'lojacarina@gmail.com', 'Carina', '(85) 9999-9999', '', '1', '1')
;

#
# Criação da Tabela : usuarios_secoes
#

CREATE TABLE `usuarios_secoes` (
  `id_usuario_secoes` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT '0',
  `id_secoes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario_secoes`)
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO usuarios_secoes VALUES ('144', '1', '9')
,('143', '1', '1')
,('142', '1', '5')
,('141', '1', '5')
,('140', '1', '5')
,('139', '1', '5')
,('138', '1', '8')
,('137', '1', '8')
,('136', '1', '8')
,('135', '1', '3')
,('134', '1', '3')
,('133', '1', '4')
,('132', '1', '4')
,('131', '1', '2')
,('130', '1', '7')
,('129', '1', '7')
,('64', '5', '9')
,('63', '5', '1')
,('62', '5', '5')
,('61', '5', '5')
,('60', '5', '5')
,('59', '5', '5')
,('58', '5', '8')
,('57', '5', '8')
,('56', '5', '8')
,('55', '5', '8')
,('54', '5', '3')
,('53', '5', '3')
,('52', '5', '4')
,('51', '5', '2')
,('50', '5', '7')
,('49', '5', '7')
,('88', '6', '8')
,('87', '6', '8')
,('86', '6', '8')
,('85', '6', '3')
,('84', '6', '3')
,('83', '6', '4')
,('82', '6', '2')
,('81', '6', '7')
,('80', '6', '7')
,('118', '8', '3')
,('117', '8', '3')
,('116', '8', '4')
,('115', '8', '2')
,('114', '8', '7')
,('113', '8', '7')
,('112', '7', '8')
,('111', '7', '8')
,('110', '7', '8')
,('109', '7', '3')
,('108', '7', '3')
,('107', '7', '4')
,('106', '7', '2')
,('105', '7', '7')
,('104', '7', '7')
,('119', '8', '8')
,('120', '8', '8')
,('121', '8', '8')
,('122', '8', '8')
,('123', '8', '5')
,('124', '8', '5')
,('125', '8', '5')
,('126', '8', '5')
,('127', '8', '1')
,('128', '8', '9')
,('145', '9', '7')
,('146', '9', '7')
,('147', '9', '2')
,('148', '9', '4')
,('149', '9', '4')
,('150', '9', '3')
,('151', '9', '3')
,('152', '9', '8')
,('153', '9', '8')
,('154', '9', '8')
,('155', '9', '5')
,('156', '9', '5')
,('157', '9', '5')
,('158', '9', '5')
,('159', '9', '1')
,('160', '9', '9')
;

#
# Criação da Tabela : usuarios_subsecoes
#

CREATE TABLE `usuarios_subsecoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(8) NOT NULL,
  `id_secao` int(5) NOT NULL,
  `id_subsecao` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=latin1 ;

#
# Dados a serem incluídos na tabela
#

INSERT INTO usuarios_subsecoes VALUES ('143', '1', '9', '0')
,('142', '1', '1', '0')
,('141', '1', '5', '11')
,('140', '1', '5', '10')
,('139', '1', '5', '9')
,('138', '1', '5', '8')
,('137', '1', '8', '5')
,('136', '1', '8', '4')
,('135', '1', '8', '3')
,('134', '1', '3', '2')
,('133', '1', '3', '1')
,('131', '1', '4', '12')
,('130', '1', '2', '0')
,('129', '1', '7', '7')
,('128', '1', '7', '6')
,('63', '5', '9', '0')
,('62', '5', '1', '0')
,('61', '5', '5', '11')
,('60', '5', '5', '10')
,('59', '5', '5', '9')
,('58', '5', '5', '8')
,('57', '5', '8', '12')
,('56', '5', '8', '5')
,('55', '5', '8', '4')
,('54', '5', '8', '3')
,('53', '5', '3', '2')
,('52', '5', '3', '1')
,('51', '5', '4', '0')
,('50', '5', '2', '0')
,('49', '5', '7', '7')
,('48', '5', '7', '6')
,('87', '6', '8', '5')
,('86', '6', '8', '4')
,('85', '6', '8', '3')
,('84', '6', '3', '2')
,('83', '6', '3', '1')
,('82', '6', '4', '0')
,('81', '6', '2', '0')
,('80', '6', '7', '7')
,('79', '6', '7', '6')
,('117', '8', '3', '2')
,('116', '8', '3', '1')
,('115', '8', '4', '0')
,('114', '8', '2', '0')
,('113', '8', '7', '7')
,('112', '8', '7', '6')
,('111', '7', '8', '5')
,('110', '7', '8', '4')
,('109', '7', '8', '3')
,('108', '7', '3', '2')
,('107', '7', '3', '1')
,('106', '7', '4', '0')
,('105', '7', '2', '0')
,('104', '7', '7', '7')
,('103', '7', '7', '6')
,('118', '8', '8', '3')
,('119', '8', '8', '4')
,('120', '8', '8', '5')
,('121', '8', '8', '12')
,('122', '8', '5', '8')
,('123', '8', '5', '9')
,('124', '8', '5', '10')
,('125', '8', '5', '11')
,('126', '8', '1', '0')
,('127', '8', '9', '0')
,('144', '9', '7', '6')
,('145', '9', '7', '7')
,('146', '9', '2', '0')
,('147', '9', '4', '12')
,('149', '9', '3', '1')
,('150', '9', '3', '2')
,('151', '9', '8', '3')
,('152', '9', '8', '4')
,('153', '9', '8', '5')
,('154', '9', '5', '8')
,('155', '9', '5', '9')
,('156', '9', '5', '10')
,('157', '9', '5', '11')
,('158', '9', '1', '0')
,('159', '9', '9', '0')
;
