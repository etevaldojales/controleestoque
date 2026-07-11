<?php
class estoque
{

    var $erro;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // obtem informacoes de tal registro
    public function get($id)
    {
        $id = intval($id);
        $sql = "select * from tblestoque where id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return array(
                'id' => $rs->fields['id'],
                'id_produto' => $rs->fields['id_produto'],
                'qtdentrada' => $rs->fields['qtdentrada'],
                'qtdsaida' => $rs->fields['qtdsaida'],
                'estoque_minimo' => $rs->fields['estoque_minimo'],
                'nome' => $rs->fields['nome'],
                'data_cad' => $rs->fields['data'],
                'qtdacumulado' => $rs->fields['qtdacumulado'],
                'num_nf' => $rs->fields['num_nf']
            );
        } else {
            return FALSE;
        }
    }

    // obtem quantidade total de registros
    public function countRec($where)
    {
        $total = 0;
        $sql = "select count(e.id) as total FROM tblestoque e ";
        $sql .= "inner join tblproduto p on p.id = e.id_produto ";
        $sql .= "$where";

        $dados = $this->db->query($sql);
        if ($dados->_numOfRows > 0) {
            $total += $dados->fields["total"];
        }
        return $total;
    }

    // obtem informacoes de registros de acordo com as regras, $where ( usar WHERE xx = xx );
    // usar WHERE blablabla = blablabla
    // $limit usar LIMIT desde,quantos registros.bloquote>

    public function getList($where = '', $limite = '', $orderby = '')
    {
        $sql = "select e.*, p.nome from tblestoque e ";
        $sql .= "inner join tblproduto p on p.id = e.id_produto ";
        $sql .= "$where $orderby $limite";
        $rs = $this->db->query($sql);

        $lista = array();
        while (!$rs->EOF) {
            $lista[] = array(
                'id' => $rs->fields['id'],
                'id_produto' => $rs->fields['id_produto'],
                'qtdentrada' => $rs->fields['qtdentrada'],
                'qtdsaida' => $rs->fields['qtdsaida'],
                'estoque_minimo' => $rs->fields['estoque_minimo'],
                'nome' => $rs->fields['nome'],
                'data_cad' => $rs->fields['data'],
                'qtdacumulado' => $rs->fields['qtdacumulado'],
                'num_nf' => $rs->fields['num_nf']
            );
            $rs->movenext();
        }
        return $lista;
    }

    // insere registro no banco de dados.
    public function insert($id_produto, $qtdentrada, $qtdsaida, $qtdacumulado, $data_cad, $estoque_minimo, $num_nf)
    {
        try {
            $status = 1;
            $estoque_minimo_real = $estoque_minimo > 0 ? $estoque_minimo : $this->getEstoqueMinimo($id_produto);
            $sql = "INSERT INTO tblestoque (id_produto, qtdentrada, qtdsaida, qtdacumulado, data, estoque_minimo, num_nf, stativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $params = array($id_produto, $qtdentrada, $qtdsaida, $qtdacumulado, $data_cad, $estoque_minimo_real, $num_nf, $status);
            /* Debugging: Output the SQL query with parameters replaced for debugging */
            /*
            $interpolated_sql = $sql;
            foreach ($params as $param) {
                $interpolated_sql = preg_replace('/\?/', is_numeric($param) ? $param : "'" . $param . "'", $interpolated_sql, 1);
            }
            echo "Interpolated SQL: " . $interpolated_sql;
            die;*/
            

            $insere = $this->db->Execute($sql, $params);

            return $insere;
        } catch (Exception $e) {
            echo "Erro ao inserir estoque: " . $e->getMessage();
        }
    }

    // altera registro
    public function update($id, $id_produto, $qtdentrada, $qtdsaida, $qtdacumulado, $data_cad, $estoque_minimo, $num_nf)
    {
        $id = intval($id);
        $sql = "select count(id) as total from tblestoque where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Estoque não existe.";
            return false;
        }

        $sql = "UPDATE tblestoque SET id_produto=?, qtdentrada=?, data=?, qtdsaida=?, estoque_minimo=?, qtdacumulado=?, num_nf=? WHERE id = ?";
        $params = array($id_produto, $qtdentrada, $data_cad, $qtdsaida, $estoque_minimo, $qtdacumulado, $num_nf, $id);
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
        $sql = "select count(id) as total from tblestoque where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Estoque não existe";
            return false;
        }
        $sql = "delete from tblestoque where id = ?";
        $delete = $this->db->Execute($sql, array($id));

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function getQuantidadeAcumulado($id)
    {
        $id = intval($id);
        $sql = "select qtdacumulado from tblestoque where id_produto = ? order by id desc limit 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['qtdacumulado'];
        }
        return 0;
    }

    public function getEstoqueMinimo($id)
    {
        $id = intval($id);
        $sql = "select estoque_minimo from tblestoque where id_produto = ? order by id desc limit 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['estoque_minimo'];
        }
        return 0;
    }

    public function updateEstouqeMinimo($id, $estoque_minimo)
    {
        $id = intval($id);
        $sql = "UPDATE tblestoque SET estoque_minimo = ? WHERE id_produto = ?";
        $altera = $this->db->Execute($sql, array($estoque_minimo, $id));

        if ($altera === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $altera;
    }
}