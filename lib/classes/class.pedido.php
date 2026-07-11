<?php
class pedido
{

    var $erro;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // obtem informacoes de tal registro
    public function get($id)
    {
        $id = intval($id);
        $sql = "select * from tblpedido where id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return array(
                'id' => $rs->fields['id'],
                'id_cliente' => $rs->fields['id_cliente'],
                'numero_pedido' => $rs->fields['numero_pedido'],
                'num_parc' => $rs->fields['num_parc'],
                'data_pedido' => $rs->fields['data_pedido'],
                'valor_custo' => $rs->fields['valor_custo'],
                'valor_venda' => $rs->fields['valor_venda'],
                'valor' => $rs->fields['valor'],
                'status_pedido' => $rs->fields['status_pedido'],
                'observacao' => $rs->fields['observacao'],
                'id_usuario' => $rs->fields['id_usuario']
            );
        } else {
            return FALSE;
        }
    }

    public function getPedido($id)
    { // id do clientre
        $id = intval($id);
        $sql = "select * from tblpedido where id_cliente = ? and status_pedido = 1 ORDER BY id DESC LIMIT 1";
        $rs = $this->db->query($sql, array($id));
        if (!$rs->EOF) {
            return array(
                'id' => $rs->fields['id'],
                'id_cliente' => $rs->fields['id_cliente'],
                'numero_pedido' => $rs->fields['numero_pedido'],
                'data_pedido' => $rs->fields['data_pedido'],
                'valor_custo' => $rs->fields['valor_custo'],
                'valor_venda' => $rs->fields['valor_venda'],
                'valor' => $rs->fields['valor'],
                'status_pedido' => $rs->fields['status_pedido'],
                'observacao' => $rs->fields['observacao']
            );
        } else {
            return FALSE;
        }
    }

    public function getFormasPagamento()
    {
        $sql = "select * from tblformapagamento where 1 = 1 order by descricao";
        $rs = $this->db->query($sql);

        $lista = array();
        while (!$rs->EOF) {
            $lista[] = array(
                'id' => $rs->fields['id'],
                'descricao' => $rs->fields['descricao']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function verificarItem($cdprod, $cdpedido)
    { // passando id do produto e o id do pedido 
        $cdprod = intval($cdprod);
        $cdpedido = intval($cdpedido);
        $sql = "select id from tblitenspedido where id_produto = ? and id_pedido = ?";
        $rs = $this->db->query($sql, array($cdprod, $cdpedido));

        if (!$rs->EOF) {
            return false;
        } else {
            return true;
        }
    }

    public function verificarServico($cdpedido)
    { // id do pedido 
        $cdpedido = intval($cdpedido);
        $sql = "select id from tblservico where id_pedido = ?";
        $rs = $this->db->query($sql, array($cdpedido));

        if (!$rs->EOF) {
            return false;
        } else {
            return true;
        }
    }

    public function verificaEntrada($id)
    {
        $id = intval($id);
        $sql = "select id from tblentrada where id_contrato = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['id'];
        } else {
            return 0;
        }
    }

    public function getUltimoNumeroPedido()
    {
        $sql = "select max(numero_pedido) as numero from tblpedido";
        $rs = $this->db->query($sql);
        $numero = 1;
        if (!$rs->EOF) {
            $numero = $rs->fields['numero'] + 1;
        }
        return $numero;
    }

    // obtem quantidade total de registros
    public function countRec($where)
    {
        $sql = "select count(p.id) as total from tblpedido p ";
        $sql .= "inner join tblcliente c on c.id = p.id_cliente ";
        $sql .= "inner join tblformapagamento fpg on fpg.id = p.id_formapag ";
        $sql .= "$where";
        $dados = $this->db->query($sql);
        return $dados->fields["total"];
    }

    // obtem informacoes de registros de acordo com as regras, $where ( usar WHERE xx = xx );
    // usar WHERE blablabla = blablabla
    // $limit usar LIMIT desde,quantos registros.bloquote>

    public function getList($where = '', $limite = '', $orderby = '')
    {
        $sql = "select p.*, c.nome as cliente, fpg.descricao as forma_pgto from tblpedido p ";
        $sql .= "inner join tblcliente c on c.id = p.id_cliente ";
        $sql .= "inner join tblformapagamento fpg on fpg.id = p.id_formapag ";
        $sql .= "$where $orderby $limite";
        $rs = $this->db->query($sql);

        $lista = array();
        while (!$rs->EOF) {
            $lista[] = array(
                'id' => $rs->fields['id'],
                'id_cliente' => $rs->fields['id_cliente'],
                'forma_pgto' => $rs->fields['forma_pgto'],
                'cliente' => $rs->fields['cliente'],
                'numero_pedido' => $rs->fields['numero_pedido'],
                'data_pedido' => $rs->fields['data_pedido'],
                'valor_custo' => $rs->fields['valor_custo'],
                'valor_venda' => $rs->fields['valor_venda'],
                'valor' => $rs->fields['valor'],
                'status_pedido' => $rs->fields['status_pedido'],
                'observacao' => $rs->fields['observacao']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getItens($idpedido, $codigo = '')
    {
        $idpedido = intval($idpedido);
        $sql = "select i.*, p.nome as produto from tblitenspedido i ";
        $sql .= "inner join tblproduto p on p.id = i.id_produto ";
        $sql .= "where i.id_pedido = ? ";
        $params = array($idpedido);
        if ($codigo) {
            $sql .= "and p.codigo = ? ";
            $params[] = $codigo;
        }
        $sql .= "order by i.id";
        // Debug: Output the SQL query and parameters
        /*
        echo "SQL: " . $sql . "<br>";
        echo "Params: ";
        print_r($params);
        echo "<br>";*/
        $rs = $this->db->query($sql, $params);

        
        $lista = array();
        while (!$rs->EOF) {
            $lista[] = array(
                'id' => $rs->fields['id'],
                'id_produto' => $rs->fields['id_produto'],
                'quantidade' => $rs->fields['quantidade'],
                'valor_unitario_compra' => $rs->fields['valor_unitario_compra'],
                'valor_unitario' => $rs->fields['valor_unitario'],
                'valor_total' => $rs->fields['valor_total'],
                'produto' => $rs->fields['produto']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getItensMaisVendidos($datai, $dataf)
    {
        $sql = "select sum(i.quantidade) as qtd, i.valor_unitario as valor, m.descricao as marca, p.nome as produto  from tblitenspedido i ";
        $sql .= "inner join tblpedido pd on pd.id = i.id_pedido ";
        $sql .= "inner join tblproduto p on p.id = i.id_produto ";
        $sql .= "inner join tblmarca m on m.id = p.id_marca ";
        $sql .= "where 1 = 1 ";
        $params = array();
        if ($datai && $dataf) {
            $sql .= "and pd.data_pedido BETWEEN ? AND ? ";
            $params[] = $datai . " 00:00:00";
            $params[] = $dataf . " 23:59:59";
        } else {
            if ($datai) {
                $sql .= "and pd.data_pedido >= ? ";
                $params[] = $datai . " 00:00:00";
            }
            if ($dataf) {
                $sql .= "and pd.data_pedido <= ? ";
                $params[] = $dataf . " 23:59:59";
            }
        }
        $sql .= " group by i.id_produto order by qtd desc";
        $rs = $this->db->query($sql, $params);

        $lista = array();
        while (!$rs->EOF) {
            $lista[] = array(
                'qtd' => $rs->fields['qtd'],
                'valor' => $rs->fields['valor'],
                'marca' => $rs->fields['marca'],
                'produto' => $rs->fields['produto']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getItem($iditem)
    {
        $iditem = intval($iditem);
        $sql = "select * from tblitenspedido where id = ?";
        $rs = $this->db->query($sql, array($iditem));
        if (!$rs->EOF) {
            return array(
                'id' => $rs->fields['id'],
                'id_produto' => $rs->fields['id_produto'],
                'quantidade' => $rs->fields['quantidade'],
                'valor_unitario_compra' => $rs->fields['valor_unitario_compra'],
                'valor_unitario' => $rs->fields['valor_unitario'],
                'valor_total' => $rs->fields['valor_total']
            );
        } else {
            return false;
        }
    }

    // insere registro no banco de dados.
    public function insert($id_cliente, $numero_pedido, $data_pedido, $valor_custo, $valor_venda, $valor, $status_pedido, $observacao, $id_usuario)
    {
        $sql = "INSERT INTO tblpedido ( id_cliente,numero_pedido,data_pedido,valor_custo,valor_venda,valor,status_pedido,observacao, id_usuario ) VALUES ( ?,?,?,?,?,?,?,?,? )";
        $params = array($id_cliente, $numero_pedido, $data_pedido, $valor_custo, $valor_venda, $valor, $status_pedido, $observacao, $id_usuario);
        /* Debugging: Output the SQL query with parameters replaced for debugging */
        /*
        $interpolated_sql = $sql;
        foreach ($params as $param) {
            $interpolated_sql = preg_replace('/\?/', is_numeric($param) ? $param : "'" . $param . "'", $interpolated_sql, 1);
        }
        echo "Interpolated SQL: " . $interpolated_sql;
        die;
        */
        $insere = $this->db->Execute($sql, $params);

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $this->db->Insert_ID();
    }

    public function insertItem($id_produto, $id_pedido, $quantidade, $valor_unitario_compra, $valor_unitario, $valor_total)
    {
        $sql = "INSERT INTO tblitenspedido ( id_produto,id_pedido,quantidade,valor_unitario_compra,valor_unitario,valor_total ) VALUES ( ?,?,?,?,?,? )";
        $params = array($id_produto, $id_pedido, $quantidade, $valor_unitario_compra, $valor_unitario, $valor_total);
        $insere = $this->db->Execute($sql, $params);

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    public function insertServico($id_pedido, $descricao, $valor)
    {
        $sql = "INSERT INTO tblservico ( id_pedido,descricao,valor ) VALUES ( ?,?,? )";
        $insere = $this->db->Execute($sql, array($id_pedido, $descricao, $valor));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    public function updateServico($id_pedido, $descricao, $valor)
    {
        $id_pedido = intval($id_pedido);
        $sql = "UPDATE tblservico SET descricao = ?, valor = ? WHERE id_pedido = ?";
        $altera = $this->db->Execute($sql, array($descricao, $valor, $id_pedido));

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera;
    }

    // altera registro
    public function update($id, $id_cliente, $numero_pedido, $data_pedido, $primeiro_venc, $num_parc, $id_formapag, $valor_custo, $valor_venda, $valor, $status_pedido, $observacao)
    {
        $id = intval($id);
        $sql = "select count(id) as total from tblpedido where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Pedido não existe.";
            return false;
        }

        $sql = "UPDATE tblpedido SET id_cliente = ?, numero_pedido = ?, data_pedido = ?, primeiro_venc = ?, num_parc = ?, id_formapag = ?, valor_custo = ?, valor_venda = ?, valor = ?, status_pedido = ?, observacao = ? WHERE id = ?";
        $params = array($id_cliente, $numero_pedido, $data_pedido, $primeiro_venc, $num_parc, $id_formapag, $valor_custo, $valor_venda, $valor, $status_pedido, $observacao, $id);
        $altera = $this->db->Execute($sql, $params);

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera;
    }

    public function alterarQuantidade($id, $quantidade, $valor)
    {
        $id = intval($id);
        $sql = "UPDATE tblitenspedido SET quantidade = ?, valor_total = ? WHERE id = ?";
        $altera = $this->db->Execute($sql, array($quantidade, $valor, $id));

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera;
    }

    public function concluirPedido($id, $observacao, $valor, $valor_custo, $valor_venda, $data, $formapag)
    {
        $id = intval($id);
        $sql = "select count(id) as total from tblpedido where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Pedido não existe.";
            return false;
        }

        $sql = "UPDATE tblpedido SET status_pedido = 2, observacao = ?, valor = ?, valor_custo = ?, valor_venda = ?, data_pedido = ?, id_formapag = ? WHERE id = ?";
        $params = array($observacao, $valor, $valor_custo, $valor_venda, $data, $formapag, $id);
        $altera = $this->db->Execute($sql, $params);

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera;
    }

    /*
       Apaga registro
       */
    public function delete($id)
    {
        $id = intval($id);
        $sql = "select count(id) as total from tblpedido where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Pedido não existe";
            return false;
        }

        $sql = "delete from tblpedido where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function deleteItem($id)
    {
        $id = intval($id);
        $sql = "delete from tblitenspedido where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function deleteServico($id)
    {
        $id = intval($id);
        $sql = "delete from tblservico where id_pedido = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function inserirEntrada($id_usuario, $id_pedido, $id_forma_pag, $valor, $vencimento, $valor_pag, $data_pgto, $valor_rec, $multa, $juros, $flgstatus, $recibo)
    {
        $sql = "INSERT INTO tblentrada ( id_usuario,id_pedido,id_forma_pag,valor,vencimento,valor_pag,data_pgto,valor_rec,multa,juros,flgstatus,recibo ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $params = array($id_usuario, $id_pedido, $id_forma_pag, $valor, $vencimento, $valor_pag, $data_pgto, $valor_rec, $multa, $juros, $flgstatus, $recibo);
        $insere = $this->db->Execute($sql, $params);

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    public function alteraEntrada($id, $id_usuario, $id_pedido, $id_forma_pag, $valor, $vencimento, $valor_pag, $data_pgto, $valor_rec, $multa, $juros, $flgstatus, $recibo)
    {
        $id = intval($id);
        $sql = "UPDATE tblentrada SET id_usuario=?, id_pedido=?, id_forma_pag=?, valor=?, vencimento=?, valor_pag=?, data_pgto=?, valor_rec=?, multa=?, juros=?, flgstatus=?, recibo=? WHERE id = ?";
        $params = array($id_usuario, $id_pedido, $id_forma_pag, $valor, $vencimento, $valor_pag, $data_pgto, $valor_rec, $multa, $juros, $flgstatus, $recibo, $id);
        $altera = $this->db->Execute($sql, $params);

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera;
    }

    public function getValorPedido($codigo)
    { // parametro codigo do pedido
        $codigo = intval($codigo);
        $sql = "select sum(valor_total) as total from tblitenspedido where id_pedido = ?";
        $rs = $this->db->query($sql, array($codigo));
        if (!$rs->EOF) {
            return $rs->fields['total'];
        }
        return 0;
    }

    public function getItensPedido($codigo)
    {
        $codigo = intval($codigo);
        $sql = "select ip.*, p.nome as produto from tblitenspedido ip";
        $sql .= " inner join tblproduto p on ip.id_produto = p.id ";
        $sql .= "where ip.id_pedido = ?";
        $rs = $this->db->query($sql, array($codigo));

        $lista = array();
        while (!$rs->EOF) {
            $lista[] = array(
                'id' => $rs->fields['id'],
                'id_produto' => $rs->fields['id_produto'],
                'quantidade' => $rs->fields['quantidade'],
                'valor_unitario' => $rs->fields['valor_unitario'],
                'valor_total' => $rs->fields['valor_total'], 
                'produto' => $rs->fields['produto']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getServico($codigo)
    {
        $codigo = intval($codigo);
        $sql = "select * from tblservico where id_pedido = ?";
        $rs = $this->db->query($sql, array($codigo));

        $lista = array();
        if (!$rs->EOF) {
            $lista = array('id' => $rs->fields['id'], 'descricao' => $rs->fields['descricao'], 'valor' => $rs->fields['valor']);
        }
        return $lista;
    }

    public function getEntrada($cod)
    {
        $cod = intval($cod);
        $sql = "select valor from tblentrada where id_pedido = ?";
        $rs = $this->db->query($sql, array($cod));

        if (!$rs->EOF) {
            return $rs->fields['valor'];
        } else {
            return 0;
        }
    }

    public function getDadosEntrada($id)
    {
        $id = intval($id);
        $sql = "select * from tblentrada where id_pedido = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return array(
                'id' => $rs->fields['id'],
                'id_usuario' => $rs->fields['id_usuario'],
                'id_forma_pag' => $rs->fields['id_forma_pag'],
                'valor' => $rs->fields['valor'],
                'vencimento' => $rs->fields['vencimento'],
                'valor_pag' => $rs->fields['valor_pag'],
                'data_pgto' => $rs->fields['data_pgto'],
                'valor_rec' => $rs->fields['valor_rec'],
                'multa' => $rs->fields['multa'],
                'flgstatus' => $rs->fields['flgstatus'],
                'recibo' => $rs->fields['recibo'],
                'juros' => $rs->fields['juros']
            );
        } else {
            return FALSE;
        }
    }

    public function getIdPedido($id)
    {
        $id = intval($id);
        $sql = "select id_pedido from tblentrada where id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['id_pedido'];
        } else {
            return FALSE;
        }
    }

    public function getDescFormasPag($id)
    {
        $id = intval($id);
        $sql = "select descricao from tblformapagamento where id = ?";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['descricao'];
        } else {
            return "";
        }
    }

    public function updateEntrada($id, $valor_pag, $data_pgto, $recibo, $id_forma_pag, $id_usuario, $flgstatus)
    {
        $id = intval($id);
        $sql = "UPDATE tblentrada SET valor_pag = ?, data_pgto = ?, recibo = ?, id_forma_pag = ?, id_usuario = ?, flgstatus = ? WHERE id = ?";
        $params = array($valor_pag, $data_pgto, $recibo, $id_forma_pag, $id_usuario, $flgstatus, $id);
        $altera = $this->db->Execute($sql, $params);

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera;
    }

    public function updateNumParcela($id, $numParc)
    {
        $id = intval($id);
        $sql = "UPDATE tblpedido SET num_parc = ? WHERE id = ?";
        $altera = $this->db->Execute($sql, array($numParc, $id));

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera;
    }

    public function getFormaPagamento($id)
    {
        $id = intval($id);
        $sql = "select * from tblformapagamento where id = ?";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['descricao'];
        }
    }

    public function getCliente($id)
    {  // id do pedido
        $id = intval($id);
        $sql = "select cli.nome as descricao from tblcliente cli ";
        $sql .= "inner join tblpedido p on p.id_cliente = cli.id ";
        $sql .= "where p.id = ?";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['descricao'];
        }
    }

    public function alterarValorVenda($id, $valor, $valort)
    {
        $id = intval($id);
        $sql = "UPDATE tblitenspedido SET valor_unitario = ?, valor_total = ? WHERE id = ?";
        $altera = $this->db->Execute($sql, array($valor, $valort, $id));

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera;
    }

    public function getClientePdv() {
        $sql = "select id from tblcliente where stativo = 1 and pdv_default = 1 LIMIT 1";
        $rs = $this->db->query($sql);

        if ($rs !== false && !$rs->EOF) {
            return $rs->fields['id'];
        }
        return 5; // Fallback to client ID 5 (Avulso)
    }    
}