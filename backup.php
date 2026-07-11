<?php

$usuario 	= "root";
$senha 		= "";
$dbname 	= "controlestoque";
$host       = "localhost";
// use true se quiser remover caracteres que não sejam utf-8
$checkUtf = false;

// conectando ao banco usando mysqli
$mysqli = new mysqli($host, $usuario, $senha, $dbname);
if ($mysqli->connect_errno) {
    die("Falha na conexão com MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

// Definindo cabeçalho para download do arquivo
$arquivo = $dbname . ".sql";
header('Content-Type: application/sql; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $arquivo);
header('Pragma: no-cache');
header('Expires: 0');

// desabilita checagem de chave estrangeira para evitar erros
echo "SET foreign_key_checks=0;\n\n";

// regex para ver se o char é UTF-8
// Link: http://stackoverflow.com/questions/1401317/remove-non-utf8-characters-from-string
$regex1 = <<<'END'
/
  ( [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
  | [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
  | [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
  | [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
  )
| .                             # anything else
/x
END;

// listando todas as tabelas do banco
$res = $mysqli->query("SHOW TABLES FROM `$dbname`");
if (!$res) {
    die("Erro ao listar tabelas: " . $mysqli->error);
}

while ($row = $res->fetch_array()) {
    $table = $row[0];

    // obtendo comando de criação da tabela
    $res2 = $mysqli->query("SHOW CREATE TABLE `$table`");
    if (!$res2) {
        die("Erro ao obter criação da tabela $table: " . $mysqli->error);
    }
    $lin = $res2->fetch_array();

    echo "\n#\n# Criação da Tabela : $table\n#\n\n";
    echo $lin[1] . " ;\n\n#\n# Dados a serem incluídos na tabela\n#\n\n";

    // selecionando todos os dados da tabela
    $res3 = $mysqli->query("SELECT * FROM `$table`");
    if (!$res3) {
        die("Erro ao selecionar dados da tabela $table: " . $mysqli->error);
    }

    $first = true;
    $sql = "";
    while ($r = $res3->fetch_row()) {
        if ($first) {
            $sql = "INSERT INTO `$table` VALUES ";
            $first = false;
        } else {
            $sql .= ",";
        }

        $values = [];
        foreach ($r as $reg) {
            if ($checkUtf) {
                $escaped = str_replace("'", "\\'", str_replace("\\", "\\\\", preg_replace($regex1, '$1', $reg)));
            } else {
                $escaped = str_replace("'", "\\'", str_replace("\\", "\\\\", $reg));
            }
            $values[] = "'" . $escaped . "'";
        }
        $sql .= "(" . implode(", ", $values) . ")";
    }
    if (!$first) {
        $sql .= ";\n";
        echo $sql;
    }
}

$mysqli->close();


