<?php
/*
error_reporting(E_ALL); // Show all errors including notices and deprecated warnings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/



// Session configuration for CSRF persistence (Step 1)
if (session_status() === PHP_SESSION_NONE) {
	// Dynamically calculate the project subfolder path relative to DOCUMENT_ROOT
	$projectRoot = realpath(dirname(__DIR__, 2));
	$docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : null;
	$cookiePath = '/';
	if ($projectRoot && $docRoot && strpos($projectRoot, $docRoot) === 0) {
		$subFolder = substr($projectRoot, strlen($docRoot));
		$subFolder = str_replace('\\', '/', $subFolder);
		$subFolder = trim($subFolder, '/');
		if (!empty($subFolder)) {
			$cookiePath = '/' . $subFolder . '/';
		}
	}

	ini_set('session.cookie_lifetime', 0);
	ini_set('session.cookie_path', $cookiePath);
	ini_set('session.cookie_httponly', 1);
	ini_set('session.cookie_samesite', 'Lax'); // PHP 7.3+	

	// Dynamically generate a session name based on the folder name
	$folderName = $projectRoot ? basename($projectRoot) : 'controleestoque';
	$sessionName = 'SESS_' . strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $folderName));
	session_name($sessionName);
	session_start();
}


$CONF['local'] = "127.0.0.1";
$CONF['user'] = "root";
$CONF['pass'] = "";
$CONF['bd'] = "controlestoque";

if (!isset($lib))
	$lib = "lib/";
require_once($lib . "adodb/adodb.inc.php");
require_once($lib . "classes/class.utilidades.php");
$_util = new utilidades();
$util = $_util;

$dbase = newAdoConnection('mysqli');//conexao real, use $dbase->$conn para o resto
global $dbase;
if (!$dbase->connect($CONF['local'], $CONF['user'], $CONF['pass'], $CONF['bd'])) {
	$lockFile = dirname(__DIR__, 2) . '/setup/install.lock';
	if (!file_exists($lockFile) && strpos($_SERVER['SCRIPT_NAME'], '/setup/') === false) {
		$rootPath = realpath(dirname(__DIR__, 2));
		$scriptPath = realpath(dirname($_SERVER['SCRIPT_FILENAME']));
		$relPath = '';
		if ($rootPath && $scriptPath && strpos($scriptPath, $rootPath) === 0) {
			$subPath = substr($scriptPath, strlen($rootPath));
			$subPath = trim($subPath, DIRECTORY_SEPARATOR);
			if (!empty($subPath)) {
				$parts = explode(DIRECTORY_SEPARATOR, $subPath);
				$relPath = str_repeat('../', count($parts));
			}
		}
		header("Location: " . $relPath . "setup/index.php");
		exit;
	}
	die("Database connection failed: " . $dbase->ErrorMsg());
}
//$dbase->debug = true;
$dbase->execute("SET NAMES 'utf8'");
$dbase->execute("SET CHARACTER SET 'utf8'");
?>