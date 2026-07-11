<?php
class utilidades {

	public function unhtmlentities ($string)
	{
		$trans_tbl = get_html_translation_table (HTML_ENTITIES);
		$trans_tbl = array_flip ($trans_tbl);
		return strtr($string, $trans_tbl);
	}
	// função de redimensionamento de imagem.
	public function redimensiona($caminhoOriginal='',$caminhoFinal='',$dimensao='')
	{
		$original = ImageCreateFromJPEG($caminhoOriginal);
		$pontoX = ImagesX($original);
		$pontoY = ImagesY($original);
		
		if ($pontoX >= $dimensao OR $pontoY >= $dimensao) {
			if($pontoX>$pontoY)
			{
				$v_largura = $dimensao;
				$v_altura = ($pontoY * $dimensao)/$pontoX;
			}
			else
			{
				$v_largura = ($pontoX * $dimensao)/$pontoY;
				$v_altura = $dimensao;
			}
		}
		else {
			$v_largura = $pontoX;
			$v_altura = $pontoY;
		}
		$final = ImageCreateTrueColor($v_largura, $v_altura);
		ImageCopyResampled($final, $original, 0, 0, 0, 0, $v_largura+1, $v_altura+1, $pontoX, $pontoY);
		
		ImageJPEG($final, $caminhoFinal, 75);
		
		ImageDestroy($original);
		ImageDestroy($final);
		chmod($caminhoFinal,0777);
	}
	
