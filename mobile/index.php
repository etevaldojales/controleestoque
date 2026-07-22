<?php
$lib = '../lib/';
require_once($lib . 'classes/config.php');
require_once($lib . 'classes/class.empresa.php');

$_class = new empresa($dbase);
$emp = $_class->get(1);
$nome_loja = (!empty($emp['nome'])) ? htmlspecialchars($emp['nome']) : "Controle de Estoque & PDV";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $nome_loja; ?> - Mobile POS</title>
    
    <!-- PWA configuration -->
    <link rel="manifest" href="manifest.php">
    <meta name="theme-color" content="#6f3e1b">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="<?php echo $nome_loja; ?>">
    <link rel="apple-touch-icon" href="../img/logo.png">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="css/mobile.css">
</head>
<body>

    <!-- Notification Toast System -->
    <div id="toast-container" class="toast-container"></div>

    <!-- Screen 1: Login (shown if not logged in) -->
    <div id="screen-login" class="screen active">
        <div class="login-card glass">
            <div class="login-header">
                <img src="../img/logo.png" alt="Logo" class="login-logo">
                <h2><?php echo $nome_loja; ?></h2>
                <p>Controle de Estoque & PDV</p>
            </div>
            
            <form id="login-form">
                <div class="input-group">
                    <label for="username"><i class="icon-user"></i> Usuário</label>
                    <input type="text" id="username" placeholder="Digite seu usuário" required>
                </div>
                <div class="input-group">
                    <label for="password"><i class="icon-key"></i> Senha</label>
                    <input type="password" id="password" placeholder="Digite sua senha" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </form>
        </div>
    </div>

    <!-- Main App Container (shown if logged in) -->
    <div id="app-container" class="screen">
        
        <!-- Header Bar -->
        <header class="app-header glass">
            <div class="header-user">
                <i class="icon-user-md"></i>
                <span id="user-display-name">Carregando...</span>
            </div>
            <div class="header-logo-text"><?php echo $nome_loja; ?></div>
            <button id="btn-logout" class="btn-icon-logout" title="Sair"><i class="icon-signout"></i></button>
        </header>

        <!-- Main Content (will toggle tabs) -->
        <main class="app-content">

            <!-- Tab 1: Dashboard -->
            <section id="tab-dashboard" class="tab-pane active">
                <div class="section-title">Início</div>
                
                <!-- KPI Cards Grid -->
                <div class="kpi-grid">
                    <div class="kpi-card glass">
                        <div class="kpi-icon money"><i class="icon-money"></i></div>
                        <div class="kpi-info">
                            <span class="kpi-label">Vendido Hoje</span>
                            <span class="kpi-value" id="kpi-total-sales">R$ 0,00</span>
                        </div>
                    </div>
                    <div class="kpi-card glass">
                        <div class="kpi-icon cart"><i class="icon-shopping-cart"></i></div>
                        <div class="kpi-info">
                            <span class="kpi-label">Qtd Vendas</span>
                            <span class="kpi-value" id="kpi-count-sales">0</span>
                        </div>
                    </div>
                </div>

                <!-- Warnings / Alerts Section -->
                <div class="alert-section glass">
                    <div class="alert-header">
                        <i class="icon-warning-sign"></i>
                        <h3>Estoque Crítico</h3>
                        <span class="badge" id="low-stock-count">0</span>
                    </div>
                    <ul class="alert-list" id="low-stock-list">
                        <li class="empty-state">Buscando alertas de estoque...</li>
                    </ul>
                </div>
            </section>

            <!-- Tab 2: POS (PDV) -->
            <section id="tab-pdv" class="tab-pane">
                <div class="section-title">Ponto de Venda</div>

                <!-- Client Selector -->
                <div class="form-group-inline glass">
                    <label for="pdv-client"><i class="icon-user"></i> Cliente:</label>
                    <select id="pdv-client" class="select-modern">
                        <!-- Loaded dynamically -->
                    </select>
                </div>

                <!-- Add item barcode / reference -->
                <div class="barcode-scan-group glass">
                    <div class="input-action-wrapper">
                        <input type="text" id="barcode-input" placeholder="Digite o código de barras (ex: 789...)" autocomplete="off">
                        <button type="button" id="btn-search-product" class="btn btn-secondary" title="Buscar Produto"><i class="icon-search"></i></button>
                        <button type="button" id="btn-add-barcode" class="btn btn-primary" title="Adicionar"><i class="icon-plus"></i></button>
                    </div>
                </div>

                <!-- PDV Shopping Cart -->
                <div class="cart-section glass">
                    <div class="cart-header">
                        <span>Carrinho de Compras</span>
                        <span class="cart-count" id="cart-item-count">0 itens</span>
                    </div>
                    <div class="cart-items-wrapper" id="cart-items">
                        <div class="empty-state">O carrinho está vazio. Adicione itens acima ou pelo catálogo!</div>
                    </div>
                    <div class="cart-footer">
                        <div class="cart-total-row">
                            <span>Total Geral:</span>
                            <span class="total-price" id="cart-total-price">R$ 0,00</span>
                        </div>
                        <button id="btn-checkout" class="btn btn-success btn-block btn-large" disabled><i class="icon-credit-card"></i> Fechar Venda</button>
                    </div>
                </div>
            </section>

            <!-- Tab 3: Catalog (Catálogo) -->
            <section id="tab-catalog" class="tab-pane">
                <div class="section-title">Catálogo de Produtos</div>
                
                <!-- Search Bar -->
                <div class="search-wrapper glass">
                    <i class="icon-search search-icon"></i>
                    <input type="search" id="catalog-search" placeholder="Pesquisar produto ou código..." autocomplete="off">
                </div>

                <!-- Product Grid/List -->
                <div class="product-list" id="catalog-products">
                    <div class="empty-state">Carregando catálogo de produtos...</div>
                </div>
            </section>

            <!-- Tab 4: Sales Report (Relatórios) -->
            <section id="tab-reports" class="tab-pane">
                <div class="section-title">Relatório do Dia</div>

                <div class="report-summary-card glass">
                    <div class="kpi-info">
                        <span class="kpi-label">Faturamento Total do Dia</span>
                        <span class="kpi-value" id="report-total-revenue">R$ 0,00</span>
                    </div>
                </div>

                <div class="sales-list-section glass">
                    <div class="alert-header">
                        <i class="icon-list"></i>
                        <h3>Vendas Realizadas Hoje</h3>
                    </div>
                    <ul class="sales-list" id="report-sales-list">
                        <li class="empty-state">Nenhuma venda realizada hoje.</li>
                    </ul>
                </div>
            </section>

        </main>

        <!-- Bottom Navigation Bar -->
        <nav class="app-nav glass">
            <button class="nav-btn active" data-tab="tab-dashboard">
                <i class="icon-home"></i>
                <span>Início</span>
            </button>
            <button class="nav-btn" data-tab="tab-pdv">
                <i class="icon-shopping-cart"></i>
                <span>PDV</span>
            </button>
            <button class="nav-btn" data-tab="tab-catalog">
                <i class="icon-food"></i>
                <span>Produtos</span>
            </button>
            <button class="nav-btn" data-tab="tab-reports">
                <i class="icon-bar-chart"></i>
                <span>Relatórios</span>
            </button>
        </nav>
    </div>

    <!-- Checkout Bottom Sheet Modal -->
    <div id="checkout-modal" class="modal-backdrop">
        <div class="bottom-sheet glass">
            <div class="modal-header">
                <h3>Finalizar Venda</h3>
                <button id="btn-close-modal" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="checkout-total-display">
                    Total a Pagar: <strong id="checkout-total-val">R$ 0,00</strong>
                </div>

                <!-- Single Payment vs Multiple Payments Toggle -->
                <div class="payment-toggle-group">
                    <label class="toggle-control">
                        <input type="checkbox" id="chk-multiples">
                        <span class="toggle-label"><i class="icon-check-empty"></i> Múltiplas Formas de Pagamento</span>
                    </label>
                </div>

                <!-- Single Payment Select -->
                <div id="single-payment-group" class="form-group">
                    <label for="payment-method">Forma de Pagamento:</label>
                    <select id="payment-method" class="select-modern">
                        <option value="1">Dinheiro</option>
                        <option value="2">Cartão de Crédito/Débito</option>
                        <option value="3">Pix</option>
                    </select>
                </div>

                <!-- Split/Multiple Payments Input -->
                <div id="multiple-payments-group" class="multiple-payments-wrapper" style="display: none;">
                    <div class="form-group-val">
                        <label for="val-dinheiro"><i class="icon-money"></i> Dinheiro (R$):</label>
                        <input type="number" id="val-dinheiro" step="0.01" min="0" placeholder="0.00" value="0">
                    </div>
                    <div class="form-group-val">
                        <label for="val-cartao"><i class="icon-credit-card"></i> Cartão (R$):</label>
                        <input type="number" id="val-cartao" step="0.01" min="0" placeholder="0.00" value="0">
                    </div>
                    <div class="form-group-val">
                        <label for="val-pix"><i class="icon-qrcode"></i> Pix (R$):</label>
                        <input type="number" id="val-pix" step="0.01" min="0" placeholder="0.00" value="0">
                    </div>
                    <div class="split-feedback-row">
                        <span class="feedback-label" id="split-feedback-label">Falta Pagar:</span>
                        <span class="feedback-value" id="split-feedback-val">R$ 0,00</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="checkout-obs">Observação:</label>
                    <textarea id="checkout-obs" class="textarea-modern" placeholder="Adicionar observações do pedido..."></textarea>
                </div>

                <button id="btn-submit-checkout" class="btn btn-success btn-block btn-large"><i class="icon-ok"></i> Confirmar e Concluir</button>
            </div>
        </div>
    </div>

    <!-- Product Search Modal -->
    <div id="search-product-modal" class="modal-backdrop">
        <div class="bottom-sheet glass modal-search-sheet">
            <div class="modal-header">
                <h3>Buscar Produto</h3>
                <button id="btn-close-search-modal" class="modal-close">&times;</button>
            </div>
            <div class="modal-body modal-search-body">
                <div class="search-wrapper glass" style="margin-bottom: 5px;">
                    <i class="icon-search search-icon"></i>
                    <input type="search" id="modal-product-search" placeholder="Pesquisar produto ou código..." autocomplete="off">
                </div>
                <div class="product-list" id="modal-search-results">
                    <div class="empty-state">Digite algo para iniciar a busca...</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Load jQuery and app scripts -->
    <script src="../js/jquery-1.8.3.min.js"></script>
    <script src="js/mobile.js?v=<?= time() ?>"></script>
    <script>
        // Register Service Worker for PWA
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('service-worker.js')
                .then(reg => console.log('Service Worker registrado!', reg))
                .catch(err => console.error('Erro ao registrar Service Worker:', err));
        }
    </script>
</body>
</html>
