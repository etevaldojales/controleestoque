<?php
class produto
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
        $id = intval($id); // sanitize input

        $sql = "SELECT * FROM tblproduto WHERE id = ? LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            $qtdacumulado = $this->getEstoque($rs->fields['id']);
            return array(
                'id' => $rs->fields['id'],
                'id_categoria' => $rs->fields['id_categoria'],
                'id_marca' => $rs->fields['id_marca'],
                'id_fornecedor' => $rs->fields['id_fornecedor'],
                'nome' => $rs->fields['nome'],
                'valor_compra' => $rs->fields['valor_compra'],
                'valor' => $rs->fields['valor'],
                'codigo' => $rs->fields['codigo'],
                'local_estoque' => $rs->fields['local_estoque'],
                'data_cadastro' => $rs->fields['data_cadastro'],
                'unidade' => $rs->fields['unidade'],
                'qtdacumulado' => $qtdacumulado,
                'imagem' => $rs->fields['imagem'] ?? null
            );
        } else {
            return false;
        }
    }

    public function getBycodigo($ref)
    {
        $sql = "select * from tblproduto where codigo = ? LIMIT 1";
        $rs = $this->db->query($sql, array($ref));

        if (!$rs->EOF) {
            $qtdacumulado = $this->getEstoque($rs->fields['id']);
            return array(
                'id' => $rs->fields['id'],
                'id_categoria' => $rs->fields['id_categoria'],
                'id_marca' => $rs->fields['id_marca'],
                'id_fornecedor' => $rs->fields['id_fornecedor'],
                'nome' => $rs->fields['nome'],
                'valor_compra' => $rs->fields['valor_compra'],
                'valor' => number_format($rs->fields['valor'], 2, ",", "."),
                'codigo' => $rs->fields['codigo'],
                'local_estoque' => $rs->fields['local_estoque'],
                'data_cadastro' => $rs->fields['data_cadastro'],
                'unidade' => $rs->fields['unidade'],
                'qtdacumulado' => $qtdacumulado,
                'imagem' => $rs->fields['imagem'] ?? null
            );
        } else {
            return FALSE;
        }
    }

    public function getEstoque($id)
    {
        $id = intval($id);
        $sql = "select qtdacumulado as qtd from tblestoque where id_produto = ? order by id desc limit 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['qtd'];
        } else {
            return 0;
        }
    }

    public function getEstoqueEntrada($nf, $id)
    {
        $nf = intval($nf);
        $id = intval($id);
        $sql = "select qtdentrada as qtd from tblestoque where num_nf = ? and id_produto = ?";
        $rs = $this->db->query($sql, array($nf, $id));

        if (!$rs->EOF) {
            return $rs->fields['qtd'];
        } else {
            return 0;
        }
    }

    public function getEstoqueMinimo($id)
    {
        $id = intval($id);
        $sql = "select estoque_minimo from tblestoque where id_produto = ? order by  id desc limit 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['estoque_minimo'];
        } else {
            return 0;
        }
    }

    public function getMarca($id)
    {
        $id = intval($id);
        $sql = "select descricao from tblmarca where id = ?";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['descricao'];
        } else {
            return "";
        }
    }

    public function getFornecedor($id)
    {
        $id = intval($id);
        $sql = "select descricao from tblfornecedor where id = ?";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['descricao'];
        } else {
            return "";
        }
    }

    public function verificaRelacionamento($id)
    {
        $id = intval($id);
        $sql = "select id FROM tblitenspedido where id_produto = ? ";
        $rs = $this->db->query($sql, array($id));
        if (!$rs->EOF) {
            return false;
        } else {
            return true;
        }
    }

    // obtem quantidade total de registros
    public function countRec($where = '', $limite = '', $orderby = '')
    {
        $total = 0;
        $sql = "select count(p.id) as total from tblproduto p ";
        $sql .= "inner join tblmarca m on m.id = p.id_marca ";
        $sql .= "inner join tblfornecedor f on f.id = p.id_fornecedor ";
        $sql .= "inner join tblcategoria c on c.id = p.id_categoria ";
        $sql .= "$where $orderby $limite";

        $dados = $this->db->query($sql);
        if ($dados->_numOfRows > 0) {
            $total += $dados->fields["total"];
        }
        return $total;
    }

    public function getResumo()
    {
        $sql = "SELECT distinct(p.id) as id, p.valor_compra as valor FROM tblproduto p ";
        $rs = $this->db->query($sql);

        $lista = array();
        if (!$rs->EOF) {
            while (!$rs->EOF) {
                $lista[] = array(
                    'id' => $rs->fields['id'],
                    'valor' => $rs->fields['valor']
                );
                $rs->movenext();
            }
            return $lista;
        } else {
            return false;
        }
    }

    public function getResumoAcumulado($id)
    {
        $id = intval($id);
        $sql = "SELECT qtdacumulado as qtd FROM tblestoque WHERE id_produto = ? ORDER BY id DESC LIMIT 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['qtd'];
        } else {
            return 0;
        }
    }
    public function verifica($desc)
    {
        $ret = true;
        if ($desc != "") {
            $sql = "select id FROM tblproduto where nome = ?";
            $rs = $this->db->query($sql, array($desc));
            if (!$rs->EOF) { // já existe produto com esse nome cadastrado
                $ret = false;
            } else {
                $ret = true;
            }
        }
        return $ret;
    }

    // obtem informacoes de registros de acordo com as regras, $where ( usar WHERE xx = xx );
    // usar WHERE blablabla = blablabla
    // $limit usar LIMIT desde,quantos registros.bloquote>

    public function getList($where = '', $limite = '', $orderby = ''): array
    {
        $lista = array();
        $sql = "select p.* from tblproduto p ";
        $sql .= "inner join tblmarca m on m.id = p.id_marca ";
        $sql .= "inner join tblfornecedor f on f.id = p.id_fornecedor ";
        $sql .= "inner join tblcategoria c on c.id = p.id_categoria ";
        $sql .= "$where $orderby $limite";
        //echo $sql;die;
        $rs = $this->db->query($sql);

        if (!$rs->EOF) {
            while (!$rs->EOF) {
                $lista[] = array(
                    'id' => $rs->fields['id'],
                    'id_categoria' => $rs->fields['id_categoria'],
                    'id_marca' => $rs->fields['id_marca'],
                    'id_fornecedor' => $rs->fields['id_fornecedor'],
                    'nome' => $rs->fields['nome'],
                    'valor_compra' => $rs->fields['valor_compra'],
                    'valor' => $rs->fields['valor'],
                    'codigo' => $rs->fields['codigo'],
                    'local_estoque' => $rs->fields['local_estoque'],
                    'data_cadastro' => $rs->fields['data_cadastro'],
                    'unidade' => $rs->fields['unidade'],
                    'imagem' => $rs->fields['imagem'] ?? null
                );
                $rs->movenext();
            }
            return $lista;
        } else {
            return $lista;
        }
    }

    public function getListEsp($where = '', $limite = '', $orderby = ''): array
    {
        $lista = array();
        $sql = "select p.* from tblproduto p ";
        $sql .= "inner join tblmarca m on m.id = p.id_marca ";
        $sql .= "inner join tblfornecedor f on f.id = p.id_fornecedor ";
        $sql .= "inner join tblcategoria c on c.id = p.id_categoria ";
        $sql .= "$where $orderby $limite";
        $rs = $this->db->query($sql);

        if (!$rs->EOF) {
            while (!$rs->EOF) {
                $lista[] = array(
                    'id' => $rs->fields['id'],
                    'id_categoria' => $rs->fields['id_categoria'],
                    'id_marca' => $rs->fields['id_marca'],
                    'id_fornecedor' => $rs->fields['id_fornecedor'],
                    'nome' => $rs->fields['nome'],
                    'valor_compra' => $rs->fields['valor_compra'],
                    'valor' => $rs->fields['valor'],
                    'codigo' => $rs->fields['codigo'],
                    'local_estoque' => $rs->fields['local_estoque'],
                    'data_cadastro' => $rs->fields['data_cadastro'],
                    'unidade' => $rs->fields['unidade'],
                    'imagem' => $rs->fields['imagem'] ?? null,
                );
                $rs->movenext();
            }
            return $lista;
        } else {
            return $lista;
        }
    }

    public function getcodigos()
    {
        $sql = "select distinct(codigo) from tblproduto where 1 = 1 order by codigo";
        $rs = $this->db->query($sql);
        $lista = array();
        if (!$rs->EOF) {
            while (!$rs->EOF) {
                $lista[] = '"' . $rs->fields['codigo'] . '"';
                $rs->movenext();
            }
        }
        return $lista;
    }

    // insere registro no banco de dados.
    public function insert($id_fornecedor, $id_marca, $id_categoria, $nome, $valor_compra, $valor, $codigo, $data_cadastro, $local_estoque, $unidade, $imagem)
    {
        try {
            $this->db->BeginTrans();
            $data_cadastro = date_create($data_cadastro);
            $data_cadastro = date_format($data_cadastro, 'Y-m-d');
            $sql = "INSERT INTO tblproduto ( id_fornecedor,id_marca,id_categoria,nome,valor_compra,valor,codigo,data_cadastro,local_estoque,stativo,unidade, imagem ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $params = array($id_fornecedor, $id_marca, $id_categoria, $nome, $valor_compra, $valor, $codigo, $data_cadastro, $local_estoque, 1, $unidade, $imagem);

            $insere = $this->db->Execute($sql, $params);
            
            $insert_id = $this->db->Insert_ID(); // Captura o ID antes do CommitTrans
            
            $this->db->CommitTrans();

            if ($insere === false) {
                $this->erro = $this->db->ErrorMsg();
            } else {
                return $insert_id;
            }

        } catch (Exception $e) {
            $this->erro = $e->getMessage();
            return 0;
        }
    }

    // altera registro
    public function update($id, $id_fornecedor, $id_marca, $id_categoria, $nome, $valor_compra, $valor, $codigo, $local_estoque, $unidade, $imagem = null)
    {
        $id = intval($id);
        $sql = "select count(id) as total from tblproduto where id = ?";
        $rs = $this->db->query($sql, array($id));

        if ($rs->fields['total'] == 0) {
            $this->erro = "Produto não existe.";
            return false;
        }

        $sql = "UPDATE tblproduto SET id_fornecedor=?, id_marca=?, id_categoria=?, nome=?, valor_compra=?, valor=?, local_estoque=?, codigo=?, unidade=? ";
        $params = array($id_fornecedor, $id_marca, $id_categoria, $nome, $valor_compra, $valor, $local_estoque, $codigo, $unidade);

        if ($imagem) {
            $sql .= ", imagem = ? ";
            $params[] = $imagem;
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
        $sql = "update tblproduto set stativo = 0 where id = ?";
        $params = array($id);

        $delete = $this->db->Execute($sql, $params);

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function deleteEstoque($id)
    {
        $id = intval($id);
        $sql = "update tblestoque set stativo = 0 where id_produto = ?";
        $params = array($id);

        $delete = $this->db->Execute($sql, $params);

        if ($delete === false) {
            $this->erro = $this->db->ErrorMsg();
        }
        return $delete;
    }

    public function getListEstoqueMinimo()
    {
        $sql = "SELECT DISTINCT(p.id), p.nome FROM tblproduto p WHERE p.stativo = 1";
        $rs = $this->db->query($sql);
        $dados = array();
        while (!$rs->EOF) {
            $dados[] = array(
                'nome' => $rs->fields['nome'],
                'saldo' => $this->getSaldo($rs->fields['id']),
                'estoque_minimo' => $this->getEstoqueMinimo($rs->fields['id'])
            );
            $rs->movenext();
        }
        return $dados;
    }

    public function getSaldo($id)
    {
        $id = intval($id);
        $sql = "select qtdacumulado as saldo from tblestoque where id_produto = ? order by id desc limit 1";
        $rs = $this->db->query($sql, array($id));

        if (!$rs->EOF) {
            return $rs->fields['saldo'];
        } else {
            return 0;
        }
    }

    public function codigoExiste($codigo)
    {
        $sql = "SELECT id FROM tblproduto WHERE codigo = ? LIMIT 1";
        $rs = $this->db->query($sql, array($codigo));

        if (!$rs->EOF) {
            return true;
        } else {
            return false;
        }
    }
}