	public function textotam($texto,$tamanho) {
	if (strlen($texto) > $tamanho) {
			for ($i = $tamanho;$i <= strlen($texto); $i++) {
				if (substr($texto,$i,1) == " ") {
					return substr($texto,0,$i)."...";
				}
			}
			return $texto;
		}
		else {
			return $texto;
		}
	}
	public function pathFix(){
		$current = $_SERVER['PHP_SELF'];
		$arr = explode('/',$current);
		$i=count($arr)-4;
		$out = "";
		for ($z=0;$z<$i;$z++){
			$out .= "../";
		}
		return $out;
	}
		//Parâmetro no formato de DATETIME 2006-06-22 11:17:16 e retorna para o formato PORTUGUÊS-BR
	public function formatadatetime($data) {
		$data = substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4)." ".substr($data,11,2).":".substr($data,14,2).":".substr($data,17,2);
		return $data;
	}

	public function formatadatasql($data) {
	// Parametro de data DD/MM/AAAA HH:MM:SS e converte para formato SQL
		$data = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2)." ".substr($data,11,2).":".substr($data,14,2).":".substr($data,17,2);
		return $data;
	}
	// Pega data do SQL e transforma em formato PT
	public function dataMySql2Php ( $data, $formatador='/' ) {
		$ndata = new DateTime($data);
		return $ndata->format('d/m/Y');
	}
	
	// Pega data do PHP e transforma em formato SQL
	public function dataPhp2MySql ( $data ) {
		if (empty($data)) return '';
		$ndata = DateTime::createFromFormat('d/m/Y', $data);
		if ($ndata) {
			return $ndata->format('Y-m-d');
		}
		try {
			$data_clean = str_replace('/', '-', $data);
			$ndata = new DateTime($data_clean);
			return $ndata->format('Y-m-d');
		} catch (Exception $e) {
			return $data;
		}
	}
	public function codificaAjaxSql($texto) {
		$texto_utf8 = function_exists('mb_convert_encoding') ? mb_convert_encoding($texto, 'UTF-8', 'ISO-8859-1') : utf8_encode($texto);
		return addslashes(html_entity_decode($texto_utf8));
	}
	public function codificaSqlAjax($texto) {
		$texto_iso = function_exists('mb_convert_encoding') ? mb_convert_encoding(html_entity_decode($texto), 'ISO-8859-1', 'UTF-8') : utf8_decode(html_entity_decode($texto));
		return rawurlencode($texto_iso);
	}
	// retorna uma imagem virtual.
	// passar parametros de acordo com os nome
	// lado 0 é horizontal, ou seja, tamanho da imagem vai ser lateral e o vertical será proporcional.
	// usar 1 para vertical
	// tipo 0 é proporcional 
	// tipo 1 é recortado e quadrado
	// tipo 2 é proporcional ao maior tamanho
	// tipo 3 eh tamanho de altura fixo
	public function redirImagem($imagem,$tamanho,$lado,$tipo=0,$corte='300')
	{
	 	$img = ImageCreateFromJpeg($imagem); 
			$wi=ImageSX($img);
			$he=ImageSY($img);
			if ($tipo == '0')
			{
				if ($lado == '0') 
				{ 	$img_wi=$tamanho;
					$img_he=$he * $tamanho / $wi; }
				else if ($lado == '1')
				{ 	$img_he=$tamanho;
					$img_wi=$wi * $tamanho / $he; }
			}
			else if ($tipo == '1')
			{ 	$wi=ImageSX($img);
				$he=ImageSY($img);
				$wi >= $he?$wi = $he:$he = $wi;
				$img_wi=$tamanho;
				$img_he=$tamanho; }
			else if ($tipo == '2')
			{	$wi=ImageSX($img);
				$he=ImageSY($img);
				if ($wi >= $he) {	$img_wi=$tamanho;
									$img_he=$he * $tamanho / $wi; }
				else { 	$img_he=$tamanho; 
						$img_wi=$wi * $tamanho / $he; }

			}
			else if ($tipo == '3')
			{	$wi=ImageSX($img);
				$he=ImageSY($img);
				$img_wi=$tamanho;
				$img_he=$he * $tamanho / $wi;
				if ($img_he > $corte) { $img_he = $corte; $he = $img_he / $tamanho * $wi; }
//				$img_he=$tamanho; 
//				$img_wi=$wi * $tamanho / $he;

			}	
        //Aqui é criada a nova imagem
		$img_nova = imagecreatetruecolor ($img_wi,$img_he); 
        imagecopyresampled ($img_nova, $img, 0, 0, 0, 0, $img_wi, $img_he, $wi, $he); 
        imagedestroy($img); // Libera a memória da imagem original
     	return $img_nova;
 	} 	
	/*
		Se $esp = 1, retira espaço também.
		Se $utf = 0, decodifica antes de retirar o acento.
		Isto serve para o caso do texto vir codificado antes de
		entrar na função.
	*/

	public function removeAcentos($txt,$esp=0,$utf=1) {
		if ($utf) $txt = function_exists('mb_convert_encoding') ? mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8') : utf8_decode($txt);
		if ($esp) {
			$a = array(
				'/[ÀÁÂÃÄÅ]/'	=>'A',
				'/[àáâãäå]/'	=>'a',
				'/[ÈÉÊË]/'	=>'E',
				'/[èéêë]/'	=>'e',
				'/[ÌÍÎÏ]/'	=>'I',
				'/[ìíîï]/'	=>'i',
				'/[ÒÓÔÕÖØ]/'	=>'O',
				'/[òóôõöø]/'	=>'o',
				'/[ÙÚÛÜ]/'	=>'U',
				'/[ùúûü]/'	=>'u',
				'/ç/'		=>'c',
				'/Ç/'		=>'C',
				'/ /'		=>'',
				'/[_.\/-]/'	=>''
			);
		} else {
			$a = array(
				'/[ÀÁÂÃÄÅ]/'	=>'A',
				'/[àáâãäå]/'	=>'a',
				'/[ÈÉÊË]/'	=>'E',
				'/[èéêë]/'	=>'e',
				'/[ÌÍÎÏ]/'	=>'I',
				'/[ìíîï]/'	=>'i',
				'/[ÒÓÔÕÖØ]/'	=>'O',
				'/[òóôõöø]/'	=>'o',
				'/[ÙÚÛÜ]/'	=>'U',
				'/[ùúûü]/'	=>'u',
				'/ç/'		=>'c',
				'/Ç/'		=>'C',
				'/[_.\/-]/'	=>''
			);
		}
		return preg_replace(array_keys($a), array_values($a), $txt);
	}

  // === CSRF METHODS (Step 2) ===
  public function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
      try {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
      } catch (Exception $e) {
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
      }
    }
  }

  public function get_csrf_token_html() {
    $this->generate_csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') . '">';
  }

  public function validate_csrf_token($post_token = null) {
    if (!isset($post_token)) $post_token = $_POST['csrf_token'] ?? null;
    if (empty($post_token) || $post_token !== ($_SESSION['csrf_token'] ?? null)) {
      return false;
    }
    return true;
  }
}
?>
