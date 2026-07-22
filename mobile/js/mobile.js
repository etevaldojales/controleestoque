// Mobile Client Logic - Delícias Dulce Mobile POS

// App State
let state = {
  user: null,
  activeTab: 'tab-dashboard',
  currentClientId: 1, // default walk-in client
  cart: {
    idpedido: 0,
    items: [],
    total: 0
  }
};

$(document).ready(function () {
  initApp();
  setupEventListeners();
});

// Initialize Application
function initApp() {
  $.ajax({
    url: 'api.php?action=check_session',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response.success && response.user) {
        state.user = response.user;
        showAppScreen();
      } else {
        showLoginScreen();
      }
    },
    error: function () {
      showLoginScreen();
    }
  });
}

// Show/Hide Screens
function showLoginScreen() {
  $('#app-container').removeClass('active');
  $('#screen-login').addClass('active');
  $('#screen-login input').val('');
}

function showAppScreen() {
  $('#screen-login').removeClass('active');
  $('#app-container').addClass('active');
  $('#user-display-name').text(state.user.nome);
  
  // Load default tab
  switchTab('tab-dashboard');
}

// Navigation Tab Switcher
function switchTab(tabId) {
  state.activeTab = tabId;
  
  // Toggle navigation active class
  $('.nav-btn').removeClass('active');
  $(`.nav-btn[data-tab="${tabId}"]`).addClass('active');
  
  // Toggle tab contents
  $('.tab-pane').removeClass('active');
  $(`#${tabId}`).addClass('active');
  
  // Fetch data depending on tab
  if (tabId === 'tab-dashboard') {
    loadDashboard();
  } else if (tabId === 'tab-pdv') {
    loadPdv();
  } else if (tabId === 'tab-catalog') {
    loadCatalog('');
  } else if (tabId === 'tab-reports') {
    loadSalesReport();
  }
}

// 1. Dashboard Tab Loader
function loadDashboard() {
  $.ajax({
    url: 'api.php?action=get_dashboard',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        const stats = response.stats;
        $('#kpi-total-sales').text(formatCurrency(stats.total_sales));
        $('#kpi-count-sales').text(stats.count_sales);
        $('#low-stock-count').text(stats.low_stock_count);
        
        // Render critical stock list
        const $list = $('#low-stock-list');
        $list.empty();
        if (stats.low_stock_list && stats.low_stock_list.length > 0) {
          stats.low_stock_list.forEach(p => {
            $list.append(`
              <li>
                <span>${p.nome}</span>
                <span class="stock-alert">Qtd: ${p.qtd} (mín: ${p.min})</span>
              </li>
            `);
          });
        } else {
          $list.append('<li class="empty-state" style="border:none;background:transparent;color:var(--text-muted);">Estoque saudável!</li>');
        }
      }
    }
  });
}

// 2. PDV (Point of Sale) Tab Loader
function loadPdv() {
  // Load clients if selector is empty
  if ($('#pdv-client option').length === 0) {
    $.ajax({
      url: 'api.php?action=get_clients',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          const $select = $('#pdv-client');
          $select.empty();
          response.clients.forEach(c => {
            $select.append(`<option value="${c.id}">${c.nome}</option>`);
          });
          
          // Select default
          if (response.default_client_id) {
            state.currentClientId = response.default_client_id;
            $select.val(state.currentClientId);
          }
          
          loadCart();
        }
      }
    });
  } else {
    loadCart();
  }
}

// Cart Loader
function loadCart() {
  $.ajax({
    url: 'api.php?action=get_cart',
    type: 'POST',
    data: JSON.stringify({ idcliente: state.currentClientId }),
    contentType: 'application/json',
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        state.cart.idpedido = response.idpedido;
        state.cart.items = response.items;
        state.cart.total = response.total;
        
        renderCart();
      }
    }
  });
}

