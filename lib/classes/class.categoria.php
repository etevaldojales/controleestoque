<?php
class categoria {

    var $erro;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // obtem informacoes de tal registro
    public function get($id) {
        $id = intval($id);
        $sql = "select * from tblcategoria where id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return array(
                'id' =>$rs->fields['id'] ,
                'descricao' =>$rs->fields['descricao']
            );
        }
        else {
            return FALSE;
        }
    }

    public function getCategoria($desc) {
        $sql = "select id from tblcategoria where descricao = ?";
        $rs = $this->db->query($sql, array($desc));

        if (!$rs->EOF) {
            return $rs->fields['id'];
        }
        else {
            return FALSE;
        }
    }

    // obtem quantidade total de registros
    public function countRec($where) {
        $total = 0;
        $sql ="select count(id) as total FROM tblcategoria $where";
        $dados = $this->db->query($sql);
        if ($dados->_numOfRows > 0) {
            $total += $dados->fields["total"];
        }
        return $total;
    }

    public function verifica($id) {
        $id = intval($id);
        $sql = "select p.id as codigo FROM tblproduto p where p.id_categoria = ?";
        $rs = $this->db->query($sql, array($id));
        if(!$rs->EOF) {
            return false;
        }
        else {
            return true;
        }
    }

    public function verificaCadastro($desc) {
        $sql = "select id FROM tblcategoria where descricao = ?";
        $rs = $this->db->query($sql, array($desc));
        if(!$rs->EOF) {
            return false;
        }
        else {
            return true;
        }
    }

    // obtem informacoes de registros de acordo com as regras, $where ( usar WHERE xx = xx );
    // usar WHERE blablabla = blablabla
    // $limit usar LIMIT desde,quantos registros.bloquote>

    public function getList($where='',$limite='',$orderby='') {
        $sql = "select * from tblcategoria $where $orderby $limite";
        $rs = $this->db->query($sql);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'id' =>$rs->fields['id'] ,
                'descricao' =>$rs->fields['descricao']
            );
            $rs->movenext();
        }
        return $lista;
    }

    // insere registro no banco de dados.
    public function insert($descricao) {
        $sql = "INSERT INTO tblcategoria ( descricao, stativo ) VALUES ( ?, 1 )";
        $insere = $this->db->Execute($sql, array($descricao));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    // altera registro
    public function update($id, $descricao) {
         $id = intval($id);
        try {
            $this->db->BeginTrans();

            $this->_update($id, $descricao);

            $this->db->CommitTrans();
            return true;
        } catch (Exception $e) {
            $this->db->RollbackTrans();
            $this->erro = $e->getMessage();
            return false;
        }

    }

    private function _update($id, $descricao) {
        $id = intval($id);
        $sql = "UPDATE tblcategoria SET descricao = ? WHERE id = ?";
        $altera = $this->db->Execute($sql, array($descricao, $id));

        if ($altera === false) {
            throw new Exception($this->db->ErrorMsg());
        }
    }

    /*
    Apaga registro
    */
    public function delete($id) {
        $id = intval($id);
        $sql = "update tblcategoria set stativo = 0 where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function getAll() {
        $sql = "select * from tblcategoria where stativo = 1 order by descricao ASC";
        $rs = $this->db->query($sql);

        $lista = array();
        if ($rs) {
            while (!$rs->EOF) {
                $lista[] = array(
                    'id' => $rs->fields['id'],
                    'descricao' => $rs->fields['descricao']
                );
                $rs->movenext();
            }
        }
        return $lista;
    }
}

