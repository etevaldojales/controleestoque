<?php
class bancos {

    var $erro;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // obtem informacoes de tal registro
    public function get($id) {
        $id = intval($id);
        $sql = "select * from tblbancos where stselecionado = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (count($rs->fields) > 1) {
            return array(
                'id' =>$rs->fields['id'] ,
                'funcao' =>$rs->fields['funcao'] ,
                'layout' =>$rs->fields['layout'] ,
                'imagem' =>$rs->fields['imagem'] ?? null ,
                'stselecionado' =>$rs->fields['stselecionado']
            );
        }
        else {
            return FALSE;
        }
    }

    // obtem quantidade total de registros
    public function countRec($where) {
        $total = 0;
        $sql ="select count(id) as total FROM tblbancos $where";
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
        $sql = " select * from tblbancos $where $orderby $limite";
        $rs = $this->db->query($sql);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'id' =>$rs->fields['id'] ,
                'funcao' =>$rs->fields['funcao'] ,
                'layout' =>$rs->fields['layout'] ,
                'imagem' =>$rs->fields['imagem'] ?? null ,
                'stselecionado' =>$rs->fields['stselecionado']
            );
            $rs->movenext();
        }
        return $lista;
    }

    // insere registro no banco de dados.
    public function insert($funcao,$layout,$imagem,$stselecionado) {
        $sql = "INSERT INTO tblbancos ( funcao,layout,imagem,stselecionado ) VALUES ( ?,?,?,? )";
        $insere = $this->db->Execute($sql, array($funcao,$layout,$imagem,$stselecionado));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    // altera registro
    public function update($id) {
        $id = intval($id);
        $sql = "select count(id) as total from tblbancos where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Banco não existe.";
            return false;
        }

        $sql = "UPDATE tblbancos SET stselecionado = '1' WHERE id = ?";
        $altera = $this->db->Execute($sql, array($id));

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera; 
    }

    /*
    Apaga registro
    */
    public function delete() {
        $sql = "update tblbancos set stselecionado = 0 where 1 = 1";
        $delete = $this->db->Execute($sql);

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function getSelecionado($id, $idsel) {
        if($id == $idsel) {
            $ret = "checked";
        }
        else {
            $ret = "";
        }
        return $ret;
    }
}
