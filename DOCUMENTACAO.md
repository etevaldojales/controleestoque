# Documentação do Sistema de Controle de Estoque (controleestoque)

Este documento descreve a arquitetura física e lógica, o modelo de dados, as regras de negócio, as tecnologias empregadas e a estrutura de diretórios do sistema de controle de estoque e PDV.

---

## 🛠️ 1. Arquitetura e Tecnologias

O sistema é construído como uma aplicação web monolítica baseada nas seguintes tecnologias:

*   **Linguagem de Backend:** PHP 8+ (configurado para execução em ambiente local como XAMPP).
*   **Banco de Dados:** MySQL/MariaDB (com suporte a charset UTF-8).
*   **Biblioteca de Banco de Dados:** **ADODB** (Active Data Objects para PHP) utilizando driver `mysqli` para abstração de queries e gerenciamento transacional.
*   **Interface Gráfica (Frontend):** HTML5, Javascript, jQuery (com chamadas assíncronas AJAX) e folha de estilo baseada no Bootstrap v2.
*   **Relatórios em PDF:** Biblioteca **FPDF** integrada para geração de recibos, relatórios financeiros e de estoque.
*   **Componentes JavaScript Especiais:**
    *   **Chosen jQuery Plugin:** Para dropdowns dinâmicos de marcas, categorias e fornecedores com busca em tempo real.
    *   **Toast System:** Sistema customizado de notificações flutuantes no topo da tela para feedback imediato das operações.
    *   **Custom Confirm Modals:** Modais de diálogo assíncronos substituindo os tradicionais `confirm()` do navegador.

---

## 🗄️ 2. Modelo de Dados (Banco de Dados)

O banco de dados do sistema, chamado `controlestoque`, armazena desde as tabelas cadastrais básicas até tabelas de transação de vendas, logs de auditoria e controle de permissões.

### 📋 Principais Tabelas

#### `usuarios`
Armazena os usuários autorizados a acessar o sistema.
*   `id_usuario` (INT, PK, AutoIncrement)
*   `nome` (VARCHAR)
*   `login` (VARCHAR)
*   `senha` (VARCHAR, MD5 Hash)
*   `email` (VARCHAR)
*   `telefone` (VARCHAR)
*   `foto` (VARCHAR, Caminho físico da imagem)
*   `ativo` (SMALLINT, 1 para Ativo, 0 para Inativo)
*   `tipo_usuario` (SMALLINT, 1: Administrador, 2: Operador)

#### `tblproduto`
Catálogo de produtos disponíveis no estoque.
*   `id` (INT, PK, AutoIncrement)
*   `nome` (VARCHAR)
*   `codigo` (VARCHAR, Referência/Código de Barras único)
*   `id_categoria` (INT, FK)
*   `id_marca` (INT, FK)
*   `id_fornecedor` (INT, FK)
*   `valor_compra` (FLOAT)
*   `valor` (FLOAT, Valor de venda)
*   `unidade` (SMALLINT, 1: Unidade, 2: Peso/Fração)
*   `local_estoque` (VARCHAR, Corredor/Gaveta)
*   `data_cadastro` (DATE)
*   `stativo` (SMALLINT, 1: Ativo, 0: Inativo)

#### `tblestoque`
Mural de entradas e saídas de estoque de cada produto.
*   `id` (INT, PK, AutoIncrement)
*   `id_produto` (INT, FK)
*   `qtdentrada` (INT, Quantidade adicionada)
*   `qtdsaida` (INT, Quantidade vendida/removida)
*   `qtdacumulado` (INT, Saldo atual no estoque)
*   `estoque_minimo` (INT, Limite de aviso de reposição)
*   `num_nf` (INT, Nota Fiscal de compra)
*   `data` (DATE)
*   `stativo` (SMALLINT)

#### `tblpedido`
Guarda os cabeçalhos de pedidos (vendas) gerados.
*   `id` (INT, PK, AutoIncrement)
*   `id_cliente` (INT, FK)
*   `id_usuario` (INT, FK, Usuário do caixa)
*   `numero_pedido` (INT, Número único sequencial)
*   `data_pedido` (DATE)
*   `primeiro_venc` (DATE)
*   `num_parc` (INT, Quantidade de parcelas geradas)
*   `id_formapag` (INT, Forma de pagamento padrão)
*   `valor_custo` (FLOAT, Total de custo)
*   `valor_venda` (FLOAT, Total bruto da venda)
*   `valor` (FLOAT, Valor líquido)
*   `status_pedido` (SMALLINT, 1: Em aberto, 2: Concluído, 3: Cancelado)
*   `observacao` (TEXT)

#### `tblparcela`
Controle financeiro das vendas parceladas ou à vista.
*   `id` (INT, PK, AutoIncrement)
*   `id_pedido` (INT, FK)
*   `id_usuario` (INT, FK)
*   `id_forma_pag` (INT, FK)
*   `valor_parcela` (FLOAT)
*   `vencimento` (DATE)
*   `valor_pag` (FLOAT, Valor pago pelo cliente)
*   `data_pgto` (DATE)
*   `flgstatus` (SMALLINT, 1: Pendente, 2: Pago)
*   `stEstorno` (SMALLINT, 1: Estornado, 0: Não Estornado)

