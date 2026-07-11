<?php
class cotacao {

    var $erro;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // obtem informacoes de tal registro
    public function get($id) {
        $id = intval($id);
        $sql = "select * from tblcotacao where id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (count($rs->fields) > 1) {
            return array(
                'id' =>$rs->fields['id'] ,
                'id_fornecedor' =>$rs->fields['id_fornecedor'] ,
                'id_marca' =>$rs->fields['id_marca'] ,
                'id_categoria' =>$rs->fields['id_categoria'] ,
                'id_usuario' =>$rs->fields['id_usuario'] ,
                'codigo' =>$rs->fields['codigo'] ,
                'ipi' =>$rs->fields['ipi'] ,
                'data' =>$rs->fields['data'] ,
                'valor' =>$rs->fields['valor'] ,
                'valor_final' =>$rs->fields['valor_final'],
                'observacoes' =>$rs->fields['observacoes']
            );
        }
        else {
            return FALSE;
        }
    }

    public function getUltimaCotacao($tags) {
        $valor = 0;
        $sql = "select valor_final from tblcotacao where codigo in (?) order by id desc limit 1";
        $rs = $this->db->query($sql, array($tags));
        if ($rs->fields['valor_final'] > 0) {
            $valor = $rs->fields['valor_final'];
        }
        return $valor;
    }

    public function getDadosUltimaCotacao($codigo) {
        $sql = "select * from tblcotacao where codigo = ? order by id desc limit 1";
        $rs = $this->db->query($sql, array($codigo));
        if (count($rs->fields) > 1) {
            return array(
                'id' =>$rs->fields['id'] ,
                'id_fornecedor' =>$rs->fields['id_fornecedor'] ,
                'id_marca' =>$rs->fields['id_marca'] ,
                'id_categoria' =>$rs->fields['id_categoria'] ,
                'id_usuario' =>$rs->fields['id_usuario'] ,
                'codigo' =>$rs->fields['codigo'] ,
                'ipi' =>$rs->fields['ipi'] ,
                'data' =>$rs->fields['data'] ,
                'valor' =>$rs->fields['valor'] ,
                'valor_final' =>$rs->fields['valor_final'],
                'observacoes' =>$rs->fields['observacoes']
            );
        }
        else {
            return FALSE;
        }
    }

    // obtem quantidade total de registros
    public function countRec($where) {
        $sql ="select count(id) as total FROM tblcotacao $where";
        $dados = $this->db->query($sql);
        $total = 0;
        if ($dados->_numOfRows > 0) {
            $total += $dados->fields["total"];
        }
        return $total;
    }

    // obtem informacoes de registros de acordo com as regras, $where ( usar WHERE xx = xx );
    // usar WHERE blablabla = blablabla
    // $limit usar LIMIT desde,quantos registros.bloquote>

    public function getList($where='',$limite='',$orderby='') {
        $sql = "select * from tblcotacao $where $orderby $limite";
        $rs = $this->db->query($sql);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'id' =>$rs->fields['id'] ,
                'id_fornecedor' =>$rs->fields['id_fornecedor'] ,
                'id_marca' =>$rs->fields['id_marca'] ,
                'id_categoria' =>$rs->fields['id_categoria'] ,
                'id_usuario' =>$rs->fields['id_usuario'] ,
                'codigo' =>$rs->fields['codigo'] ,
                'ipi' =>$rs->fields['ipi'] ,
                'data' =>$rs->fields['data'] ,
                'valor' =>$rs->fields['valor'] ,
                'valor_final' =>$rs->fields['valor_final'],
                'observacoes' =>$rs->fields['observacoes']
            );
            $rs->movenext();
        }
        return $lista;
    }

    // insere registro no banco de dados.
    public function insert($id_fornecedor,$id_marca,$id_categoria,$id_usuario,$codigo,$ipi,$data,$valor,$valor_final,$observacoes) {
        $sql = "INSERT INTO tblcotacao ( id_fornecedor,id_marca,id_categoria,id_usuario,codigo,ipi,data,valor,valor_final,observacoes ) VALUES ( ?,?,?,?,?,?,?,?,?,? )";
        $params = array(
            intval($id_fornecedor),
            intval($id_marca),
            intval($id_categoria),
            intval($id_usuario),
            $codigo,
            $ipi,
            $data,
            $valor,
            $valor_final,
            $observacoes
        );
        $insere = $this->db->Execute($sql, $params);

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    // altera registro
    public function update($id,$id_fornecedor,$id_marca,$id_categoria,$id_usuario,$codigo,$ipi,$data,$valor,$valor_final,$observacoes) {
        $id = intval($id);
        $sql = "select count(id) as total from tblcotacao where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Cotação não existe.";
            return false;
        }

        $sql = "UPDATE tblcotacao
            SET id_fornecedor=?,
            id_marca=?,
            id_categoria=?,
            id_usuario=?,
            codigo=?,
            ipi=?,
            data=?,
            valor=?,
            valor_final=?,
            observacoes=?
            WHERE id = ?";
        
        $params = array(
            intval($id_fornecedor),
            intval($id_marca),
            intval($id_categoria),
            intval($id_usuario),
            $codigo,
            $ipi,
            $data,
            $valor,
            $valor_final,
            $observacoes,
            $id
        );

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
        $sql = "select count(id) as total from tblcotacao where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Cotação não existe";
            return false;
        }

        $sql = "delete from tblcotacao where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }
}
?>