<?
class configuracoes {

    var $erro;
    // obtem informacoes de tal registro
    function get($id) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = "select * from configuracoes where id ='".$id."' LIMIT 1";
        $rs = $dbase->query($sql);

        if (count($rs->fields) > 1) {
        return array(

           'id' =>$rs->fields['id'] ,
           'num_atendimento' =>$rs->fields['num_atendimento']

        );

        }
        else return FALSE;

    }

    // obtem quantidade total de registros
    function countRec($where) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql ="select count(id) as total FROM configuracoes $where";

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

        $sql = " select * from configuracoes $where $orderby $limite";
        $rs = $dbase->query($sql);

        $count = 0;
        while(!$rs->EOF) {
        $count++;
        $lista[$count] = array(

            'id' =>$rs->fields['id'] ,
            'num_atendimento' =>$rs->fields['num_atendimento']
 
        );
        $rs->movenext();
        }
        return $lista;

    }

    // insere registro no banco de dados.
    function insert($num_atendimento) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Gera o código SQL
        $sql = "INSERT INTO configuracoes ( num_atendimento ) VALUES ( '$num_atendimento' )";

        // Executa o código SQL
        $insere = $dbase->Execute($sql);

        // Define o erro, caso exista
        if ($insere === false) echo $this->erro = $dbase->ErrorMsg();
        return $insere;

    }

    // altera registro
    function update($id,$num_atendimento) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Verifica se existe alguma cidade com o DDD cadastrado
        $sql = "select count(id) as total from configuracoes where id=$id ";
        $rs = $dbase->query($sql);
        // Se o total for acima de zero, não é possível efetuar a inserção
        if ($rs->fields['total'] == 0) {
        $this->erro = "não existe.";
        return false;
        }

        // Gera o código SQL
        $sql = "UPDATE configuracoes SET num_atendimento = '$num_atendimento' WHERE id ='$id'";

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
        $sql = "select count(id) as total from configuracoes where id=$id";
        $rs = $dbase->query($sql);
        // Se o total for igual a zero, não é possível efetuar a exclusão
        if ($rs->fields['total'] == 0) {
        $this->erro = "não existe";
        return false;
        }
        $sql = "delete from configuracoes where id=$id";

        // Executa o código SQL
        $delete = $dbase->Execute($sql);

        // Define o erro, caso exista
        if ($delete === false) $this->erro = $dbase->ErrorMsg();

        return $delete;

    }

}
?>