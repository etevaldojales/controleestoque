<?
class contato {

    var $erro;
    // obtem informacoes de tal registro
    function get($id) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = "select * from contato where id ='".$id."' LIMIT 1";
        $rs = $dbase->query($sql);

        if (count($rs->fields) > 1) {
        return array(

            'id' =>$rs->fields['id'] ,
            'idcliente' =>$rs->fields['idcliente'] ,
            'nome' =>$rs->fields['nome'] ,
            'cargo' =>$rs->fields['cargo'] ,
            'telefone' =>$rs->fields['telefone'] ,
            'celular' =>$rs->fields['celular'] ,
            'email' =>$rs->fields['email']

        );

        }
        else return FALSE;

    }

    function getEmpresa($id) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = "select nome, nome_fantasia from cliente where id = $id";
        $rs = $dbase->query($sql);

        if (count($rs->fields) > 1) {
			return array('nome' =>$rs->fields['nome'], 'nome_fantasia' =>$rs->fields['nome_fantasia']);
        }
        else return FALSE;
    }

    // obtem quantidade total de registros
    function countRec($where) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql ="select count(id) as total FROM contato $where";

        $dados = $dbase->query($sql);
        if ($dados->_numOfRows > 0)
        {
        $total += $dados->fields["total"];
        }
        return $total;

    }

    // verifica a existencia de registro
    function verifica($nome) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = "select id FROM contato where nome = '$nome'";
        $dados = $dbase->query($sql);
        if ($dados->_numOfRows > 0)
        {
        	return $dados->fields['id'];
        }
		else {
        	return 0;
		}

    }

    // verifica a existencia de registro
    function verificaUpdate($nome) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = "select id FROM contato where nome like '%$nome%'";
        $dados = $dbase->query($sql);
        if ($dados->_numOfRows > 0)
        {
        	return $dados->fields['id'];
        }
		else {
        	return 0;
		}

    }

    // obtem informacoes de registros de acordo com as regras, $where ( usar WHERE xx = xx );
    // usar WHERE blablabla = blablabla
    // $limit usar LIMIT desde,quantos registros.bloquote>

    function getList($where='',$limite='',$orderby='') {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = "select * from contato $where $orderby $limite";
        $rs = $dbase->query($sql);

        $count = 0;
        while(!$rs->EOF) {
        $count++;
        $lista[$count] = array(

            'id' =>$rs->fields['id'] ,
            'idcliente' =>$rs->fields['idcliente'] ,
            'nome' =>$rs->fields['nome'] ,
            'cargo' =>$rs->fields['cargo'] ,
            'telefone' =>$rs->fields['telefone'] ,
            'celular' =>$rs->fields['celular'] ,
            'email' =>$rs->fields['email']

        );
        $rs->movenext();
        }
        return $lista;

    }

    // insere registro no banco de dados.
    function insert($idcliente,$nome,$cargo,$telefone,$celular,$email) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Gera o código SQL
        $sql = "INSERT INTO contato ( idcliente,nome,cargo,telefone,celular,email ) VALUES ( '$idcliente','$nome','$cargo','$telefone','$celular','$email' )";

        // Executa o código SQL
        $insere = $dbase->Execute($sql);

        // Define o erro, caso exista
        if ($insere === false) $this->erro = $dbase->ErrorMsg();
        return $insere;

    }

    // altera registro
    function update($id,$idcliente,$nome,$cargo,$telefone,$celular,$email) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Verifica se existe alguma cidade com o DDD cadastrado
        $sql = "select count(id) as total from contato where id=$id ";
        $rs = $dbase->query($sql);
        // Se o total for acima de zero, não é possível efetuar a inserção
        if ($rs->fields['total'] == 0) {
        $this->erro = "não existe.";
        return false;
        }

        // Gera o código SQL
        $sql = "UPDATE contato

            SET idcliente='$idcliente',
            nome='$nome',
            cargo='$cargo',
            telefone='$telefone',
            celular='$celular',
            email='$email'

            WHERE id ='$id'";

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
        $sql = "select count(id) as total from contato where id=$id";
        $rs = $dbase->query($sql);

        // Se o total for igual a zero, não é possível efetuar a exclusão
        if ($rs->fields['total'] == 0) {
        $this->erro = "não existe";
        return false;
        }
        $sql = "delete from contato where id=$id";

        // Executa o código SQL
        $delete = $dbase->Execute($sql);

        // Define o erro, caso exista
        if ($delete === false) $this->erro = $dbase->ErrorMsg();

        return $delete;

    }

}
?>