<?
session_start();
$lib = 'lib/';
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.bancos.php');

$_class = new bancos($dbase);

$cod = $_POST["banco"];

$ret = $_class->delete();
$ret = $_class->update($cod);
$msg = $ret == true ? 1 : 0;

$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "	<mensagem>".$msg."</mensagem>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>\n";

Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
?>