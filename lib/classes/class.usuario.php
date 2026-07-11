<?php
class usuario
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function verificaLogin($login, $senha, $secao = '')
    {
        $login = trim(htmlspecialchars($login, ENT_QUOTES, 'UTF-8'));
        $senha = trim($senha);


        $sql = "SELECT * FROM usuarios WHERE login = ? AND senha = ? AND ativo = 1 LIMIT 1";
        error_log("Executing SQL: $sql with login=$login ans senha=$senha");
        $rs = $this->db->Execute($sql, [$login, $senha]);

        if ($rs && !$rs->EOF) {
            return $rs->fields;
        }
        else {
            return false;
        }
    }

    public function insert($nome, $login, $senha, $email, $telefone, $foto, $ativo, $tipo)
    {
        $sql = "INSERT INTO usuarios (nome, login, senha, email, telefone, foto, ativo, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$nome, $login, $senha, $email, $telefone, $foto, $ativo, $tipo];
        return $this->db->Execute($sql, $params);
    }

    public function countRec($where)
    {
        $total = 0;
        $sql = "SELECT count(id_usuario) as total FROM usuarios $where";
        $dados = $this->db->Execute($sql);
        if ($dados && !$dados->EOF) {
            $total = intval($dados->fields["total"]);
        }
        return $total;
    }

    public function getList($where = '', $limite = '', $orderby = '')
    {
        $sql = "SELECT id_usuario, nome, login, email, telefone, foto, ativo, tipo_usuario FROM usuarios $where $orderby $limite";
        $rs = $this->db->Execute($sql);
        $lista = [];
        if ($rs) {
            while (!$rs->EOF) {
                $lista[] = [
                    'id_usuario' => $rs->fields['id_usuario'],
                    'nome' => $rs->fields['nome'],
                    'login' => $rs->fields['login'],
                    'email' => $rs->fields['email'],
                    'telefone' => $rs->fields['telefone'],
                    'foto' => $rs->fields['foto'],
                    'ativo' => $rs->fields['ativo'],
                    'tipo' => $rs->fields['tipo_usuario']
                ];
                $rs->MoveNext();
            }
        }
        return $lista;
    }

    public function get($id)
    {
        $id = intval($id);
        $sql = "SELECT * FROM usuarios WHERE id_usuario = ? LIMIT 1";
        $rs = $this->db->Execute($sql, [$id]);
        if ($rs && !$rs->EOF) {
            return [
                'id_usuario' => $rs->fields['id_usuario'],
                'nome' => $rs->fields['nome'],
                'login' => $rs->fields['login'],
                'senha' => $rs->fields['senha'],
                'email' => $rs->fields['email'],
                'telefone' => $rs->fields['telefone'],
                'foto' => $rs->fields['foto'],
                'ativo' => $rs->fields['ativo'],
                'tipo' => $rs->fields['tipo_usuario']
            ];
        }
        return false;
    }

    public function update($id, $nome, $login, $senha_hash, $email, $telefone, $foto, $ativo, $tipo)
    {
        $id = intval($id);
        if ($senha_hash != "") {
            $sql = "UPDATE usuarios SET nome = ?, login = ?, senha = ?, email = ?, telefone = ?, foto = ?, ativo = ?, tipo_usuario = ? WHERE id_usuario = ?";
            $params = [$nome, $login, $senha_hash, $email, $telefone, $foto, $ativo, $tipo, $id];
        } else {
            $sql = "UPDATE usuarios SET nome = ?, login = ?, email = ?, telefone = ?, foto = ?, ativo = ?, tipo_usuario = ? WHERE id_usuario = ?";
            $params = [$nome, $login, $email, $telefone, $foto, $ativo, $tipo, $id];
        }
        return $this->db->Execute($sql, $params);
    }

    public function delete($id)
    {
        $id = intval($id);
        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        return $this->db->Execute($sql, [$id]);
    }

    public function verifica($nome)
    {
        $sql = "SELECT id_usuario FROM usuarios WHERE nome = ? LIMIT 1";
        $rs = $this->db->Execute($sql, [$nome]);
        if ($rs && !$rs->EOF) {
            return false;
        }
        return true;
    }
}
