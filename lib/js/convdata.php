<? 
/* 

  $tipo = 0 -=> Transforma data dd-mm-aaaa para aaaa-mm-dd -=> data brasil for mysql 
  $tipo = 1 -=> Transforma data aaaa-mm-dd para dd/mm/aaaa -=> mysql for data brasil 
*/ 

function convdata($dataform, $tipo){ 
  if ($tipo == 0) { 
     $datatrans = explode ("/", $dataform); 
     $data = "$datatrans[2]-$datatrans[1]-$datatrans[0]"; 
  } elseif ($tipo == 1) { 
     $datatrans = explode ("-", $dataform); 
     $data = "$datatrans[2]/$datatrans[1]/$datatrans[0]"; 
  } 
  return $data; 
} 
function diferenca_dias($inicial, $final) { 
  list($dia_inicial, $mes_inicial, $ano_inicial) = explode("/", $inicial); 
  list($dia_final, $mes_final, $ano_final) = explode("/", $final); 
  $inicial2 = mktime(0,0,0,$mes_inicial,$dia_inicial,$ano_inicial); 
  $final2 = mktime(0,0,0,$mes_final,$dia_final,$ano_final); 
  $dias = ($final2 - $inicial2)/86400; 
  return $dias; 
} 
function somadata($pData, $pDias){ 
    if(ereg("([0-9]{2})/([0-9]{2})/([0-9]{4})", $pData, $vetData)){; 
        $fDia = $vetData[1]; 
        $fMes = $vetData[2]; 
        $fAno = $vetData[3]; 

        for($x=0;$x<=$pDias;$x++){ 
            if($fMes == 1 || $fMes == 3 || $fMes == 5 || $fMes == 7 || $fMes == 8 || $fMes == 10 || $fMes == 12){ 
                $fMaxDia = 31; 
            }elseif($fMes == 4 || $fMes == 6 || $fMes == 9 || $fMes == 11){ 
                $fMaxDia = 30; 
            }else{ 
                if($fMes == 2 && $fAno % 4 == 0 && $fAno % 100 != 0){ 
                    $fMaxDia = 29; 
                }elseif($fMes == 2){ 
                    $fMaxDia = 28; 
                } 
            } 
            $fDia++; 
            if($fDia > $fMaxDia){ 
                if($fMes == 12){ 
                    $fAno++; 
                    $fMes = 1; 
                    $fDia = 1; 
                }else{ 
                    $fMes++; 
                    $fDia = 1; 
                } 
            } 
        } 
        if(strlen($fDia) == 1) $fDia = "0" . $fDia; 
        if(strlen($fMes) == 1) $fMes = "0" . $fMes; 
        return "$fDia/$fMes/$fAno"; 
    }else{ 
        return "Data Inválida."; 
    } 
} 
?> 