// Render Cart Items HTML
function renderCart() {
  const $wrapper = $('#cart-items');
  const $count = $('#cart-item-count');
  const $total = $('#cart-total-price');
  const $btnCheckout = $('#btn-checkout');
  
  $wrapper.empty();
  $count.text(`${state.cart.items.length} itens`);
  $total.text(formatCurrency(state.cart.total));
  
  if (state.cart.items.length > 0) {
    $btnCheckout.prop('disabled', false);
    
    state.cart.items.forEach(i => {
      const undText = i.unidade == 1 ? 'und' : 'kg';
      $wrapper.append(`
        <div class="cart-item">
          <div class="cart-item-details">
            <span class="cart-item-name">${i.nome}</span>
            <span class="cart-item-meta">${formatCurrency(i.valor_unitario)} / ${undText}</span>
          </div>
          <div class="cart-item-qty-control" style="display:flex;align-items:center;gap:10px;background:rgba(0,0,0,0.2);padding:4px 8px;border-radius:6px;margin:0 10px;">
            <button class="btn-qty" style="background:transparent;border:none;color:var(--primary-color);font-size:1.1rem;font-weight:bold;cursor:pointer;padding:0 5px;" onclick="changeItemQty(${i.id_item}, ${i.quantidade - 1})">-</button>
            <span class="qty-display" style="font-size:0.9rem;font-weight:600;min-width:20px;text-align:center;">${i.quantidade}</span>
            <button class="btn-qty" style="background:transparent;border:none;color:var(--primary-color);font-size:1.1rem;font-weight:bold;cursor:pointer;padding:0 5px;" onclick="changeItemQty(${i.id_item}, ${i.quantidade + 1})">+</button>
          </div>
          <div class="cart-item-pricing" style="text-align:right;margin-right:12px;">
            <span class="cart-item-total">${formatCurrency(i.valor_total)}</span>
          </div>
          <button class="btn-remove-item" onclick="removeItemFromCart(${i.id_item})"><i class="icon-trash"></i></button>
        </div>
      `);
    });
  } else {
    $btnCheckout.prop('disabled', true);
    $wrapper.append('<div class="empty-state">O carrinho está vazio. Adicione itens acima ou pelo catálogo!</div>');
  }
}

// Add Item via Barcode Input
function addBarcodeItem() {
  const barcode = $('#barcode-input').val().trim();
  if (!barcode) return;
  
  $.ajax({
    url: 'api.php?action=add_to_cart',
    type: 'POST',
    data: JSON.stringify({
      idcliente: state.currentClientId,
      codigo: barcode,
      qty: 1
    }),
    contentType: 'application/json',
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        showToast('Produto adicionado ao carrinho', 'success');
        $('#barcode-input').val('');
        loadCart();
      } else {
        showToast(response.error || 'Erro ao adicionar produto', 'error');
      }
    },
    error: function () {
      showToast('Erro de rede ao adicionar item', 'error');
    }
  });
}

// Remove Item from Cart
function removeItemFromCart(itemId) {
  if (confirm('Deseja realmente remover este item?')) {
    $.ajax({
      url: 'api.php?action=remove_from_cart',
      type: 'POST',
      data: JSON.stringify({ id_item: itemId }),
      contentType: 'application/json',
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          showToast('Item removido do carrinho', 'success');
          loadCart();
        } else {
          showToast(response.error || 'Erro ao remover item', 'error');
        }
      }
    });
  }
}

// Change quantity of cart item
function changeItemQty(itemId, newQty) {
  if (newQty <= 0) {
    removeItemFromCart(itemId);
    return;
  }
  $.ajax({
    url: 'api.php?action=update_cart_qty',
    type: 'POST',
    data: JSON.stringify({ id_item: itemId, qty: newQty }),
    contentType: 'application/json',
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        loadCart();
      } else {
        showToast(response.error || 'Erro ao atualizar quantidade', 'error');
      }
    }
  });
}

// Add Catalog Product to Cart
function addCatalogProductToCart(barcode) {
  $.ajax({
    url: 'api.php?action=add_to_cart',
    type: 'POST',
    data: JSON.stringify({
      idcliente: state.currentClientId,
      codigo: barcode,
      qty: 1
    }),
    contentType: 'application/json',
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        showToast('Produto adicionado ao carrinho', 'success');
        // Pre-fetch cart updates silently
        $.ajax({
          url: 'api.php?action=get_cart',
          type: 'POST',
          data: JSON.stringify({ idcliente: state.currentClientId }),
          contentType: 'application/json',
          dataType: 'json',
          success: function (res) {
            if (res.success) {
              state.cart.idpedido = res.idpedido;
              state.cart.items = res.items;
              state.cart.total = res.total;
            }
          }
        });
      } else {
        showToast(response.error || 'Erro ao adicionar produto', 'error');
      }
    }
  });
}

