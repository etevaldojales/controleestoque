<?
include("config_inicio.php");
require_once($lib.'classes/config.php');
require_once($lib.'classes/class.cotacao.php');

$_util 	= new utilidades;
$_class = new cotacao($dbase);
$id  	= $_POST['id'];

$dados 	= $_class->get($id);

if (count($dados) > 0) {
$xml = "\n";
$xml .= "\n";
$xml .= "<root>\n";
$xml .= "	<dados>\n";
$xml .= "		<id>".$dados['id']."</id>\n";
$xml .= "		<fornecedor>".$dados['id_fornecedor']."</fornecedor>\n";
$xml .= "		<marca>".$dados['id_marca']."</marca>\n";
$xml .= "		<categoria>".$dados['id_categoria']."</categoria>\n";
$xml .= "		<data>".$_util->dataMySql2Php($dados['data'])."</data>\n";
$xml .= "		<codigo>".$dados['codigo']."</codigo>\n";
$xml .= "		<observacao>".$_util->codificaSqlAjax($dados['observacoes'])."</observacao>\n";
$xml .= "		<valor>".number_format($dados['valor'],2,",",".")."</valor>\n";
$xml .= "		<ipi>".$dados['ipi']."</ipi>\n";
$xml .= "		<valorf>".number_format($dados['valor_final'],2,",",".")."</valorf>\n";
$xml .= "	</dados>\n";
$xml .= "</root>\n";
Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
}
?>