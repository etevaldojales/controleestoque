<?
include("config_inicio.php");
require_once($lib."classes/class.parcela.php");
require_once($lib."classes/class.utilidades.php");
require_once($lib.'classes/class.logs.php');

$_util	 	= new utilidades();
$_class 	= new parcela($dbase); 
$_logs    	= new logs($dbase);

$id			= $_POST["id"];	
$valor		= $_POST["valor"];
$valor		= str_replace(".","",$valor);
$valor		= str_replace(",",".",$valor);
$data		= date("Y/m/d");
$recibo		= $_POST["recibo"];
$formapg	= $_POST["formapag"];
$parcela	= $_class->get($id);
$ret 		= $_class->update($id,$parcela['id_pedido'],$parcela['valor_parcela'],$parcela['vencimento'],$valor,$data,$valor,0,0,2,$_SESSION["usuario"],$recibo,$formapg);
$dados 		= $_class->get($id);
$mensagem 	 = $_SESSION["nome_usuario"]." -  DEU BAIXA NA PARCELA DE VENCIMENTO: ".$_util->dataMySql2Php($dados['vencimento']).", NO VALOR DE: ".number_format($valor,2,",",".").", FORMA DE PAGAMENTO: ".$_class->getFormaPagamento($dados['id_forma_pag']).", CLIENTE: ".$_class->getCliente($dados['id_pedido']);		
$res = $_logs->salvaLog($mensagem); 

$msg = $ret == true ? 1 : 0;
$xml = "\n\n";
$xml .= "<root>\n";
$xml .= "	<retorno>\n";
$xml .= "		<mensagem>".$msg."</mensagem>\n";
$xml .= "		<pedido>".$parcela['id_pedido']."</pedido>\n";
$xml .= "	</retorno>\n";
$xml .= "</root>";
Header("Content-type: application/xml; charset=iso-8859-1");
echo $xml;
?>