// Add Modal Product to Cart
function addModalProductToCart(barcode) {
  $.ajax({
    url: 'api.php?action=add_to_cart',
    type: 'POST',
    data: JSON.stringify({
      idcliente: state.currentClientId,
      codigo: barcode,
      qty: 1
    }),
    contentType: 'application/json',
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        showToast('Produto adicionado ao carrinho', 'success');
        loadCart();
      } else {
        showToast(response.error || 'Erro ao adicionar produto', 'error');
      }
    },
    error: function () {
      showToast('Erro de rede ao adicionar item', 'error');
    }
  });
}

// Search products inside the modal
function loadModalSearch(query) {
  const $list = $('#modal-search-results');
  
  $.ajax({
    url: 'api.php?action=get_products',
    type: 'POST',
    data: JSON.stringify({ query: query }),
    contentType: 'application/json',
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        $list.empty();
        
        if (response.products.length > 0) {
          response.products.forEach(p => {
            const undText = p.unidade == 1 ? 'und' : 'kg';
            let stockStatus = `Estoque: ${p.estoque} ${undText}`;
            
            if (p.estoque <= 0) {
              stockStatus = '<span class="tag-out-of-stock">Sem Estoque</span>';
            } else if (p.estoque <= p.estoque_minimo) {
              stockStatus = `<span class="tag-low-stock">Estoque Baixo (${p.estoque})</span>`;
            }
            
            $list.append(`
              <div class="product-card glass">
                <div class="product-info">
                  <span class="product-title">${p.nome}</span>
                  <div class="product-meta">
                    <span>Cod: ${p.codigo}</span>
                    <span>•</span>
                    <span>${stockStatus}</span>
                  </div>
                </div>
                <div class="product-actions" style="display:flex;align-items:center;gap:12px;">
                  <span class="tag-price">${formatCurrency(p.valor)}</span>
                  ${p.estoque > 0 ? `<button class="btn btn-primary" style="padding:6px 12px;font-size:0.8rem;border-radius:6px;" onclick="addModalProductToCart('${p.codigo}')"><i class="icon-shopping-cart"></i> Add</button>` : ''}
                </div>
              </div>
            `);
          });
        } else {
          $list.append('<div class="empty-state">Nenhum produto encontrado.</div>');
        }
      } else {
        $list.html('<div class="empty-state">Erro ao carregar produtos.</div>');
      }
    },
    error: function () {
      $list.html('<div class="empty-state">Erro de rede ao carregar produtos.</div>');
    }
  });
}

// 3. Catalog Tab Loader
function loadCatalog(query) {
  $.ajax({
    url: 'api.php?action=get_products',
    type: 'POST',
    data: JSON.stringify({ query: query }),
    contentType: 'application/json',
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        const $list = $('#catalog-products');
        $list.empty();
        
        if (response.products.length > 0) {
          response.products.forEach(p => {
            const undText = p.unidade == 1 ? 'und' : 'kg';
            let stockStatus = `Estoque: ${p.estoque} ${undText}`;
            let alertClass = '';
            
            if (p.estoque <= 0) {
              stockStatus = '<span class="tag-out-of-stock">Sem Estoque</span>';
            } else if (p.estoque <= p.estoque_minimo) {
              stockStatus = `<span class="tag-low-stock">Estoque Baixo (${p.estoque})</span>`;
            }
            
            $list.append(`
              <div class="product-card glass">
                <div class="product-info">
                  <span class="product-title">${p.nome}</span>
                  <div class="product-meta">
                    <span>Cod: ${p.codigo}</span>
                    <span>•</span>
                    <span>${stockStatus}</span>
                  </div>
                </div>
                <div class="product-actions" style="display:flex;align-items:center;gap:12px;">
                  <span class="tag-price">${formatCurrency(p.valor)}</span>
                  ${p.estoque > 0 ? `<button class="btn btn-primary" style="padding:6px 12px;font-size:0.8rem;border-radius:6px;" onclick="addCatalogProductToCart('${p.codigo}')"><i class="icon-shopping-cart"></i> Add</button>` : ''}
                </div>
              </div>
            `);
          });
        } else {
          $list.append('<div class="empty-state">Nenhum produto encontrado.</div>');
        }
      }
    }
  });
}

