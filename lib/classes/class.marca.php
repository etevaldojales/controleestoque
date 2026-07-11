<?php
class marca {

    var $erro;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // obtem informacoes de tal registro
    public function get($id) {
        $id = intval($id);
        $sql = "select * from tblmarca where id = ? and stativo = 1 LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if ($rs && !$rs->EOF) {
            return array(
                'id' => $rs->fields['id'],
                'descricao' => $rs->fields['descricao']
            );
        } else {
            return FALSE;
        }
    }

    // obtem quantidade total de registros
    public function countRec($where) {
        $total = 0;
        $sql = "select count(id) as total FROM tblmarca $where";
        $dados = $this->db->query($sql);
        if ($dados && $dados->_numOfRows > 0) {
            $total += $dados->fields["total"];
        }
        return $total;
    }
	
    public function verifica($desc) {
        $sql = "select id FROM tblmarca where descricao = ? and stativo = 1";
        $rs = $this->db->query($sql, array($desc));
        if ($rs && !$rs->EOF) {
            return false;
        } else {
            return true;
        }
    }

    public function verificaRelacionamento($id) {
        $id = intval($id);
        $sql = "select id FROM tblproduto where id_marca = ? and stativo = 1";
        $rs = $this->db->query($sql, array($id));
        if ($rs && !$rs->EOF) {
            return false;
        } else {
            return true;
        }
    }

    public function getAll() {
        $sql = "select * from tblmarca where stativo = 1 order by descricao";
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

    // obtem informacoes de registros de acordo com as regras, $where ( usar WHERE xx = xx );
    // usar WHERE blablabla = blablabla
    // $limit usar LIMIT desde,quantos registros

    public function getList($where='', $limite='', $orderby='') {
        if (!empty($where)) {
            $sql = "select * from tblmarca $where and stativo = 1 $orderby $limite";
        } else {
            $sql = "select * from tblmarca where stativo = 1 $orderby $limite";
        }
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

    // insere registro no banco de dados.
    public function insert($descricao) {
        $sql = "INSERT INTO tblmarca (descricao, stativo) VALUES (?, 1)";
        $insere = $this->db->Execute($sql, array($descricao));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    // altera registro
    public function update($id, $descricao) {
        $id = intval($id);
        $sql = "select count(id) as total from tblmarca where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs && $rs->fields['total'] == 0) {
            $this->erro = "Marca não existe.";
            return false;
        }

        $sql = "UPDATE tblmarca SET descricao = ? WHERE id = ?";
        $altera = $this->db->Execute($sql, array($descricao, $id));

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
        $sql = "update tblmarca set stativo = 0 where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }
}
?>