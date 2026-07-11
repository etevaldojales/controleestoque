<?
class uf {

    var $erro;
    // obtem informacoes de tal registro
    function get($id) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = "select * from estado where uf ='".$id."' LIMIT 1";
        $rs = $dbase->query($sql);

        if (count($rs->fields) > 1) {
        return array(

            'uf' =>$rs->fields['uf'] ,
            'estado' =>$rs->fields['estado']

        );

        }
        else return FALSE;

    }

    // obtem quantidade total de registros
    function countRec($where) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql ="select count(uf) as total FROM estado $where";

        $dados = $dbase->query($sql);
        if ($dados->_numOfRows > 0)
        {
        $total += $dados->fields["total"];
        }
        return $total;

    }

    // obtem informacoes de registros de acordo com as regras, $where ( usar WHERE xx = xx );
    // usar WHERE blablabla = blablabla
    // $limit usar LIMIT desde,quantos registros.bloquote>

    function getList($where='',$limite='',$orderby='') {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = " select distinct(uf), estado from estado $where $orderby $limite";
        $rs = $dbase->query($sql);

        $count = 0;
        while(!$rs->EOF) {
        $count++;
        $lista[$count] = array(

            'uf' =>$rs->fields['uf'] ,
            'estado' =>$rs->fields['estado']

        );
        $rs->movenext();
        }
        return $lista;

    }

    // insere registro no banco de dados.
    function insert($uf,$estado) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Gera o código SQL
        $sql = "INSERT INTO estado ( uf,estado ) VALUES ( '$uf','$estado' )";

        // Executa o código SQL
        $insere = $dbase->Execute($sql);

        // Define o erro, caso exista
        if ($insere === false) $this->erro = $dbase->ErrorMsg();
        return $insere;

    }

    // altera registro
    function update($uf,$estado) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Verifica se existe alguma cidade com o DDD cadastrado
        $sql = "select count(uf) as total from estado where uf=$uf ";
        $rs = $dbase->query($sql);
        // Se o total for acima de zero, não é possível efetuar a inserção
        if ($rs->fields['total'] == 0) {
        $this->erro = "não existe.";
        return false;
        }

        // Gera o código SQL
        $sql = "UPDATE estado

            SET uf='$uf',
            estado='$estado'

            WHERE uf ='$uf'";

        // Executa o código SQL
        $altera = $dbase->Execute($sql);
        // Define o erro, caso exista
        if ($altera === false) $this->erro = $dbase->ErrorMsg();
        return $altera; 

    }

    /*
    Apaga registro
    */
    function delete($id) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Verifica se existe alguma cidade com o id
        $sql = "select count(uf) as total from estado where uf=$id";
        $rs = $dbase->query($sql);
        // Se o total for igual a zero, não é possível efetuar a exclusão
        if ($rs->fields['total'] == 0) {
        $this->erro = "não existe";
        return false;
        }
        $sql = "delete from estado where uf=$id";

        // Executa o código SQL
        $delete = $dbase->Execute($sql);

        // Define o erro, caso exista
        if ($delete === false) $this->erro = $dbase->ErrorMsg();

        return $delete;

    }

}
?>