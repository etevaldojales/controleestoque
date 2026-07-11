<?
class evento {

    var $erro;
    // obtem informacoes de tal registro
    function get($id) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = "select * from evento where id ='".$id."' LIMIT 1";
        $rs = $dbase->query($sql);

        if (count($rs->fields) > 1) {
        return array(

            'id' =>$rs->fields['id'] ,
            'titulo' =>$rs->fields['titulo']

        );

        }
        else return FALSE;

    }

    // obtem quantidade total de registros
    function countRec($where) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql ="select count(id) as total FROM evento $where";

        $dados = $dbase->query($sql);
        if ($dados->_numOfRows > 0)
        {
        $total += $dados->fields["total"];
        }
        return $total;

    }

    function countRecFotos($id) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql ="select count(id) as total FROM fotos_evento where id_evento = $id";

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

        $sql = " select * from evento $where $orderby $limite";
        $rs = $dbase->query($sql);

        $count = 0;
        while(!$rs->EOF) {
        $count++;
        $lista[$count] = array(

            'id' =>$rs->fields['id'] ,
            'titulo' =>$rs->fields['titulo']

        );
        $rs->movenext();
        }
        return $lista;

    }


    function getListFotos($where='',$limite='',$orderby='') {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = " select * from fotos_evento $where $orderby $limite";
        $rs = $dbase->query($sql);

        $count = 0;
        while(!$rs->EOF) {
        $count++;
        $lista[$count] = array(
            'id' =>$rs->fields['id'] ,
            'id_evento' =>$rs->fields['id_evento'] ,
            'legenda' =>$rs->fields['legenda'] ,
			'posicao' =>$rs->fields['posicao'] ,
            'foto' =>$rs->fields['foto']
        );
        $rs->movenext();
        }
        return $lista;

    }

    // insere registro no banco de dados.
    function insert($titulo) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Gera o código SQL
        $sql = "INSERT INTO evento ( titulo ) VALUES ( '$titulo' )";

        // Executa o código SQL
        $insere = $dbase->Execute($sql);

        // Define o erro, caso exista
        if ($insere === false) $this->erro = $dbase->ErrorMsg();
        return $dbase->Insert_ID();

    }

    // altera registro
    function update($id,$titulo) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Verifica se existe alguma cidade com o DDD cadastrado
        $sql = "select count(id) as total from evento where id=$id ";
        $rs = $dbase->query($sql);
        // Se o total for acima de zero, não é possível efetuar a inserção
        if ($rs->fields['total'] == 0) {
        $this->erro = "não existe.";
        return false;
        }

        // Gera o código SQL
        $sql = "UPDATE evento

            SET titulo='$titulo'

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
        $sql = "select count(id) as total from evento where id=$id";
        $rs = $dbase->query($sql);
        // Se o total for igual a zero, não é possível efetuar a exclusão
        if ($rs->fields['total'] == 0) {
        $this->erro = "não existe";
        return false;
        }
        $sql = "delete from evento where id=$id";

        // Executa o código SQL
        $delete = $dbase->Execute($sql);

        // Define o erro, caso exista
        if ($delete === false) $this->erro = $dbase->ErrorMsg();

        return $delete;

    }

    function getMaxPosicao($id) { // $id : id_evento

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = " SELECT MAX(posicao) AS maximo FROM fotos_evento WHERE id_evento = $id";
        $rs = $dbase->query($sql);

        if (count($rs->fields) > 1) {
			return $rs->fields['maximo'];
        }
		else {
			return 0;	
		}
    }

    function alterarPosicao($posAnt,$posAtual,$cod,$codev) { // posicao anterior, posicao atual, codigo foto, codigo imovel

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = "SELECT id FROM fotos_evento WHERE posicao = $posAtual AND id_evento = $codev ";
        $rs = $dbase->query($sql);

        if (count($rs->fields) > 1) {
			$id = $rs->fields['id'];
			$sql2 = "UPDATE fotos_evento SET posicao = $posAnt WHERE id = $id AND id_evento = $codev";
			$altera = $dbase->Execute($sql2);			
			$sql3 = "UPDATE fotos_evento SET posicao = $posAtual WHERE id = $cod AND id_evento = $codev";
			$altera = $dbase->Execute($sql3);			
        }
		else {
			$sql2 = "UPDATE fotos_evento SET posicao = $posAtual WHERE id = $cod AND id_evento = $codev";
			$altera = $dbase->Execute($sql2);			
		}
		return true;
    }

    function getPosicao($cod,$codev) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = " select posicao from fotos_evento where id = $cod AND id_evento = $codev";
        $rs = $dbase->query($sql);

        if(!$rs->EOF) {
            return $rs->fields['posicao'];
        }
    }

    function trocaLegenda($id,$legenda) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Gera o código SQL
        $sql = "UPDATE fotos_evento SET legenda = '$legenda' WHERE id ='$id'";

        // Executa o código SQL
        $altera = $dbase->Execute($sql);
        // Define o erro, caso exista
        if ($altera === false) echo $this->erro = $dbase->ErrorMsg();
        return $altera; 

    }

    function getFotos($id) { // id do evento

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = " select * from fotos_evento where id_evento = $id ";
		$sql .= "order by posicao";
        $rs = $dbase->query($sql);

        $count = 0;
        while(!$rs->EOF) {
        $count++;
        $lista[$count] = array(

            'id' =>$rs->fields['id'] ,
            'id_evento' =>$rs->fields['id_evento'] ,
            'legenda' =>$rs->fields['legenda'] ,
			'posicao' =>$rs->fields['posicao'] ,
            'foto' =>$rs->fields['foto']
        );
        $rs->movenext();
        }
        return $lista;

    }

    function deleteFoto($id) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];
        $sql = "delete from fotos_evento where id = $id";
        $delete = $dbase->Execute($sql);
        return $delete;
    }


    function insertFoto($codev,$foto,$legenda,$posicao) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        // Gera o código SQL
        $sql = "INSERT INTO fotos_evento ( id_evento,foto,legenda,posicao ) VALUES ( '$codev','$foto','$legenda' ,'$posicao')";

        // Executa o código SQL
        $insere = $dbase->Execute($sql);

        // Define o erro, caso exista
        if ($insere === false) $this->erro = $dbase->ErrorMsg();
        return $insere;
    }

    function getFotosEsp($id) {

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = " select * from fotos_evento where id = $id";
        $rs = $dbase->query($sql);

        $count = 0;
        while(!$rs->EOF) {
			$lista = array(
	
				'id' =>$rs->fields['id'] ,
				'id_evento' =>$rs->fields['id_evento'] ,
				'legenda' =>$rs->fields['legenda'] ,
				'foto' =>$rs->fields['foto']
			);
        $rs->movenext();
        }
        return $lista;

    }

    function getPrimeiraFoto($id) { //id do evento 

        // Abre a conexo com o banco de dados
        $dbase = $GLOBALS['dbase'];

        $sql = " select * from fotos_evento where id_evento = $id order by posicao limit 1";
        $rs = $dbase->query($sql);

        $count = 0;
        if(!$rs->EOF) {
			$lista = array(
				'id' =>$rs->fields['id'] ,
				'id_evento' =>$rs->fields['id_evento'] ,
				'legenda' =>$rs->fields['legenda'] ,
				'foto' =>$rs->fields['foto']
			);
        }
        return $lista;
    }
}
?>