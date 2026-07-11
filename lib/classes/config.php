<?php
/*
error_reporting(E_ALL); // Show all errors including notices and deprecated warnings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/



// Session configuration for CSRF persistence (Step 1)
if (session_status() === PHP_SESSION_NONE) {
	ini_set('session.cookie_lifetime', 0);
	ini_set('session.cookie_path', '/controleestoque/');
	ini_set('session.cookie_httponly', 1);
	ini_set('session.cookie_samesite', 'Lax'); // PHP 7.3+	
	session_name('CONTROLEESTOQUE_SESS');
	session_start();
}

/*
	$CONF[local}= "mysql05.b31.hospedagemdesites.ws";
	$CONF[user} = "b3115";
	$CONF[pass} = "db5rd3m";
	$CONF[bd} 	= "b3115";

	$CONF[local} 	= "localhost";
	$CONF[user} 	= "imarket_controle";
	$CONF[pass} 	= "j1l2s315966";
	$CONF[bd} 		= "imarket_controleestoque";
*/
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
	die("Database connection failed: " . $dbase->ErrorMsg());
}
//$dbase->debug = true;
$dbase->execute("SET NAMES 'utf8'");
$dbase->execute("SET CHARACTER SET 'utf8'");
?>