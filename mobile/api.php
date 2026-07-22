<?php
$lib = '../lib/';
require_once($lib . 'classes/config.php');
require_once($lib . 'classes/class.usuario.php');
require_once($lib . 'classes/class.produto.php');
require_once($lib . 'classes/class.pedido.php');
require_once($lib . 'classes/class.cliente.php');
require_once($lib . 'classes/class.logs.php');
require_once($lib . 'classes/class.estoque.php');
require_once($lib . 'classes/class.parcela.php');

header('Content-Type: application/json; charset=utf-8');

// Parse request data (support both JSON body and POST fields)
$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$action = $_GET['action'] ?? $data['action'] ?? '';

// Check if user is logged in (exclude 'login' action)
if ($action !== 'login' && !isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$_usuario = new usuario($dbase);
$_produto = new produto($dbase);
$_pedido = new pedido($dbase);
$_cliente = new cliente($dbase);
$_logs = new logs($dbase);
$_estoque = new estoque($dbase);
$_parcela = new parcela($dbase);

switch ($action) {
    case 'login':
        $login = trim(htmlspecialchars($data['login_usu'] ?? '', ENT_QUOTES, 'UTF-8'));
        $senha = md5(trim($data['senha'] ?? ''));
        if (empty($login) || empty($senha)) {
            echo json_encode(['success' => false, 'error' => 'Login e senha obrigatórios.']);
            exit;
        }
        $validado = $_usuario->verificaLogin($login, $senha);
        if (is_array($validado) && $validado['ativo'] == 1) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION["usuario"] = $validado['id_usuario'];
            $_SESSION["nome_usuario"] = $validado['nome'];
            $_SESSION["foto_usuario"] = $validado['foto'] ?? '';
            $_SESSION["tipo_usuario"] = $validado['tipo_usuario'];
            echo json_encode(['success' => true, 'user' => [
                'id' => $validado['id_usuario'],
                'nome' => $validado['nome'],
                'tipo' => $validado['tipo_usuario']
            ]]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Login ou senha inválidos.']);
        }
        break;

    case 'logout':
        session_destroy();
        echo json_encode(['success' => true]);
        break;

    case 'check_session':
        echo json_encode([
            'success' => true,
            'logged_in' => true,
            'user' => [
                'id' => $_SESSION['usuario'],
                'nome' => $_SESSION['nome_usuario'],
                'tipo' => $_SESSION['tipo_usuario']
            ]
        ]);
        break;

    case 'get_dashboard':
        $today = date('Y-m-d');
        
        // Vendas hoje (valor total e quantidade)
        $sqlSales = "SELECT SUM(valor) as total, COUNT(id) as count FROM tblpedido WHERE status_pedido = 2 AND data_pedido = ?";
        $rsSales = $dbase->query($sqlSales, [$today]);
        $totalSales = $rsSales && !$rsSales->EOF ? floatval($rsSales->fields['total']) : 0;
        $countSales = $rsSales && !$rsSales->EOF ? intval($rsSales->fields['count']) : 0;

        // Produtos com estoque baixo (estoque <= estoque_minimo)
        $sqlLow = "SELECT p.id, p.nome, e.qtdacumulado, e.estoque_minimo 
                   FROM tblproduto p 
                   LEFT JOIN tblestoque e ON e.id_produto = p.id 
                   AND e.id = (SELECT MAX(id) FROM tblestoque WHERE id_produto = p.id)
                   WHERE p.stativo = 1 AND (e.qtdacumulado IS NULL OR e.qtdacumulado <= e.estoque_minimo)";
        $rsLow = $dbase->query($sqlLow);
        $lowStockCount = 0;
        $lowStockProducts = [];
        if ($rsLow) {
            while (!$rsLow->EOF) {
                $lowStockCount++;
                $lowStockProducts[] = [
                    'id' => $rsLow->fields['id'],
                    'nome' => $rsLow->fields['nome'],
                    'qtd' => floatval($rsLow->fields['qtdacumulado'] ?? 0),
                    'min' => floatval($rsLow->fields['estoque_minimo'] ?? 0)
                ];
                $rsLow->moveNext();
            }
        }

        // Total de produtos cadastrados
        $sqlTotalProd = "SELECT COUNT(*) as total FROM tblproduto WHERE stativo = 1";
        $rsTotalProd = $dbase->query($sqlTotalProd);
        $totalProducts = $rsTotalProd && !$rsTotalProd->EOF ? intval($rsTotalProd->fields['total']) : 0;

        echo json_encode([
            'success' => true,
            'stats' => [
                'total_sales' => $totalSales,
                'count_sales' => $countSales,
                'low_stock_count' => $lowStockCount,
                'total_products' => $totalProducts,
                'low_stock_list' => array_slice($lowStockProducts, 0, 5) // top 5
            ]
        ]);
        break;

    case 'get_products':
        $search = trim($data['query'] ?? '');
        $where = "WHERE p.stativo = 1";
        $params = [];
        if ($search !== '') {
            $where .= " AND (p.nome LIKE ? OR p.codigo LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        $sql = "SELECT p.id, p.nome, p.codigo, p.valor, p.unidade 
                FROM tblproduto p 
                $where 
                ORDER BY p.nome ASC 
                LIMIT 50";
        
        $rs = empty($params) ? $dbase->query($sql) : $dbase->query($sql, $params);
        $products = [];
        if ($rs) {
            while (!$rs->EOF) {
                $id = $rs->fields['id'];
                $stock = $_produto->getEstoque($id);
                $min_stock = $_produto->getEstoqueMinimo($id);
                $products[] = [
                    'id' => $id,
                    'nome' => $rs->fields['nome'],
                    'codigo' => $rs->fields['codigo'],
                    'valor' => floatval($rs->fields['valor']),
                    'unidade' => intval($rs->fields['unidade']), // 1 = Und, 2 = Kg
                    'estoque' => floatval($stock),
                    'estoque_minimo' => floatval($min_stock)
                ];
                $rs->moveNext();
            }
        }
        echo json_encode(['success' => true, 'products' => $products]);
        break;

    case 'get_clients':
        $sql = "SELECT id, nome FROM tblcliente WHERE stativo = 1 ORDER BY nome ASC";
        $rs = $dbase->query($sql);
        $clients = [];
        if ($rs) {
            while (!$rs->EOF) {
                $clients[] = [
                    'id' => intval($rs->fields['id']),
                    'nome' => $rs->fields['nome']
                ];
                $rs->moveNext();
            }
        }
        $default_client_id = $_cliente->getClientePdv();
        echo json_encode([
            'success' => true, 
            'clients' => $clients, 
            'default_client_id' => intval($default_client_id)
        ]);
        break;

    case 'get_cart':
        $idcliente = intval($data['idcliente'] ?? $_cliente->getClientePdv());
        $pedido = $_pedido->getPedido($idcliente);
        $cart_items = [];
        $total = 0;
        $idpedido = 0;

        if (is_array($pedido)) {
            $idpedido = intval($pedido['id']);
            $itens = $_pedido->getItens($idpedido);
            if (is_array($itens)) {
                foreach ($itens as $i) {
                    $prod = $_produto->get($i['id_produto']);
                    $cart_items[] = [
                        'id_item' => intval($i['id']),
                        'id_produto' => intval($i['id_produto']),
                        'nome' => $prod['nome'],
                        'codigo' => $prod['codigo'],
                        'quantidade' => floatval($i['quantidade']),
                        'unidade' => intval($prod['unidade']),
                        'valor_unitario' => floatval($i['valor_unitario']),
                        'valor_total' => floatval($i['valor_total'])
                    ];
                    $total += floatval($i['valor_total']);
                }
            }
        }
        
        echo json_encode([
            'success' => true,
            'idpedido' => $idpedido,
            'idcliente' => $idcliente,
            'items' => $cart_items,
            'total' => $total
        ]);
        break;

    case 'add_to_cart':
        $idcliente = intval($data['idcliente'] ?? $_cliente->getClientePdv());
        $codigo = trim($data['codigo'] ?? '');
        $qty = floatval($data['qty'] ?? 1);
        $id_usuario = $_SESSION['usuario'];

        if (empty($codigo)) {
            echo json_encode(['success' => false, 'error' => 'Código do produto é obrigatório.']);
            exit;
        }

        $prod = $_produto->getBycodigo($codigo);
        if (!$prod) {
            echo json_encode(['success' => false, 'error' => 'Produto não encontrado.']);
            exit;
        }

        $id_prod = $prod['id'];
        
        $pedido = $_pedido->getPedido($idcliente);
        if (is_array($pedido)) {
            $idpedido = intval($pedido['id']);
        } else {
            $numpedido = $_pedido->getUltimoNumeroPedido();
            $idpedido = $_pedido->insert($idcliente, $numpedido, date('Y-m-d'), 0, 0, 0, 1, '', $id_usuario);
        }

        if ($_pedido->verificarItem($id_prod, $idpedido)) {
            $valor_venda = floatval(str_replace(',', '.', str_replace('.', '', $prod['valor'])));
            $valor_total = $valor_venda * $qty;
            
            $ret = $_pedido->insertItem($id_prod, $idpedido, $qty, $prod['valor_compra'], $valor_venda, $valor_total);
            if ($ret) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erro ao inserir item no carrinho.']);
            }
        } else {
            // Item já existe no carrinho, vamos incrementar a quantidade
            $sql = "SELECT id, quantidade, valor_unitario FROM tblitenspedido WHERE id_produto = ? AND id_pedido = ? LIMIT 1";
            $rs = $dbase->query($sql, [$id_prod, $idpedido]);
            if ($rs && !$rs->EOF) {
                $itemId = intval($rs->fields['id']);
                $currentQty = floatval($rs->fields['quantidade']);
                $valUnit = floatval($rs->fields['valor_unitario']);
                
                $newQty = $currentQty + $qty;
                $newTotal = $valUnit * $newQty;
                
                $sqlUp = "UPDATE tblitenspedido SET quantidade = ?, valor_total = ? WHERE id = ?";
                $ret = $dbase->execute($sqlUp, [$newQty, $newTotal, $itemId]);
                if ($ret) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Erro ao incrementar quantidade do item existente.']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Erro ao localizar item existente.']);
            }
        }
        break;

    case 'update_cart_qty':
        $id_item = intval($data['id_item'] ?? 0);
        $qty = floatval($data['qty'] ?? 1);
        
        if ($id_item <= 0 || $qty <= 0) {
            echo json_encode(['success' => false, 'error' => 'Parâmetros inválidos.']);
            exit;
        }
        
        // Busca o preço unitário do item para recalcular o total
        $sql = "SELECT id_produto, valor_unitario FROM tblitenspedido WHERE id = ? LIMIT 1";
        $rs = $dbase->query($sql, [$id_item]);
        if ($rs && !$rs->EOF) {
            $val_unit = floatval($rs->fields['valor_unitario']);
            $val_total = $val_unit * $qty;
            
            $sqlUp = "UPDATE tblitenspedido SET quantidade = ?, valor_total = ? WHERE id = ?";
            $ret = $dbase->execute($sqlUp, [$qty, $val_total, $id_item]);
            if ($ret) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erro ao atualizar quantidade no banco.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Item não encontrado.']);
        }
        break;

    case 'remove_from_cart':
        $id_item = intval($data['id_item'] ?? 0);
        if ($id_item <= 0) {
            echo json_encode(['success' => false, 'error' => 'ID do item inválido.']);
            exit;
        }
        $sql = "DELETE FROM tblitenspedido WHERE id = ?";
        $ret = $dbase->execute($sql, [$id_item]);
        if ($ret) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao remover item.']);
        }
        break;

    case 'checkout':
        $idpedido = intval($data['idpedido'] ?? 0);
        if ($idpedido <= 0) {
            echo json_encode(['success' => false, 'error' => 'Pedido inválido.']);
            exit;
        }

        $obs = htmlspecialchars($data['observacao'] ?? '', ENT_QUOTES, 'UTF-8');
        $formpg = intval($data['formpag'] ?? 1);
        $is_multiplas = intval($data['is_multiplas'] ?? 0);
        $val_din = floatval($data['val_dinheiro'] ?? 0);
        $val_car = floatval($data['val_cartao'] ?? 0);
        $val_px = floatval($data['val_pix'] ?? 0);
        $current_date = date('Y-m-d');

        $pedido = $_pedido->get($idpedido);
        if (!$pedido) {
            echo json_encode(['success' => false, 'error' => 'Pedido não encontrado.']);
            exit;
        }

        // Calcule os totais do pedido com base nos itens reais
        $itens = $_pedido->getItens($idpedido);
        $total = 0;
        $total_custo = 0;
        $total_venda = 0;
        if (is_array($itens)) {
            foreach ($itens as $i) {
                $total += floatval($i['valor_total']);
                $total_custo += floatval($i['valor_unitario_compra'] * $i['quantidade']);
                $total_venda += floatval($i['valor_unitario'] * $i['quantidade']);
            }
        }

        // Conclui o pedido no banco
        $ret = $_pedido->concluirPedido($idpedido, $obs, $total, $total_custo, $total_venda, $current_date, $formpg);

        if ($ret) {
            // Insere as parcelas de pagamento
            if ($is_multiplas == 1) {
                if ($val_din > 0) {
                    $nossonum = $_parcela->getUltimoNossoNumero();
                    $_parcela->insert($idpedido, $val_din, $current_date, $val_din, $current_date, $val_din, 0, 0, 2, $_SESSION["usuario"], 1, $nossonum);
                }
                if ($val_car > 0) {
                    $nossonum = $_parcela->getUltimoNossoNumero();
                    $_parcela->insert($idpedido, $val_car, $current_date, $val_car, $current_date, $val_car, 0, 0, 2, $_SESSION["usuario"], 2, $nossonum);
                }
                if ($val_px > 0) {
                    $nossonum = $_parcela->getUltimoNossoNumero();
                    $_parcela->insert($idpedido, $val_px, $current_date, $val_px, $current_date, $val_px, 0, 0, 2, $_SESSION["usuario"], 3, $nossonum);
                }
            } else {
                $nossonum = $_parcela->getUltimoNossoNumero();
                $_parcela->insert($idpedido, $total, $current_date, $total, $current_date, $total, 0, 0, 2, $_SESSION["usuario"], $formpg, $nossonum);
            }

            // Realiza a baixa dos itens no estoque
            $itens = $_pedido->getItens($idpedido);
            if (is_array($itens)) {
                foreach ($itens as $i) {
                    $qtdacum = ($_estoque->getQuantidadeAcumulado($i['id_produto']) - $i['quantidade']);
                    $_estoque->insert($i['id_produto'], 0, $i['quantidade'], $qtdacum, $current_date, 0, 0);
                }
            }

            // Registra nos logs
            $client_data = $_cliente->get($pedido['id_cliente']);
            $client_name = $client_data ? $client_data['nome'] : 'Consumidor Final';
            $log_msg = $_SESSION["nome_usuario"] . " - MOBILE PDV - CADASTROU PEDIDO: " . $pedido['numero_pedido'] . " | CLIENTE: " . $client_name . " | VALOR: R$ " . number_format($total, 2, ",", ".");
            $_logs->salvaLog($log_msg);

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Falha ao processar checkout.']);
        }
        break;

    case 'get_sales_report':
        $today = date('Y-m-d');
        $sql = "SELECT p.id, p.numero_pedido, p.valor, p.data_pedido, c.nome as cliente_nome, f.descricao as pagamento_nome
                FROM tblpedido p 
                LEFT JOIN tblcliente c ON c.id = p.id_cliente
                LEFT JOIN tblformapagamento f ON f.id = p.id_formapag
                WHERE p.status_pedido = 2 AND p.data_pedido = ?
                ORDER BY p.id DESC";
        $rs = $dbase->query($sql, [$today]);
        $sales = [];
        $total_sum = 0;
        if ($rs) {
            while (!$rs->EOF) {
                $val = floatval($rs->fields['valor']);
                $sales[] = [
                    'id' => intval($rs->fields['id']),
                    'numero' => intval($rs->fields['numero_pedido']),
                    'valor' => $val,
                    'cliente' => $rs->fields['cliente_nome'] ?? 'Consumidor Final',
                    'pagamento' => $rs->fields['pagamento_nome'] ?? 'Não especificado'
                ];
                $total_sum += $val;
                $rs->moveNext();
            }
        }
        echo json_encode([
            'success' => true,
            'sales' => $sales,
            'total_sum' => $total_sum
        ]);
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Ação inválida.']);
        break;
}
?>
