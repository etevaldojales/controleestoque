(function() {
    // 1. Garantir que o container exista no DOM
    function getContainer() {
        var container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            document.body.appendChild(container);
        }
        return container;
    }

    // 2. Função de exibição do Toast
    window.showToast = function(message, type, duration) {
        type = type || 'info';
        duration = duration || 4000;

        var container = getContainer();
        var toast = document.createElement('div');
        toast.className = 'custom-toast toast-' + type;
        
        // Estrutura HTML interna
        toast.innerHTML = '<span class="custom-toast-close">&times;</span>' +
                          '<div class="custom-toast-message">' + message + '</div>';

        container.appendChild(toast);

        // Forçar reflow para iniciar animação de entrada
        toast.offsetHeight;
        toast.classList.add('show');

        // Configurar timer para remoção automática
        var removeTimer = setTimeout(dismiss, duration);

        function dismiss() {
            clearTimeout(removeTimer);
            toast.classList.remove('show');
            toast.classList.add('hide');
            
            // Aguardar a transição CSS terminar para remover do DOM
            toast.addEventListener('transitionend', function handler(e) {
                if (e.propertyName === 'transform' || e.propertyName === 'opacity') {
                    toast.removeEventListener('transitionend', handler);
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }
            });
        }

        // Fechar ao clicar
        toast.onclick = function() {
            dismiss();
        };
    };

    // 3. Sobrescrever window.alert com categorização inteligente de palavras-chave
    window.alert = function(message) {
        if (typeof message !== 'string') {
            message = String(message);
        }

        var msgLower = message.toLowerCase();
        var type = 'info';

        // Detecção automática de tipo por palavra-chave
        if (msgLower.indexOf('sucesso') !== -1 || 
            msgLower.indexOf('cadastrado') !== -1 || 
            msgLower.indexOf('salvo') !== -1 || 
            msgLower.indexOf('atualizado') !== -1 || 
            msgLower.indexOf('adicionado') !== -1 || 
            msgLower.indexOf('excluído') !== -1 || 
            msgLower.indexOf('excluido') !== -1 || 
            msgLower.indexOf('concluído') !== -1 || 
            msgLower.indexOf('concluido') !== -1) {
            type = 'success';
        } else if (msgLower.indexOf('erro') !== -1 || 
                   msgLower.indexOf('falha') !== -1 || 
                   msgLower.indexOf('inválido') !== -1 || 
                   msgLower.indexOf('invalido') !== -1 || 
                   msgLower.indexOf('não encontrado') !== -1 || 
                   msgLower.indexOf('nao encontrado') !== -1 || 
                   msgLower.indexOf('não existe') !== -1 || 
                   msgLower.indexOf('nao existe') !== -1) {
            type = 'error';
        } else if (msgLower.indexOf('atenção') !== -1 || 
                   msgLower.indexOf('atencao') !== -1 || 
                   msgLower.indexOf('aviso') !== -1 || 
                   msgLower.indexOf('verifique') !== -1 ||
                   msgLower.indexOf('não há') !== -1 ||
                   msgLower.indexOf('nao ha') !== -1) {
            type = 'warning';
        }

        window.showToast(message, type);
    };

    // 4. Diálogo de confirmação customizado moderno (baseado em Bootstrap modal)
    window.customConfirm = function(message, onConfirm, onCancel) {
        var modal = document.getElementById('custom-confirm-modal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'custom-confirm-modal';
            modal.className = 'modal hide fade';
            modal.setAttribute('tabindex', '-1');
            modal.setAttribute('role', 'dialog');
            modal.setAttribute('aria-hidden', 'true');
            modal.style.width = '420px';
            modal.style.marginLeft = '-210px';
            document.body.appendChild(modal);
        }

        var html = '';
        html += '<div class="modal-header" style="background: linear-gradient(135deg, #1f2937, #111827); color: #fff; border-top-left-radius: 6px; border-top-right-radius: 6px; padding: 12px 20px;">';
        html += '  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff; opacity: 0.8; font-size: 24px; line-height: 20px; font-weight: bold; background: transparent; border: 0;">&times;</button>';
        html += '  <h3 style="margin:0; font-size:1.15rem; font-weight:600; color:#fff;">Confirmação</h3>';
        html += '</div>';
        html += '<div class="modal-body" style="padding: 20px; background-color: #f9fafb; font-size: 14px; color: #374151; font-weight: 500;">';
        html += '  <p style="margin: 0;">' + message + '</p>';
        html += '</div>';
        html += '<div class="modal-footer" style="background-color: #f3f4f6; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; padding: 10px 20px; text-align: right; border-top: 1px solid #e5e7eb;">';
        html += '  <button class="btn btn-cancelar" data-dismiss="modal" aria-hidden="true" style="border-radius: 6px; padding: 6px 14px; font-weight: 500; font-size: 12px;">Não</button>';
        html += '  <button class="btn btn-danger btn-confirmar" style="border-radius: 6px; padding: 6px 18px; font-weight: 600; font-size: 12px; background-color: #ef4444; background-image: none; border: none; text-shadow: none; box-shadow: none; color: #fff;">Sim</button>';
        html += '</div>';
        
        modal.innerHTML = html;

        var btnConfirmar = modal.querySelector('.btn-confirmar');
        var btnCancelar = modal.querySelector('.btn-cancelar');
        var btnClose = modal.querySelector('.close');

        btnConfirmar.onclick = function() {
            $(modal).modal('hide');
            if (typeof onConfirm === 'function') {
                onConfirm();
            }
        };

        var cancelHandler = function() {
            if (typeof onCancel === 'function') {
                onCancel();
            }
        };
        btnCancelar.onclick = cancelHandler;
        btnClose.onclick = cancelHandler;

        $(modal).modal('show');
    };

    window.validarDatas = function(datai, dataf) {
        if (!datai || !dataf) return true;
        var sepI = datai.indexOf('/') !== -1 ? '/' : '-';
        var sepF = dataf.indexOf('/') !== -1 ? '/' : '-';
        var partsI = datai.split(sepI);
        var partsF = dataf.split(sepF);
        if (partsI.length === 3 && partsF.length === 3) {
            var dateI = new Date(partsI[2], partsI[1] - 1, partsI[0]);
            var dateF = new Date(partsF[2], partsF[1] - 1, partsF[0]);
            if (dateI > dateF) {
                alert("A data inicial não pode ser maior que a data final");
                return false;
            }
        }
        return true;
    };
})();
