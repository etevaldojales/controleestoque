<?php
class secoes {

    var $erro;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // obtem informacoes de tal registro
    public function get($id) {
        $id = intval($id);
        $sql = "select * from secoes where id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (count($rs->fields) > 1) {
            return array(
                'id' =>$rs->fields['id'] ,
                'secao' =>$rs->fields['secao'] ,
                'url' =>$rs->fields['url'] ,
                'icone' =>$rs->fields['icone'] ,
                'posicao' =>$rs->fields['posicao']
            );
        }
        else {
            return FALSE;
        }
    }

    public function verificaSecao($id, $idsecao) {
        $id = intval($id);
        $idsecao = intval($idsecao);
        $sql = "select id from usuarios_subsecoes where id_usuario = ? AND id_secao = ?";
        $rs = $this->db->query($sql, array($id, $idsecao));

        if (count($rs->fields) > 1) {
            return true;
        }
        else {
            return FALSE;
        }
    }

    public function verificaPermissaoExt($id, $idsecao) {
        $id = intval($id);
        $idsecao = intval($idsecao);
        $sql = "select flgCadastrar,flgAlterar,flgExcluir from permissoes where id_usuario = ? AND id_secao = ?";
        $rs = $this->db->query($sql, array($id, $idsecao));

        if (count($rs->fields) > 1) {
            return array('flgCad' =>$rs->fields['flgCadastrar'], 'flgAlt' =>$rs->fields['flgAlterar'], 'flgExc' =>$rs->fields['flgExcluir']);
        }
        else {
            return FALSE;
        }
    }

    // obtem quantidade total de registros
    public function countRec($where) {
        $total = 0;
        $sql ="select count(id) as total FROM secoes $where";
        $dados = $this->db->query($sql);
        if ($dados->_numOfRows > 0) {
            $total += $dados->fields["total"];
        }
        return $total;
    }

    public function getSecoes($where='',$limite='',$orderby='') {
        $sql = " select s.* from secoes s ";
        $sql .= "inner join usuarios_secoes us on us.id_secoes = s.id ";
        $sql .= "inner join usuarios u on u.id_usuario = us.id_usuario ";
        $sql .= "$where group by secao $orderby $limite";
        $rs = $this->db->query($sql);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'id' =>$rs->fields['id'],
                'secao' =>$rs->fields['secao'],
                'icone' =>$rs->fields['icone'] ,
                'url' =>$rs->fields['url']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getSecao($url) {
        $sql = " select id from secoes where url = ?";
        $rs = $this->db->query($sql, array($url));

        if(!$rs->EOF) {
            return $rs->fields['id'];
        }
        else {
            return false;
        }
    }

    public function getSecoesUsuario($cod) {
        $cod = intval($cod);
        $sql = " select s.id, s.secao from secoes s ";
        $sql .= "inner join usuarios_secoes us on us.id_secoes = s.id ";
        $sql .= "inner join usuarios u on u.id_usuario = us.id_usuario ";
        $sql .= "where u.id_usuario = ? group by s.secao order by s.secao";
        $rs = $this->db->query($sql, array($cod));

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'id' =>$rs->fields['id'] ,
                'secao' =>$rs->fields['secao']
            );
            $rs->movenext();
        }
        return $lista;
    }

    public function getSecaoUsuario($cod, $cdsecao) {
        $cod = intval($cod);
        $cdsecao = intval($cdsecao);
        $sql = "select s.id from secoes s ";
        $sql .= "inner join usuarios_secoes us on us.id_secoes = s.id ";
        $sql .= "inner join usuarios u on u.id_usuario = us.id_usuario ";
        $sql .= "where u.id_usuario = ? and s.id = ?";
        $rs = $this->db->query($sql, array($cod, $cdsecao));

        if(!$rs->EOF) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getSubSecaoUsuario($cod, $cdsubsecao) {
        $cod = intval($cod);
        $cdsubsecao = intval($cdsubsecao);
        $sql = "select sb.id from subsecoes sb ";
        $sql .= "inner join usuarios_subsecoes usb on usb.id_subsecao = sb.id ";
        $sql .= "inner join usuarios u on u.id_usuario = usb.id_usuario ";
        $sql .= "where u.id_usuario = ? and sb.id = ?";
        $rs = $this->db->query($sql, array($cod, $cdsubsecao));

        if(!$rs->EOF) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getSecSub($cdusu) {
        $sql = "SELECT s.id AS idsecao, s.secao, sb.id AS idsubsecao, sb.subsecao FROM secoes s ";
        $sql .= "LEFT JOIN subsecoes sb ON sb.id_secao = s.id ";
        $sql .= "WHERE 1 = 1 GROUP BY idsecao, idsubsecao ORDER BY s.posicao, sb.id";
        $rs = $this->db->query($sql);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array(
                'id' =>$rs->fields['idsecao'],
                'secao' =>$rs->fields['secao'],
                'idsub' =>$rs->fields['idsubsecao'],
                'subsecao' =>$rs->fields['subsecao'], 
            );
            $rs->movenext();
        }
        return $lista;
    }

    // insere registro no banco de dados.
    public function insert($secao, $posicao) {
        $sql = "INSERT INTO secoes ( secao,posicao ) VALUES ( ?,? )";
        $insere = $this->db->Execute($sql, array($secao, $posicao));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    public function insertUsuSecao($idusu, $idsecao) {
        $idusu = intval($idusu);
        $idsecao = intval($idsecao);
        $sql = "INSERT INTO usuarios_secoes ( id_usuario,id_secoes ) VALUES ( ?,? )";
        $insere = $this->db->Execute($sql, array($idusu, $idsecao));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    public function insertUsuPermissao($idusu, $idsecao) {
        $idusu = intval($idusu);
        $idsecao = intval($idsecao);
        $sql = "INSERT INTO usuarios_secoes ( id_usuario,id_secoes ) VALUES ( ?,? )";
        $insere = $this->db->Execute($sql, array($idusu, $idsecao));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    // altera registro
    public function update($id, $secao, $posicao) {
        $id = intval($id);
        $sql = "select count(id) as total from secoes where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Seção não existe.";
            return false;
        }

        $sql = "UPDATE secoes SET secao=?, posicao=? WHERE id = ?";
        $altera = $this->db->Execute($sql, array($secao, $posicao, $id));

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
        $sql = "select count(id) as total from secoes where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Seção não existe";
            return false;
        }

        $sql = "delete from secoes where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function deleteUsuSecao($id) {
        $id = intval($id);
        $sql = "delete from usuarios_secoes where id_usuario = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function deleteUsuPermissoes($id) {
        $id = intval($id);
        $sql = "delete from permissoes where id_usuario = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function insertUsuPermissoesExt($codusu, $secao, $flgCad, $flgAlt, $flgExc) {
        $codusu = intval($codusu);
        $secao = intval($secao);
        $sql = "INSERT INTO permissoes (id_usuario,id_secao,flgCadastrar,flgAlterar,flgExcluir) VALUES (?,?,?,?,?)";
        $params = array($codusu, $secao, $flgCad, $flgAlt, $flgExc);
        $insere = $this->db->Execute($sql, $params);

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }

    public function getSubsecoes($where, $ordem) {
        $sql = " select sb.* from subsecoes sb ";
        $sql .= "inner join usuarios_subsecoes us on us.id_subsecao = sb.id ";
        $sql .= "inner join usuarios u on u.id_usuario = us.id_usuario ";
        $sql .= "$where $ordem";
        $rs = $this->db->query($sql);

        $lista = array();
        while(!$rs->EOF) {
            $lista[] = array('url' =>$rs->fields['url'], 'subsecao' =>$rs->fields['subsecao']);
            $rs->movenext();
        }
        return $lista;
    }

    public function deleteUsuSubSecao($id) {
        $id = intval($id);
        $sql = "delete from usuarios_subsecoes where id_usuario = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function insertUsuSubSecao($idusu, $idsecao, $idsubsecao) {
        $idusu = intval($idusu);
        $idsecao = intval($idsecao);
        $idsubsecao = intval($idsubsecao);
        $sql = "INSERT INTO usuarios_subsecoes ( id_usuario,id_secao,id_subsecao ) VALUES ( ?,?,? )";
        $insere = $this->db->Execute($sql, array($idusu, $idsecao, $idsubsecao));

        if ($insere === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $insere;
    }
}
?>