#### `logs`
Tabela de auditoria para todas as operações críticas do sistema.
*   `id` (INT, PK, AutoIncrement)
*   `data` (DATE)
*   `hora` (TIME)
*   `ip` (VARCHAR)
*   `mensagem` (TEXT, Detalhamento da ação e usuário responsável)

---

## 🔑 3. Mecanismos de Segurança

1.  **Proteção contra Cross-Site Request Forgery (CSRF):**
    *   Implementado no arquivo [class.utilidades.php](file:///c:/xampp/htdocs/controleestoque/lib/classes/class.utilidades.php), o sistema gera tokens únicos salvos em sessão por meio do método `get_csrf_token()`.
    *   Formulários utilizam `get_csrf_token_html()` para renderizar campos `<input type="hidden">` contendo o token.
    *   Processos de inserção e exclusão validam o token utilizando `valida_csrf_token()` antes de prosseguir com qualquer query.
2.  **Parâmetros de Sessão Seguros:**
    *   Configuração restrita de cookies de sessão (`cookie_lifetime`, `cookie_path` apontando apenas para `/controleestoque/`, `HttpOnly` ativado, `SameSite=Lax` e nomenclatura única `CONTROLEESTOQUE_SESS`) implementada globalmente em [config.php](file:///c:/xampp/htdocs/controleestoque/lib/classes/config.php).
3.  **Sanitização de Consultas:**
    *   O backend utiliza queries parametrizadas (Prepared Statements) fornecidas pelo ADODB (`$db->Execute($sql, $params)`), prevenindo brechas de SQL Injection.
4.  **Autenticação e Permissões:**
    *   O acesso às telas e menus é controlado dinamicamente através do vínculo entre o usuário e as tabelas `usuarios_secoes` e `usuarios_subsecoes`. Se um usuário não possuir acesso a uma seção, ela não será exibida no menu lateral.

---

## 🔄 4. Principais Fluxos de Negócio

### Fluxo de Venda e Baixa de Estoque
1.  O operador de caixa acessa a tela de **PDV** ([pdv.php](file:///c:/xampp/htdocs/controleestoque/pdv.php)).
2.  Informa os itens da venda, que são adicionados dinamicamente em uma lista temporária por meio de requisições AJAX (`itens_pedido_pdv.php`).
3.  Ao concluir a venda, a forma de pagamento, a quantidade de parcelas e o cliente são definidos.
4.  O sistema executa uma transação bancária no MySQL:
    *   Cria o registro em `tblpedido`.
    *   Move os itens temporários para `tblitenspedido`.
    *   Gera as contas a receber na tabela `tblparcela` de acordo com o número de parcelas.
    *   Insere registros de saída de produto na tabela `tblestoque`, recalculando o saldo (`qtdacumulado`).

### Fluxo de Auditoria (Logs)
Qualquer operação de inclusão, alteração ou exclusão realizada no banco de dados dispara o registro de logs na tabela de auditoria através da classe `logs`:
```php
$_logs = new logs($dbase);
$mensagem = $_SESSION["nome_usuario"] . " - EXCLUIU O PRODUTO " . $dados['nome'];
$_logs->salvaLog($mensagem);
```

---

## 📁 5. Estrutura de Diretórios do Projeto

*   `/` (Diretório Raiz)
    *   `index.php` - Dashboard principal, exibindo atalhos rápidos e a lista de produtos com estoque crítico.
    *   `pdv.php` / `vendas.php` - Telas de Ponto de Venda e Venda direta.
    *   `clientes.php` / `usuario.php` - Telas cadastrais de clientes e usuários.
    *   `produtos_cadastrar.php` - Tela cadastral de produtos.
    *   `empresa.php` - Gerenciamento de dados da empresa e uploads de Logomarca/QR-Code.
    *   `config_inicio.php` - Bootstrap de inicialização que define caminhos e checa login.
    *   `bd.[nome].php` - Endpoints que processam requisições AJAX (CRUD).
*   `/js/`
    *   `produtos.js` / `cliente.js` / `usuario.js` - Controladores Javascript das telas de produtos, clientes e usuários.
    *   `venda.js` - Gerencia o comportamento dinâmico da tela de vendas e cálculo de parcelamentos.
*   `/lib/`
    *   `/adodb/` - Biblioteca ADODB para abstração de banco de dados.
    *   `/fpdf/` - Biblioteca FPDF para geração de documentos em formato PDF.
    *   `/classes/`
        *   `class.produto.php` - Métodos CRUD, estoque mínimo e relacionamentos do produto.
        *   `class.usuario.php` - Autenticação, listagens de permissões e CRUD de usuários.
        *   `class.bancos.php` - Configurações de layouts bancários de boleto.
        *   `class.utilidades.php` - Utilitários de strings, datas, e tratamento de tokens CSRF.
        *   `config.php` - Conexão ao banco de dados e parametrizações de sessão.
*   `/uploads/`
    *   Armazena arquivos temporários, logomarcas, QR-Codes da empresa e fotos dos produtos.
