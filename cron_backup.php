<?php
// Set execution path to the project root directory
chdir(__DIR__);

// Set timezone
date_default_timezone_set('America/Fortaleza');

// Suppress session and notice warnings when running via CLI
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
ini_set('display_errors', 0);

// Mock session array to avoid issues with standard configuration scripts
if (!isset($_SESSION)) {
    $_SESSION = array();
}
$_SESSION["usuario"] = 1;
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

$lib = "lib/";
require_once("lib/classes/config.php");
require_once("lib/classes/class.logs.php");

$_log = new logs($dbase);

// Ensure the backups directory exists
$backupDir = __DIR__ . '/backups';
if (!file_exists($backupDir)) {
    if (!mkdir($backupDir, 0777, true)) {
        $msg = "Erro no backup automático: Não foi possível criar o diretório de backups.";
        $_log->salvaLog($msg);
        die($msg . "\n");
    }
}

// Generate filename
$timestamp = date('Y-m-d_H-i-s');
$filename = $backupDir . '/db_backup_' . $timestamp . '.sql';

// Connect to database using mysqli (matching backup.php)
$mysqli = new mysqli($CONF['local'], $CONF['user'], $CONF['pass'], $CONF['bd']);
if ($mysqli->connect_errno) {
    $msg = "Erro no backup automático: Falha na conexão MySQL (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    $_log->salvaLog($msg);
    die($msg . "\n");
}

// Open file for writing
$fileHandle = fopen($filename, 'w');
if (!$fileHandle) {
    $msg = "Erro no backup automático: Não foi possível criar o arquivo de backup local.";
    $_log->salvaLog($msg);
    $mysqli->close();
    die($msg . "\n");
}

// Disable foreign key checks in SQL output
fwrite($fileHandle, "SET foreign_key_checks=0;\n\n");

// List all tables
$res = $mysqli->query("SHOW TABLES FROM `{$CONF['bd']}`");
if (!$res) {
    $msg = "Erro no backup automático ao listar tabelas: " . $mysqli->error;
    $_log->salvaLog($msg);
    fclose($fileHandle);
    $mysqli->close();
    die($msg . "\n");
}

while ($row = $res->fetch_array()) {
    $table = $row[0];
    
    // Get table creation SQL
    $res2 = $mysqli->query("SHOW CREATE TABLE `$table`");
    if (!$res2) {
        $msg = "Erro no backup automático ao obter criação da tabela $table: " . $mysqli->error;
        $_log->salvaLog($msg);
        fclose($fileHandle);
        $mysqli->close();
        die($msg . "\n");
    }
    $lin = $res2->fetch_array();
    
    fwrite($fileHandle, "\n#\n# Criação da Tabela : $table\n#\n\n");
    fwrite($fileHandle, $lin[1] . " ;\n\n#\n# Dados a serem incluídos na tabela\n#\n\n");
    
    // Fetch table rows
    $res3 = $mysqli->query("SELECT * FROM `$table`");
    if (!$res3) {
        $msg = "Erro no backup automático ao obter registros da tabela $table: " . $mysqli->error;
        $_log->salvaLog($msg);
        fclose($fileHandle);
        $mysqli->close();
        die($msg . "\n");
    }
    
    $first = true;
    while ($r = $res3->fetch_row()) {
        if ($first) {
            fwrite($fileHandle, "INSERT INTO `$table` VALUES ");
            $first = false;
        } else {
            fwrite($fileHandle, ",");
        }
        
        $values = [];
        foreach ($r as $reg) {
            if ($reg === null) {
                $values[] = "NULL";
            } else {
                $escaped = str_replace("'", "\\'", str_replace("\\", "\\\\", $reg));
                $values[] = "'" . $escaped . "'";
            }
        }
        fwrite($fileHandle, "(" . implode(", ", $values) . ")");
    }
    if (!$first) {
        fwrite($fileHandle, ";\n");
    }
}

fclose($fileHandle);
$mysqli->close();

// Log success to the database log system
$_log->salvaLog("Backup automático executado com sucesso: db_backup_" . $timestamp . ".sql");
echo "Backup finalizado com sucesso em: " . $filename . "\n";

// Retention Policy: keep only the last 30 backup files
$files = glob($backupDir . '/db_backup_*.sql');
if (count($files) > 30) {
    // Sort files by modified time (oldest first)
    usort($files, function($a, $b) {
        return filemtime($a) - filemtime($b);
    });
    
    $deletedCount = 0;
    while (count($files) > 30) {
        $oldestFile = array_shift($files);
        if (unlink($oldestFile)) {
            $deletedCount++;
        }
    }
    if ($deletedCount > 0) {
        echo "Políticas de Retenção: " . $deletedCount . " backups antigos apagados.\n";
    }
}
?>
