<?php
class empresa
{

    var $erro;
    private $db;

    public function __construct($dbase)
    {
        $this->db = $dbase;
    }

    // obtem informacoes de tal registro
    public function get($id)
    {
        $id = intval($id);
        $sql = "select * from tblempresa where id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return array(
                'id' => $rs->fields['id'],
                'nome' => $rs->fields['nome'],
                'endereco' => $rs->fields['endereco'],
                'telefone' => $rs->fields['telefone'],
                'email' => $rs->fields['email'],
                'logo' => $rs->fields['logo'],
                'qrcode' => $rs->fields['qrcode']
            );
        } else {
            return FALSE;
        }
    }

    public function getEmpresa($desc)
    {
        $sql = "select id from tblempresa where nome = ?";
        $rs = $this->db->query($sql, array($desc));

        if (!$rs->EOF) {
            return $rs->fields['id'];
        } else {
            return FALSE;
        }
    }

    public function getQrcode()
    {
        $sql = "select qrcode from tblempresa where stativo = 1";
        $rs = $this->db->query($sql);

        if (!$rs->EOF) {
            return $rs->fields['qrcode'];
        } else {
            return FALSE;
        }
    }

    // obtem quantidade total de registros
    public function countRec($where)
    {
        $total = 0;
        $sql = "select count(id) as total FROM tblempresa $where";
        $dados = $this->db->query($sql);
        if ($dados && !$dados->EOF) {
            $total += $dados->fields["total"];
        }
        return $total;
    }

    public function verificaCadastro($desc)
    {
        $sql = "select id FROM tblempresa where nome = ?";
        $rs = $this->db->query($sql, array($desc));
        if (!$rs->EOF) {
            return false;
        } else {
            return true;
        }
    }

    // obtem informacoes de registros de acordo com as regras, $where ( usar WHERE xx = xx );
    // usar WHERE blablabla = blablabla
    // $limit usar LIMIT desde,quantos registros.bloquote>

    public function getList($where = '', $limite = '', $orderby = '')
    {
        $sql = "select * from tblempresa $where $orderby $limite";
        $rs = $this->db->query($sql);

        $lista = array();
        if ($rs) {
            while (!$rs->EOF) {
                $lista[] = array(
                    'id' => $rs->fields['id'],
                    'nome' => $rs->fields['nome'],
                    'endereco' => $rs->fields['endereco'],
                    'telefone' => $rs->fields['telefone'],
                    'email' => $rs->fields['email'],
                    'logo' => $rs->fields['logo'],
                    'qrcode' => $rs->fields['qrcode']
                );
                $rs->MoveNext();
            }
        }
        return $lista;
    }

    // insere registro no banco de dados.
    public function insert($nome, $endereco, $email, $telefone, $logo, $qrcode)
    {
        try {
            // sanitiza entradas    
            $nome = trim($nome ?? '');
            $endereco = trim($endereco ?? '');
            $email = trim($email ?? '');
            $telefone = trim($telefone ?? '');
            $logo = trim($logo ?? '');
            $qrcode = trim($qrcode ?? '');
            $status = 1;

            if (!$nome) {
                throw new Exception('O campo nome é obrigatório.');
            }
            if (!$endereco) {
                throw new Exception('O campo endereço é obrigatório.');
            }
            if (!$email) {
                throw new Exception('O campo email é obrigatório.');
            }
            if (!$telefone) {
                throw new Exception('O campo telefone é obrigatório.');
            }

            $sql = "INSERT INTO tblempresa ( nome, endereco, email, telefone, logo, qrcode, stativo ) VALUES ( ?, ?, ?, ?, ?, ?, ? )";
            $params = array($nome, $endereco, $email, $telefone, $logo, $qrcode, $status);
            /*
            echo "SQL Query: " . $sql;
            echo "Parameters: ";
            print_r($params);
            die;*/
            $insere = $this->db->Execute($sql, $params);

            if ($insere === false) {
                $this->erro = $this->db->ErrorMsg();
            }
            return $insere;
        } catch (Exception $e) {
            echo 'Exceção capturada: ', $e->getMessage(), "\n";
        }
        
    }

    // altera registro
    public function update($id, $nome, $endereco, $email, $telefone, $logo, $qrcode)
    {
        $id = intval($id);
        $params = array();
        $sql = "UPDATE tblempresa SET nome=?, endereco = ?, email = ?, telefone = ? ";
        $params[] = $nome;
        $params[] = $endereco;
        $params[] = $email;
        $params[] = $telefone;

        if ($logo) {
            $sql .= ", logo = ? ";
            $params[] = $logo;
        }
        if ($qrcode) {
            $sql .= ", qrcode = ? ";
            $params[] = $qrcode;
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

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
        $sql = "update tblempresa set stativo = 0 where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }
}