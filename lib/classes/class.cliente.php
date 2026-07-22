<?php
class cliente {

    var $erro;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // obtem informacoes de tal registro
    public function get($id) {
        $id = intval($id);
        $sql = "select * from tblcliente where id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if ($rs === false) {
            return FALSE;
        }

        if (!$rs->EOF) {
            return array(
                'id' =>$rs->fields['id'],
                'nome' =>$rs->fields['nome'],
                'telefone' =>$rs->fields['telefone'],
                'email' =>$rs->fields['email'],
                'endereco' =>$rs->fields['endereco'],
                'stativo' =>$rs->fields['stativo']
            );
        }
        else {
            return FALSE;
        }
    }

    public function getSaldo($id) {
        $id = intval($id);
        $sql = "select saldo from tblcredito where id_cliente = ? ORDER BY id DESC LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if ($rs === false) {
            return 0;
        }

        if (!$rs->EOF) {
            return $rs->fields['saldo'];
        }
        else {
            return 0;
        }
    }

    // obtem quantidade total de registros
    public function countRec($where) {
        $total = 0;
        $sql ="select count(id) as total FROM tblcliente $where";
        $dados = $this->db->query($sql);
        if ($dados->_numOfRows > 0) {
            $total += $dados->fields["total"];
        }
        return $total;
    }

    public function verifica($nome) {
        $sql = "select id from tblcliente where nome = ?";
        $dados = $this->db->query($sql, array($nome));
        if ($dados->_numOfRows > 0) {
            return false;
        }
        else {
            return true;
        }
    }

    public function verificaRelacionamento($id) {
        $id = intval($id);
        $sql = "select id from tblpedido where id_cliente = ?";
        $dados = $this->db->query($sql, array($id));
        if ($dados->_numOfRows > 0) {
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
        $sql = " select * from tblcliente $where $orderby $limite";
        $rs = $this->db->query($sql);

        if ($rs === false) {
            return array();
        }

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'id' =>$rs->fields['id'],
                'nome' =>$rs->fields['nome'],
                'telefone' =>$rs->fields['telefone'],
                'email' =>$rs->fields['email'],
                'endereco' =>$rs->fields['endereco'],
                'stativo' =>$rs->fields['stativo']
            );
            $rs->movenext();
        }
        return $lista;
    }

    // insere registro no banco de dados.
    public function insert($nome,$telefone,$email,$endereco,$stativo) {
        $sql = "INSERT INTO tblcliente ( nome,telefone,email,endereco,stativo ) VALUES ( ?,?,?,?,? )";
        $insere = $this->db->Execute($sql, array($nome,$telefone,$email,$endereco,$stativo));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    public function movimentaCredito($id_cliente,$valor,$saldo,$data,$stcredito) {
        $sql = "INSERT INTO tblcredito (id_cliente,valor,saldo,data,stcredito ) VALUES ( ?,?,?,?,?)";
        $insere = $this->db->Execute($sql, array($id_cliente,$valor,$saldo,$data,$stcredito));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    // altera registro
    public function update($id,$nome,$telefone,$email,$endereco,$stativo) {
        $id = intval($id);
        $sql = "select count(id) as total from tblcliente where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Cliente não existe.";
            return false;
        }

        $sql = "UPDATE tblcliente SET nome=?, telefone=?, email=?, endereco=?, stativo=? WHERE id = ?";
        $altera = $this->db->Execute($sql, array($nome,$telefone,$email,$endereco,$stativo,$id));

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
        $sql = "update tblcliente set stativo = 0 where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function getClientePdv() {
        $sql = "select id from tblcliente where stativo = 1 and pdv_default = 1 LIMIT 1";
        $rs = @$this->db->query($sql);

        if ($rs !== false && !$rs->EOF) {
            return $rs->fields['id'];
        }

        // Try to search for a client named "Avulso"
        $sqlAvulso = "select id from tblcliente where nome LIKE 'Avulso%' and stativo = 1 LIMIT 1";
        $rsAvulso = $this->db->query($sqlAvulso);
        if ($rsAvulso !== false && !$rsAvulso->EOF) {
            return $rsAvulso->fields['id'];
        }

        // Try to get any active client
        $sqlFirst = "select id from tblcliente where stativo = 1 LIMIT 1";
        $rsFirst = $this->db->query($sqlFirst);
        if ($rsFirst !== false && !$rsFirst->EOF) {
            return $rsFirst->fields['id'];
        }

        return 1; // Fallback to client ID 1 (Avulso)
    }
    
}