// 4. Sales Report Tab Loader
function loadSalesReport() {
  $.ajax({
    url: 'api.php?action=get_sales_report',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        $('#report-total-revenue').text(formatCurrency(response.total_sum));
        
        const $list = $('#report-sales-list');
        $list.empty();
        
        if (response.sales && response.sales.length > 0) {
          response.sales.forEach(s => {
            $list.append(`
              <li class="sale-item">
                <div class="sale-details">
                  <span class="sale-number">Pedido Nº: ${s.numero}</span>
                  <span class="sale-payment">${s.cliente} • ${s.pagamento}</span>
                </div>
                <span class="sale-amount">${formatCurrency(s.valor)}</span>
              </li>
            `);
          });
        } else {
          $list.append('<li class="empty-state">Nenhuma venda realizada hoje.</li>');
        }
      }
    }
  });
}

// Checkout Form Setup and Calculations
function setupCheckoutModal() {
  $('#checkout-total-val').text(formatCurrency(state.cart.total));
  $('#checkout-obs').val('');
  $('#chk-multiples').prop('checked', false);
  $('#single-payment-group').show();
  $('#multiple-payments-group').hide();
  
  // Reset values
  $('#val-dinheiro').val('');
  $('#val-cartao').val('');
  $('#val-pix').val('');
  $('#split-feedback-val').text(formatCurrency(state.cart.total)).removeClass('ok error');
  $('#split-feedback-label').text('Falta Pagar:');
  
  // Show Modal
  $('#checkout-modal').addClass('active');
}

function calculateSplitPayments() {
  const total = state.cart.total;
  const din = parseFloat($('#val-dinheiro').val()) || 0;
  const car = parseFloat($('#val-cartao').val()) || 0;
  const pix = parseFloat($('#val-pix').val()) || 0;
  
  const paidSum = din + car + pix;
  const diff = total - paidSum;
  
  const $val = $('#split-feedback-val');
  const $label = $('#split-feedback-label');
  const $btn = $('#btn-submit-checkout');
  
  if (diff > 0.005) {
    // Underpaid
    $label.text('Falta Pagar:');
    $val.text(formatCurrency(diff)).removeClass('ok').addClass('error');
    $btn.prop('disabled', true);
  } else if (diff < -0.005) {
    // Overpaid (Only cash can generate change)
    const change = Math.abs(diff);
    $label.text('Troco (Dinheiro):');
    $val.text(formatCurrency(change)).removeClass('error').addClass('ok');
    $btn.prop('disabled', false);
  } else {
    // Exactly paid
    $label.text('Total Pago!');
    $val.text(formatCurrency(paidSum)).removeClass('error').addClass('ok');
    $btn.prop('disabled', false);
  }
}

function submitCheckout() {
  const isMultiples = $('#chk-multiples').is(':checked') ? 1 : 0;
  const formpag = $('#payment-method').val();
  const valDin = parseFloat($('#val-dinheiro').val()) || 0;
  const valCar = parseFloat($('#val-cartao').val()) || 0;
  const valPx = parseFloat($('#val-pix').val()) || 0;
  const obs = $('#checkout-obs').val();
  
  const $btnSubmit = $('#btn-submit-checkout');
  $btnSubmit.prop('disabled', true).text('Concluindo...');
  
  $.ajax({
    url: 'api.php?action=checkout',
    type: 'POST',
    data: JSON.stringify({
      idpedido: state.cart.idpedido,
      observacao: obs,
      formpag: formpag,
      is_multiplas: isMultiples,
      val_dinheiro: valDin,
      val_cartao: valCar,
      val_pix: valPx
    }),
    contentType: 'application/json',
    dataType: 'json',
    success: function (response) {
      $btnSubmit.prop('disabled', false).html('<i class="icon-ok"></i> Confirmar e Concluir');
      if (response.success) {
        const orderIdToPrint = state.cart.idpedido;
        showToast('Venda finalizada com sucesso!', 'success');
        $('#checkout-modal').removeClass('active');
        
        // Open print window
        window.open('../impressao_pedido.php?idpedido=' + orderIdToPrint, '_blank');
        
        // Reload dashboard and cart
        state.cart = { idpedido: 0, items: [], total: 0 };
        renderCart();
        switchTab('tab-dashboard');
      } else {
        showToast(response.error || 'Erro ao finalizar venda', 'error');
      }
    },
    error: function () {
      $btnSubmit.prop('disabled', false).html('<i class="icon-ok"></i> Confirmar e Concluir');
      showToast('Erro de rede ao finalizar venda', 'error');
    }
  });
}

