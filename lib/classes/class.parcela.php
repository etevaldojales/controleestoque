<?php
class parcela {

    var $erro;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // obtem informacoes de tal registro
    public function get($id) {
        $id = intval($id);
        $sql = "select * from tblparcela where id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (count($rs->fields) > 1) {
            return array(
                'id' =>$rs->fields['id'] ,
                'id_pedido' =>$rs->fields['id_pedido'] ,
                'id_forma_pag' =>$rs->fields['id_forma_pag'] ,
                'valor_parcela' =>$rs->fields['valor_parcela'] ,
                'vencimento' =>$rs->fields['vencimento'] ,
                'valor_pag' =>$rs->fields['valor_pag'] ,
                'data_pgto' =>$rs->fields['data_pgto'] ,
                'valor_rec' =>$rs->fields['valor_rec'] ,
                'multa' =>$rs->fields['multa'] ,
                'juros' =>$rs->fields['juros'] ,
                'id_usuario' =>$rs->fields['id_usuario'] ,
                'recibo' =>$rs->fields['recibo'] ,
                'nosso_numero' =>$rs->fields['nosso_numero'] ,
                'stEstorno' =>$rs->fields['stEstorno'] ,
                'flgstatus' =>$rs->fields['flgstatus']
            );
        }
        else {
            return FALSE;
        }
    }

    public function getParcela($id_pedido) {
        $id_pedido = intval($id_pedido);
        $sql = "select * from tblparcela where id_pedido = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id_pedido));

        if (count($rs->fields) > 1) {
            return array(
                'id' =>$rs->fields['id'] ,
                'id_pedido' =>$rs->fields['id_pedido'] ,
                'id_forma_pag' =>$rs->fields['id_forma_pag'] ,
                'valor_parcela' =>$rs->fields['valor_parcela'] ,
                'vencimento' =>$rs->fields['vencimento'] ,
                'valor_pag' =>$rs->fields['valor_pag'] ,
                'data_pgto' =>$rs->fields['data_pgto'] ,
                'valor_rec' =>$rs->fields['valor_rec'] ,
                'multa' =>$rs->fields['multa'] ,
                'juros' =>$rs->fields['juros'] ,
                'id_usuario' =>$rs->fields['id_usuario'] ,
                'recibo' =>$rs->fields['recibo'] ,
                'nosso_numero' =>$rs->fields['nosso_numero'] ,
                'stEstorno' =>$rs->fields['stEstorno'] ,
                'flgstatus' =>$rs->fields['flgstatus']
            );
        }
        else {
            return FALSE;
        }
    }

    public function getVenc($id_pedido) {
        $id_pedido = intval($id_pedido);
        $sql = "select day(p.vencimento) as dia, month(p.vencimento) as mes, year(p.vencimento) as ano, p.flgstatus, p.vencimento, p.valor_parcela, p.valor_pag "; 
        $sql .= "from tblparcela p ";
        $sql .= "inner join tblpedido pd on pd.id = p.id_pedido ";
        $sql .= "where p.id_pedido = ? order by p.vencimento";
        $rs = $this->db->query($sql, array($id_pedido));

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'dia' =>$rs->fields['dia'],
                'mes' =>$rs->fields['mes'],
                'ano' =>$rs->fields['ano'],
                'status' =>$rs->fields['flgstatus'],
                'vencimento' =>$rs->fields['vencimento'],
                'valor_pag' =>$rs->fields['valor_pag'] ,
                'valor_parcela' =>$rs->fields['valor_parcela']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getParcVencida($id_pedido,$datai,$dataf) {
        $hoje = date("Y/m/d");
        $id_pedido = intval($id_pedido);
        $sql = "select day(p.vencimento) as dia, month(p.vencimento) as mes, year(p.vencimento) as ano, p.flgstatus, p.vencimento, p.valor_parcela, p.valor_pag "; 
        $sql .= "from tblparcela p ";
        $sql .= "inner join tblpedido pd on pd.id = p.id_pedido ";
        $sql .= "where p.id_pedido = ? and p.vencimento >= ? and p.vencimento < ? and p.vencimento < ? and p.flgstatus = 1 order by p.vencimento";
        $rs = $this->db->query($sql, array($id_pedido, $datai, $dataf, $hoje));

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'dia' =>$rs->fields['dia'],
                'mes' =>$rs->fields['mes'],
                'ano' =>$rs->fields['ano'],
                'status' =>$rs->fields['flgstatus'],
                'vencimento' =>$rs->fields['vencimento'],
                'valor_pag' =>$rs->fields['valor_pag'] ,
                'valor_parcela' =>$rs->fields['valor_parcela']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getParc($id_pedido) {
        $id_pedido = intval($id_pedido);
        $sql = "select day(p.vencimento) as dia, month(p.vencimento) as mes, day(c.data_venda) as dia_venda, month(c.data_venda) as mes_venda from tblparcela p ";
        $sql .= "inner join tblpedido pd on pd.id = p.id_pedido ";
        $sql .= "where p.id_pedido = ? order by p.vencimento";
        $rs = $this->db->query($sql, array($id_pedido));

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'dia' =>$rs->fields['dia'],
                'mes' =>$rs->fields['mes'],
                'dia_venda' =>$rs->fields['dia_venda'],
                'mes_venda' =>$rs->fields['mes_venda']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getRelParc($datai,$dataf) {
        $sql = "select cl.nome, p.valor_parcela, p.vencimento, p.data_pgto, p.valor_pag, p.recibo, fp.descricao as formapg, u.nome as usuario from tblparcela p ";
        $sql .= "inner join tblpedido pd on pd.id = p.id_pedido ";
        $sql .= "inner join tblcliente cl on cl.id = pd.id_cliente ";
        $sql .= "inner join tblformapagamento fp on fp.id = p.id_forma_pag ";
        $sql .= "inner join usuarios u on u.id_usuario = p.id_usuario ";
        $sql .= "where 1 = 1 ";
        $params = array();
        if($datai) {
            $sql .= "and p.data_pgto >= ? ";
            $params[] = $datai;
        }
        if($dataf) {
            $sql .= "and p.data_pgto <= ? ";
            $params[] = $dataf;
        }
        $sql .= "order by p.data_pgto, cl.nome";
        $rs = $this->db->query($sql, $params);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'nome' =>$rs->fields['nome'],
                'usuario' =>$rs->fields['usuario'],
                'valor_parcela' =>$rs->fields['valor_parcela'],
                'valor_pag' =>$rs->fields['valor_pag'],
                'vencimento' =>$rs->fields['vencimento'],
                'data_pgto' =>$rs->fields['data_pgto'],
                'recibo' =>$rs->fields['recibo'],
                'formapg' =>$rs->fields['formapg']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getValorVenc($id_pedido) {
        $id_pedido = intval($id_pedido);
        $sql = "select sum(p.valor_parcela) as total from tblparcela p ";
        $sql .= "inner join tblpedido pd on pd.id = p.id_pedido ";
        $sql .= "where p.id_pedido = ? and p.flgstatus = 1";
        $rs = $this->db->query($sql, array($id_pedido));

        if(!$rs->EOF) {
            return $rs->fields['total'];
        }
        else {
            return 0;
        }
    }

    public function getJurosMulta($dataI,$dataF) {
        $sql = "select sum(juros) as vrJuros, sum(multa) as vrMulta from tblparcela where data_pgto >= ? and data_pgto <= ?";
        $rs = $this->db->query($sql, array($dataI, $dataF));

        if (count($rs->fields) > 1) {
            return array('vrJuros' =>$rs->fields['vrJuros'], 'vrMulta' =>$rs->fields['vrMulta']);
        }
        else {
            return FALSE;
        }
    }

    public function getId($num) { // reorna o id passando o nosso numero
        $sql = "select id from tblparcela where nosso_numero = ? LIMIT 1";
        $rs = $this->db->query($sql, array($num));

        if (count($rs->fields) > 1) {
            return $rs->fields['id'];
        }
        else {
            return 0;
        }
    }

    // obtem quantidade total de registros
    public function countRec($where) {
        $total = 0;
        $sql ="select count(id) as total FROM tblparcela $where";
        $dados = $this->db->query($sql);
        if ($dados->_numOfRows > 0) {
            $total += $dados->fields["total"];
        }
        return $total;
    }

    // obtem informacoes de registros de acordo com as regras, $where ( usar WHERE xx = xx );
    // usar WHERE blablabla = blablabla
    // $limit usar LIMIT desde,quantos registros.bloquote>

    public function getList($where='',$limite='',$orderby='') {
        $sql = "select * from tblparcela $where $orderby $limite";
        $rs = $this->db->query($sql);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'id' =>$rs->fields['id'],
                'id_pedido' =>$rs->fields['id_pedido'],
                'id_forma_pag' =>$rs->fields['id_forma_pag'] ,
                'valor_parcela' =>$rs->fields['valor_parcela'],
                'vencimento' =>$rs->fields['vencimento'],
                'valor_pag' =>$rs->fields['valor_pag'],
                'data_pgto' =>$rs->fields['data_pgto'],
                'valor_rec' =>$rs->fields['valor_rec'],
                'multa' =>$rs->fields['multa'],
                'juros' =>$rs->fields['juros'],
                'id_usuario' =>$rs->fields['id_usuario'],
                'recibo' =>$rs->fields['recibo'] ,
                'nosso_numero' =>$rs->fields['nosso_numero'] ,
                'stEstorno' =>$rs->fields['stEstorno'] ,
                'flgstatus' =>$rs->fields['flgstatus']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getRelRec($dataI,$dataF) {
        $sql = "SELECT p.data_pgto,(SELECT COUNT(*) FROM tblparcela pq WHERE pq.data_pgto >= ? AND pq.data_pgto <= ? AND pq.flgstatus = 2 ";
        $sql .= "AND pq.data_pgto = p.data_pgto) AS qtd, ";
        $sql .= "(SELECT SUM(e.valor) FROM tblentrada e LEFT JOIN tblparcela parc ON parc.id_pedido = e.id_pedido WHERE e.data_pgto >= ? ";
        $sql .= "AND e.data_pgto <= ? AND e.flgstatus = 2  AND e.data_pgto = p.data_pgto) AS vrEntrada, ";
        $sql .= "(SELECT SUM(pv.valor_pag) FROM tblparcela pv WHERE pv.id_forma_pag = 4 AND pv.data_pgto >= ? AND pv.data_pgto <= ? 
				AND pv.flgstatus = 2  AND pv.data_pgto = p.data_pgto) AS vrDinheiro, ";
        $sql .= "(SELECT SUM(pv2.valor_pag) FROM tblparcela pv2 WHERE pv2.id_forma_pag = 1 AND pv2.data_pgto >= ? AND pv2.data_pgto <= ? ";
        $sql .= "AND pv2.flgstatus = 2 AND pv2.data_pgto = p.data_pgto) AS vrBoleto, ";
        $sql .= "(SELECT SUM(pv3.valor_pag) FROM tblparcela pv3 WHERE pv3.id_forma_pag = 2 AND pv3.data_pgto >= ? AND pv3.data_pgto <= ? ";
        $sql .= "AND pv3.flgstatus = 2 AND pv3.data_pgto = p.data_pgto) AS vrCartao, ";
        $sql .= "(SELECT SUM(pv4.valor_pag) FROM tblparcela pv4 WHERE pv4.id_forma_pag = 5 AND pv4.data_pgto >= ? AND pv4.data_pgto <= ? ";
        $sql .= "AND pv4.flgstatus = 2 AND pv4.data_pgto = p.data_pgto) AS vrPagueseguro, ";
        $sql .= "(SELECT SUM(pv5.valor_pag) FROM tblparcela pv5 WHERE pv5.id_forma_pag = 3 AND pv5.data_pgto >= ? AND pv5.data_pgto <= ? ";
        $sql .= "AND pv5.flgstatus = 2 AND pv5.data_pgto = p.data_pgto) AS vrCheque, ";
        $sql .= "(SELECT SUM(pv6.valor_pag) FROM tblparcela pv6 WHERE pv6.id_forma_pag = 6 AND pv6.data_pgto >= ? AND pv6.data_pgto <= ? ";
        $sql .= "AND pv6.flgstatus = 2 AND pv6.data_pgto = p.data_pgto) AS vrDebito ";
        $sql .= "FROM tblparcela p ";
        $sql .= "WHERE p.data_pgto >= ? AND p.data_pgto <= ? AND p.flgstatus = 2 GROUP BY p.data_pgto ORDER BY p.data_pgto";
        
        $params = array($dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF);
        $rs = $this->db->query($sql, $params);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'data_pgto' =>$rs->fields['data_pgto'],
                'qtd' =>$rs->fields['qtd'],
                'vrEntrada' =>$rs->fields['vrEntrada'],
                'vrDinheiro' =>$rs->fields['vrDinheiro'],
                'vrBoleto' =>$rs->fields['vrBoleto'] ,
                'vrCartao' =>$rs->fields['vrCartao'],
                'vrPagueseguro' =>$rs->fields['vrPagueseguro'],
                'vrDebito' =>$rs->fields['vrDebito'],
                'vrCheque' =>$rs->fields['vrCheque']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getRelPrev($dataI,$dataF) {
        $sql = "SELECT p.vencimento, (SELECT COUNT(*) FROM tblparcela pq WHERE pq.vencimento >= ? AND pq.vencimento <= ? ";
        $sql .= "AND pq.flgstatus = 1 AND pq.vencimento = p.vencimento) AS qtd, ";
        $sql .= "(SELECT SUM(e.valor) FROM tblentrada e LEFT JOIN tblparcela parc ON parc.id_pedido = e.id_pedido WHERE e.vencimento >= ? ";
        $sql .= "AND e.vencimento <= ? AND e.flgstatus = 1  AND e.vencimento = p.vencimento) AS vrEntrada, ";
        $sql .= "(SELECT SUM(pv.valor_parcela) FROM tblparcela pv WHERE pv.id_forma_pag = 4 AND pv.vencimento >= ? AND pv.vencimento <= ? ";
        $sql .= "AND pv.flgstatus = 1  AND pv.vencimento = p.vencimento) AS vrDinheiro, ";
        $sql .= "(SELECT SUM(pv2.valor_parcela) FROM tblparcela pv2 WHERE pv2.id_forma_pag = 1 AND pv2.vencimento >= ? AND pv2.vencimento <= ? ";
        $sql .= "AND pv2.flgstatus = 1 AND pv2.vencimento = p.vencimento) AS vrBoleto, ";
        $sql .= "(SELECT SUM(pv3.valor_parcela) FROM tblparcela pv3 WHERE pv3.id_forma_pag = 2 AND pv3.vencimento >= ? AND pv3.vencimento <= ? ";
        $sql .= "AND pv3.flgstatus = 1 AND pv3.vencimento = p.vencimento) AS vrCartao, ";
        $sql .= "(SELECT SUM(pv4.valor_parcela) FROM tblparcela pv4 WHERE pv4.id_forma_pag = 5 AND pv4.vencimento >= ? AND pv4.vencimento <= ? ";
        $sql .= "AND pv4.flgstatus = 1 AND pv4.vencimento = p.vencimento) AS vrPagueseguro, ";
        $sql .= "(SELECT SUM(pv5.valor_parcela) FROM tblparcela pv5 WHERE pv5.id_forma_pag = 3 AND pv5.vencimento >= ? AND pv5.vencimento <= ? ";
        $sql .= "AND pv5.flgstatus = 1 AND pv5.vencimento = p.vencimento) AS vrCheque, ";
        $sql .= "(SELECT SUM(pv6.valor_parcela) FROM tblparcela pv6 WHERE pv6.id_forma_pag = 6 AND pv6.vencimento >= ? AND pv6.vencimento <= ? ";
        $sql .= "AND pv6.flgstatus = 1 AND pv6.vencimento = p.vencimento) AS vrDebito ";
        $sql .= "FROM tblparcela p ";
        $sql .= "WHERE p.vencimento >= ? AND p.vencimento <= ? AND p.flgstatus = 1 GROUP BY p.vencimento ORDER BY p.vencimento";
        
        $params = array($dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF, $dataI, $dataF);
        $rs = $this->db->query($sql, $params);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'vencimento' =>$rs->fields['vencimento'],
                'qtd' =>$rs->fields['qtd'],
                'vrEntrada' =>$rs->fields['vrEntrada'],
                'vrDinheiro' =>$rs->fields['vrDinheiro'],
                'vrBoleto' =>$rs->fields['vrBoleto'] ,
                'vrCartao' =>$rs->fields['vrCartao'],
                'vrPagueseguro' =>$rs->fields['vrPagueseguro'],
                'vrDebito' =>$rs->fields['vrDebito'],
                'vrCheque' =>$rs->fields['vrCheque']
            );
            $rs->movenext();
        }
        return $lista;
    }

    // insere registro no banco de dados.
    public function insert($id_pedido,$valor_parcela,$vencimento,$valor_pag,$data_pgto,$valor_rec,$multa,$juros,$flgstatus,$usu,$formpag,$nosso_numero) {
        $sql = "INSERT INTO tblparcela (id_pedido,valor_parcela,vencimento,valor_pag,data_pgto,valor_rec,multa,juros,flgstatus,id_usuario,id_forma_pag,nosso_numero) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $params = array($id_pedido,$valor_parcela,$vencimento,$valor_pag,$data_pgto,$valor_rec,$multa,$juros,$flgstatus,$usu,$formpag,$nosso_numero);
        $insere = $this->db->Execute($sql, $params);

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    // altera registro
    public function update($id,$id_pedido,$valor_parcela,$vencimento,$valor_pag,$data_pgto,$valor_rec,$multa,$juros,$flgstatus,$usu,$recibo,$formpag) {
        $id = intval($id);
        $sql = "select count(id) as total from tblparcela where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Parcela não existe.";
            return false;
        }

        $sql = "UPDATE tblparcela SET id_pedido=?, id_forma_pag=?, valor_parcela=?, vencimento=?, valor_pag=?, data_pgto=?, valor_rec=?, multa=?, juros=?, id_usuario=?, recibo=?, flgstatus=? WHERE id = ?";
        $params = array($id_pedido,$formpag,$valor_parcela,$vencimento,$valor_pag,$data_pgto,$valor_rec,$multa,$juros,$usu,$recibo,$flgstatus,$id);
        $altera = $this->db->Execute($sql, $params);

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera; 
    }

    public function updateEstorno($id,$vencimento,$usu) {
        $id = intval($id);
        $sql = "UPDATE tblparcela SET vencimento = ?, valor_pag = '0', data_pgto = '', valor_rec = '0', multa = '0', juros = '0', id_usuario = ?, recibo = '', stEstorno = 1, flgstatus = '1' WHERE id = ?";
        $altera = $this->db->Execute($sql, array($vencimento, $usu, $id));

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera; 
    }

    public function updateValor($id,$valor_parcela) {
        $id = intval($id);
        $sql = "UPDATE tblparcela SET valor_parcela = ? WHERE id = ?";
        $altera = $this->db->Execute($sql, array($valor_parcela, $id));

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera; 
    }

    public function updateNossoNumero($id,$nosso_numero) {
        $id = intval($id);
        $sql = "UPDATE tblparcela SET nosso_numero = ? WHERE id = ?";
        $altera = $this->db->Execute($sql, array($nosso_numero, $id));

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera; 
    }

    public function baixaAutomatica($id,$valor_pag,$data_pgto,$valor_rec,$juros,$flgstatus,$usu,$recibo,$formpag) {
        $id = intval($id);
        $sql = "select count(id) as total from tblparcela where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Parcela não existe.";
            return false;
        }

        $sql = "UPDATE tblparcela SET id_forma_pag=?, valor_pag=?, data_pgto=?, valor_rec=?, juros=?, id_usuario=?, recibo=?, flgstatus=? WHERE id = ?";
        $params = array($formpag,$valor_pag,$data_pgto,$valor_rec,$juros,$usu,$recibo,$flgstatus,$id);
        $altera = $this->db->Execute($sql, $params);

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera; 
    }

    /*
    Apaga registro
    */
    public function delete($id) {
        $id = intval($id);
        $sql = "select count(id) as total from tblparcela where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Parcela não existe";
            return false;
        }

        $sql = "delete from tblparcela where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function deleteParcelas($id) { // passando o codigo do contrato
        $id = intval($id);
        $sql = "delete from tblparcela where id_pedido = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function getListaParcRepetida($nn) {
        $sql = "select distinct(p.id),p.id_pedido,p.nosso_numero,c.nome,c.email,t.descricao,p.valor_parcela,p.valor_pag,p.vencimento,p.flgstatus,fp.descricao as formapag ";  
        $sql .= "from tblcliente c ";
        $sql .= "inner join tblturma t on t.id = c.id_turma ";
        $sql .= "inner join tblpedido ct on ct.id_cliente = c.id ";
        $sql .= "inner join tblparcela p on p.id_pedido = ct.id ";
        $sql .= "inner join tblformapagamento fp on fp.id = p.id_forma_pag ";
        $sql .= "where p.nosso_numero = ? ";
        $rs = $this->db->query($sql, array($nn));

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'id_pedido' =>$rs->fields['id_pedido'],
                'nosso_numero' =>$rs->fields['nosso_numero'] ,
                'nome' =>$rs->fields['nome'] ,
                'email' =>$rs->fields['email'] ,
                'descricao' =>$rs->fields['descricao'],
                'valor_parcela' =>$rs->fields['valor_parcela'],
                'valor_pag' =>$rs->fields['valor_pag'],
                'vencimento' =>$rs->fields['vencimento'],
                'formapag' =>$rs->fields['formapag'],
                'flgstatus' =>$rs->fields['flgstatus']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getListaNnumeroRepetido() {
        $sql = "select nosso_numero ";  
        $sql .= "from tblparcela ";
        $sql .= "where nosso_numero > 0 ";
        $sql .= "GROUP BY nosso_numero ";
        $sql .= "HAVING COUNT(nosso_numero) > 1 ";
        $rs = $this->db->query($sql);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'nosso_numero' =>$rs->fields['nosso_numero']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getListaNnumeroRepetido2() {
        $sql = "select nosso_numero ";  
        $sql .= "from tblparcela ";
        $sql .= "where nosso_numero = 0 ";
        $sql .= "GROUP BY nosso_numero ";
        $sql .= "HAVING COUNT(nosso_numero) > 1 ";
        $rs = $this->db->query($sql);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'nosso_numero' =>$rs->fields['nosso_numero']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getUltimoNossoNumero() { // reorna nosso numero + 1
        $sql = "select max(nosso_numero) as numero from tblparcela";
        $rs = $this->db->query($sql);

        if (count($rs->fields) > 1) {
            return $rs->fields['numero'] + 1;
        }
        else {
            return 0;
        }
    }

    public function getListDadosVenc($datai,$dataf) {
        $sql = "select distinct(cli.id), cli.nome, cli.telefone, cli.email, p.id as pedido, p.observacao from tblcliente cli ";
        $sql .= "inner join tblpedido p on p.id_cliente = cli.id ";
        $sql .= "inner join tblparcela pc on pc.id_pedido = p.id ";
        $sql .= "where pc.flgstatus = 1 ";
        $params = array();
        if($datai) {
            $sql .= "and pc.vencimento >= ? ";
            $params[] = $datai;
        }
        if($dataf) {
            $sql .= "and pc.vencimento <= ? ";
            $params[] = $dataf;
        }
        $sql .= "order by cli.nome";
        $rs = $this->db->query($sql, $params);

        $lista = array();
        if(!$rs->EOF) {
            while(!$rs->EOF) {
                $lista[] = array(
                    'id' =>$rs->fields['id'],
                    'pedido' =>$rs->fields['pedido'],
                    'observacao' =>$rs->fields['observacao'],
                    'nome' =>$rs->fields['nome'] ,
                    'telefone' =>$rs->fields['telefone'],
                    'email' =>$rs->fields['email']
                );
                $rs->movenext();
            }
            return $lista;
        }
        else {
            return false;
        }
    }

    public function getFormaPagamento($id) { 
        $id = intval($id);
        $sql = "select * from tblformapagamento where id = ?";
        $rs = $this->db->query($sql, array($id));

        if(!$rs->EOF) {
            return $rs->fields['descricao'];
        }
    }

    public function getCliente($id) {  // id do pedido
        $id = intval($id);
        $sql = "select cli.nome as descricao from tblcliente cli ";
        $sql .= "inner join tblpedido p on p.id_cliente = cli.id ";
        $sql .= "where p.id = ?";
        $rs = $this->db->query($sql, array($id));

        if(!$rs->EOF) {
            return $rs->fields['descricao'];
        }
    }
}