<?php
$valorc = $_POST["valor"];
$perc 	= $_POST["percentual"];
$opcao	= $_POST["opcao"];
$valorc = str_replace(".","",$valorc);
$valorc = str_replace(",",".",$valorc);

if($opcao == 1) {
	$res 	= ($valorc + ($valorc * $perc) / 100);
}
else {
	$res 	= ($valorc - ($valorc * $perc) / 100);
}
echo json_encode(number_format($res, 2, ',', '.'));

