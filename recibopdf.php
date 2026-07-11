<?php
include("config_inicio.php");
require_once($lib."fpdf/fpdf.php");
require_once($lib."classes/class.parcela.php");
require_once($lib."classes/class.pedido.php");
require_once($lib."classes/class.cliente.php");
require_once($lib."classes/class.utilidades.php");

$_class = new parcela($dbase);
$_pedido  = new pedido($dbase);
$_cli 	= new cliente($dbase);
$_util 	= new utilidades();


$parcela 	= $_class->get($_GET['codigo']);
$nparc		= $_GET['numero_parcela'];
$pedido		= $_pedido->get($parcela['id_pedido']);
$cli		= $_cli->get($pedido['id_cliente']);
$forma		= $_pedido->getDescFormasPag($parcela['id_forma_pag']);

$_SESSION["valor_parcela"] = $parcela['valor_pag'];
$_SESSION["cliente"] = $cli['nome'];
$_SESSION["pedido"] = $pedido['numero_pedido'];
$_SESSION["nparcelas"] = $nparc.'/'.$pedido['num_parc'];
$_SESSION["vencimento"] = $_util->dataMySql2Php($parcela['vencimento']);
$_SESSION["forma"] = $forma;
$_SESSION["recibo"] = $parcela['recibo'];

class PDF extends FPDF
{
	//Page header
	public function Header()
	{
		//Title
		$this->SetY(-12.7);
		$this->SetFont('Arial','B',10);
		$texto = utf8_decode("CARINA MULTIMARCAS - PRODUTOS E ACESSÓRIOS");
		$this->Cell(6,5,$texto,0,1,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(6,-4.2,'(85) 3224.7073 / 3264.6302',0,1,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(6,5,'Av. Central, 1821 - Con. Ceará',0,1,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(6,-4.2,'www.lojacarina.com.br',0,1,'C','','www.lojacarina.com.br');
		$this->SetY(0.3);
		$this->SetFont('Arial','B',10);
		$this->Cell(6,5,'RECIBO',0,1,'C');
		$this->SetY(1);
		$this->SetFont('Arial','B',10);
		$this->Cell(9.5,5,'Valor pago: R$ '.number_format($_SESSION["valor_parcela"],2,',','.'),0,1,'C');
		$this->SetY(1.9);
		$this->SetFont('Arial','B',9);
		$this->Cell(0.1,5,'Cliente: ',0,1,'C');
		$this->SetX(-5);
		$this->SetFont('Arial','',9);
		$this->Cell(2.7,-5,utf8_decode($_SESSION["cliente"]),0,1,'R');
		$this->SetX(0.4);
		$this->SetFont('Arial','B',9);
		$this->MultiCell(5,-5.2,utf8_decode('Pedido:'),0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(1.9,5.2,$_SESSION["pedido"],0,1,'R');
		$this->SetX(0.4);
		$this->SetFont('Arial','B',9);
		$this->Cell(4.4,-4,utf8_decode('Parcela:'),0,1,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(1.5,4,$_SESSION["nparcelas"],0,1,'R');
		$this->SetX(0.4);
		$this->SetFont('Arial','B',9);
		$this->Cell(5,-2.7,utf8_decode('Vencimento:'),0,1,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(3.2,2.7,$_SESSION["vencimento"],0,1,'R');
		$this->SetX(0.4);
		$this->SetFont('Arial','B',9);
		$this->Cell(5,-1.5,utf8_decode('Forma:'),0,1,'L');
		$this->SetX(0.4);
		$this->SetFont('Arial','',9);
		$this->Cell(2.6,1.5,utf8_decode($_SESSION["forma"]),0,1,'R');
		$this->SetX(0.4);
		$this->SetFont('Arial','B',9);
		$this->Cell(5,0.5,utf8_decode('Data:'),0,1,'L');
		$this->SetX(0.4);
		$this->SetFont('Arial','',9);
		$this->Cell(2.7,-0.5,date('d/m/Y'),0,1,'R');
		$this->SetX(4);
		$this->SetFont('Arial','B',9);
		$this->Cell(5,0.5,utf8_decode('Nº Recibo:'),0,1,'L');
		$this->SetX(0.4);
		$this->SetFont('Arial','',9);
		$this->Cell(6.5,-0.5,$_SESSION["recibo"],0,1,'R');
		$this->SetY(3.8);
		$this->SetX(0.4);
		$this->SetFont('Arial','I',8.1);
		$this->Cell(0,13.4,utf8_decode('Usuário Loja: '.$_SESSION["nome_usuario"]),0,1,'L');
		$this->SetY(4.7);
		$this->SetX(0.4);
		$this->SetFont('Arial','B',9);
		$this->Cell(0,10,utf8_decode('(  ) Pedido'),0,1,'L');
		$this->SetY(3.7);
		$this->SetX(0.4);
		$this->SetFont('Arial','B',9);
		$this->Cell(9.7,12,utf8_decode('(  ) ___________'),0,1,'C');
		$this->cabecalho();
	}
	// page cabecalho
	public function cabecalho() {
		$this->SetFont('Arial','B',6);
	}
	//Page footer
	public function Footer()
	{
		//Position at 1.5 cm from bottom
	}
}

//Instanciation of inherited class
$arr = array(8,11);
$pdf=new PDF("P","cm",$arr);
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Content-Transfer-Encoding: none');
$pdf->AliasNbPages();
$pdf->AddPage();

// codigo

// linha
$pdf->Output();

function date_dif($date_ini, $date_end) { // v 1.0
	if (strcmp(substr($date_ini, 2, 1 ), "/") == 0) {
		$date_ini = substr($date_ini, 6, 4).substr($date_ini, 2, 4).substr($date_ini, 0, 2);
		$date_end = substr($date_end, 6, 4).substr($date_end, 2, 4).substr($date_end, 0, 2);
	}

	$initial_date = getdate(strtotime($date_ini));
	$final_date = getdate(strtotime($date_end));

	$dif = ($final_date[0] - $initial_date[0]) / 86400;
	return $dif;
}

function formataNumeros($num) {
	if($num > 0) {
		if($num < 10) {
			$num = "0".$num;	
		}
	}
	else {
		$num = "";	
	}
	return $num;
}