// UI Setup Event Listeners
function setupEventListeners() {
  // Navigation tabs
  $('.nav-btn').on('click', function () {
    const tab = $(this).data('tab');
    switchTab(tab);
  });
  
  // Login Form Submission
  $('#login-form').on('submit', function (e) {
    e.preventDefault();
    const userVal = $('#username').val().trim();
    const passVal = $('#password').val().trim();
    
    const $btn = $('#login-form button[type="submit"]');
    $btn.prop('disabled', true).text('Verificando...');
    
    $.ajax({
      url: 'api.php?action=login',
      type: 'POST',
      data: JSON.stringify({ login_usu: userVal, senha: passVal }),
      contentType: 'application/json',
      dataType: 'json',
      success: function (response) {
        $btn.prop('disabled', false).text('Entrar');
        if (response.success && response.user) {
          state.user = response.user;
          showToast('Bem-vindo!', 'success');
          showAppScreen();
        } else {
          showToast(response.error || 'Login inválido', 'error');
        }
      },
      error: function () {
        $btn.prop('disabled', false).text('Entrar');
        showToast('Erro de rede ao fazer login', 'error');
      }
    });
  });
  
  // Logout Button
  $('#btn-logout').on('click', function () {
    if (confirm('Deseja realmente sair?')) {
      $.ajax({
        url: 'api.php?action=logout',
        type: 'GET',
        dataType: 'json',
        success: function () {
          state.user = null;
          showToast('Até logo!', 'success');
          showLoginScreen();
        }
      });
    }
  });
  
  // Client selection update
  $('#pdv-client').on('change', function () {
    state.currentClientId = parseInt($(this).val());
    loadCart();
  });
  
  // Barcode Submit
  $('#btn-add-barcode').on('click', function () {
    addBarcodeItem();
  });
  $('#barcode-input').on('keydown', function (e) {
    if (e.key === 'Enter') {
      addBarcodeItem();
    }
  });

  // Open Product Search Modal
  $('#btn-search-product').on('click', function () {
    $('#modal-product-search').val('');
    loadModalSearch('');
    $('#search-product-modal').addClass('active');
    setTimeout(() => {
      $('#modal-product-search').focus();
    }, 150);
  });

  // Close Product Search Modal
  $('#btn-close-search-modal').on('click', function () {
    $('#search-product-modal').removeClass('active');
  });

  $('#search-product-modal').on('click', function (e) {
    if (e.target === this) {
      $(this).removeClass('active');
    }
  });

  // Modal Product Search Input
  $('#modal-product-search').on('input', function () {
    const q = $(this).val().trim();
    loadModalSearch(q);
  });
  
  // Catalog Search
  $('#catalog-search').on('input', function () {
    const q = $(this).val().trim();
    loadCatalog(q);
  });
  
  // Checkout sheet buttons
  $('#btn-checkout').on('click', function () {
    setupCheckoutModal();
  });
  $('#btn-close-modal').on('click', function () {
    $('#checkout-modal').removeClass('active');
  });
  
  // Multiples payments checkbox toggler
  $('#chk-multiples').on('change', function () {
    const isChecked = $(this).is(':checked');
    if (isChecked) {
      $('#single-payment-group').hide();
      $('#multiple-payments-group').show();
      $('#btn-submit-checkout').prop('disabled', true);
      calculateSplitPayments();
    } else {
      $('#single-payment-group').show();
      $('#multiple-payments-group').hide();
      $('#btn-submit-checkout').prop('disabled', false);
    }
  });
  
  // Split payment amounts input update
  $('#val-dinheiro, #val-cartao, #val-pix').on('input', function () {
    calculateSplitPayments();
  });
  
  // Confirm Checkout Submit
  $('#btn-submit-checkout').on('click', function () {
    submitCheckout();
  });
}

// Utility Helpers
function formatCurrency(val) {
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(val || 0);
}

function showToast(message, type = 'info') {
  const $container = $('#toast-container');
  const toastId = 'toast-' + Date.now();
  
  const icon = type === 'success' ? 'icon-ok-sign' 
             : type === 'error' ? 'icon-remove-sign' 
             : type === 'warning' ? 'icon-warning-sign' 
             : 'icon-info-sign';
             
  $container.append(`
    <div id="${toastId}" class="toast ${type}">
      <i class="${icon}"></i>
      <span>${message}</span>
    </div>
  `);
  
  // Automatically remove toast after fadeOut finishes (3.0s total)
  setTimeout(() => {
    $(`#${toastId}`).remove();
  }, 3050);
}
