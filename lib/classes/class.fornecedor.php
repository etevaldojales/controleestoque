<?php
class fornecedor {

    var $erro;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // obtem informacoes de tal registro
    public function get($id) {
        $id = intval($id);
        $sql = "select * from tblfornecedor where id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if ($rs === false) {
            $this->erro = $this->db->ErrorMsg();
            return false;
        }

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

    public function getFornecedor($desc) {
        $sql = "select id from tblfornecedor where descricao = ?";
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
        $sql ="select count(id) as total FROM tblfornecedor $where";
        $dados = $this->db->query($sql);
        if ($dados->RecordCount() > 0) {
            $total += $dados->fields["total"];
        }
        return $total;
    }

    public function verifica($desc) {
        $sql ="select id FROM tblfornecedor where descricao = ?";
        $rs = $this->db->query($sql, array($desc));
        if(!$rs->EOF) {
            return false;
        }
        else {
            return true;
        }
    }

    public function verificaRelacionamento($id) {
        $id = intval($id);
        $sql ="select id FROM tblproduto where id_fornecedor = ?";
        $rs = $this->db->query($sql, array($id));
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
        $sql = " select * from tblfornecedor $where $orderby $limite";
        $rs = $this->db->query($sql);

        if ($rs === false) {
            $this->erro = $this->db->ErrorMsg();
            return false;
        }

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'id' =>$rs->fields['id'] ,
                'descricao' =>$rs->fields['descricao']
            );
            $rs->MoveNext();
        }
        return $lista;
    }

    // insere registro no banco de dados.
    public function insert($descricao) {
        $sql = "INSERT INTO tblfornecedor ( descricao, stativo ) VALUES ( ?, 1 )";
        $insere = $this->db->Execute($sql, array($descricao));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    // altera registro
    public function update($id, $descricao) {
        $id = intval($id);
        $sql = "select count(id) as total from tblfornecedor where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Fornecedor não existe.";
            return false;
        }

        $sql = "UPDATE tblfornecedor SET descricao = ? WHERE id = ?";
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
        $sql = "update tblfornecedor set stativo = 0 where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    // obtem todos os registros ativos
    public function getAll() {
        $sql = "select * from tblfornecedor where stativo = 1 order by descricao ASC";
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

