<?php
class logs {

    var $erro;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // obtem informacoes de tal registro
    public function get($id) {
        $id = intval($id);
        $sql = "select * from logs where id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (count($rs->fields) > 1) {
            return array(
                'id' =>$rs->fields['id'] ,
                'data' =>$rs->fields['data'] ,
                'hora' =>$rs->fields['hora'] ,
                'ip' =>$rs->fields['ip'] ,
                'mensagem' =>$rs->fields['mensagem']
            );
        }
        else {
            return FALSE;
        }
    }

    // obtem quantidade total de registros
    public function countRec($where) {
        $sql ="select count(id) as total FROM logs $where";
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
        $sql = " select * from logs $where $orderby $limite";
        $rs = $this->db->query($sql);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'id' =>$rs->fields['id'] ,
                'data' =>$rs->fields['data'] ,
                'hora' =>$rs->fields['hora'] ,
                'ip' =>$rs->fields['ip'] ,
                'mensagem' =>$rs->fields['mensagem']
            );
            $rs->movenext();
        }
        return $lista;
    }

    // insere registro no banco de dados.
    public function insert($data,$ip,$mensagem) {
        $sql = "INSERT INTO logs ( data,ip,mensagem ) VALUES ( ?,?,? )";
        $insere = $this->db->Execute($sql, array($data, $ip, $mensagem));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    public function salvaLog($mensagem) {
        $ip = $_SERVER['REMOTE_ADDR']; // Salva o IP do visitante
        $data = date('Y-m-d'); // Salva a data e data atual (formato MySQL)
        $hora = date('H:i');

        $sql = "INSERT INTO `logs` VALUES (NULL, ?, ?, ?, ?)";
        $insere = $this->db->Execute($sql, array($data, $hora, $ip, $mensagem));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    // altera registro
    public function update($id,$data,$ip,$mensagem) {
        $id = intval($id);
        $sql = "select count(id) as total from logs where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Log não existe.";
            return false;
        }

        $sql = "UPDATE logs SET data=?, ip=?, mensagem=? WHERE id = ?";
        $altera = $this->db->Execute($sql, array($data, $ip, $mensagem, $id));

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
        $sql = "select count(id) as total from logs where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Log não existe";
            return false;
        }

        $sql = "delete from logs where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }
}
?>