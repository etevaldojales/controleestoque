<?
class endereco {

    var $erro;
    // obtem informacoes de tal registro
    function get($cep) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = "select * from endereco where cep ='".$cep."' LIMIT 1";
        $rs = $dbase->query($sql);

        if (count($rs->fields) > 1) {
        return array(

            'cep'      =>$rs->fields['cep'] ,
            'endereco' =>$rs->fields['endereco'] ,
            'id_cidade' =>$rs->fields['id_cidade'] ,
            'id_bairro' =>$rs->fields['id_bairro']

        );

        }
        else return FALSE;

    }

    // obtem quantidade total de registros
    function countRec($where) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql ="select count(cep) as total FROM endereco $where";

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

        $sql = " select * from endereco $where $orderby $limite";
        $rs = $dbase->query($sql);

        $count = 0;
        while(!$rs->EOF) {
        $count++;
        $lista[$count] = array(

            'cep'      =>$rs->fields['cep'] ,
            'endereco' =>$rs->fields['endereco'] ,
            'id_cidade' =>$rs->fields['id_cidade'] ,
            'id_bairro' =>$rs->fields['id_bairro']

        );
        $rs->movenext();
        }
        return $lista;

    }

    // insere registro no banco de dados.
    function insert($cep,$endereco,$id_cidade,$id_bairro) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Gera o código SQL
        $sql = "INSERT INTO endereco ( cep,endereco,id_cidade,id_bairro ) VALUES ( '$cep','$endereco','$id_cidade','$id_bairro' )";

        // Executa o código SQL
        $insere = $dbase->Execute($sql);

        // Define o erro, caso exista
        if ($insere === false) $this->erro = $dbase->ErrorMsg();
        return $insere;

    }

    // altera registro
    function update($cep,$endereco,$id_cidade,$id_bairro) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Verifica se existe alguma cidade com o DDD cadastrado
        $sql = "select count(cep) as total from endereco where cep=$cep ";
        $rs = $dbase->query($sql);
        // Se o total for acima de zero, não é possível efetuar a inserção
        if ($rs->fields['total'] == 0) {
        $this->erro = "não existe.";
        return false;
        }

        // Gera o código SQL
        $sql = "UPDATE endereco

            SET endereco='$endereco',
            id_cidade='$id_cidade',
            id_bairro='$id_bairro'

            WHERE cep ='$cep'";

        // Executa o código SQL
        $altera = $dbase->Execute($sql);
        // Define o erro, caso exista
        if ($altera === false) $this->erro = $dbase->ErrorMsg();
        return $altera; 

    }

    /*
    Apaga registro
    */
    function delete($cep) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Verifica se existe alguma cidade com o id
        $sql = "select count(cep) as total from endereco where cep='$cep'";
        $rs = $dbase->query($sql);
        // Se o total for igual a zero, não é possível efetuar a exclusão
        if ($rs->fields['total'] == 0) {
        $this->erro = "não existe";
        return false;
        }
        $sql = "delete from endereco where cep='.$cep.'";

        // Executa o código SQL
        $delete = $dbase->Execute($sql);

        // Define o erro, caso exista
        if ($delete === false) $this->erro = $dbase->ErrorMsg();

        return $delete;

    }

}
?>