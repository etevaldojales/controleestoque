<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Fortaleza');
$lib = "lib/";
require_once($lib."classes/config.php");
require_once($lib."classes/verifica_session.php");
require_once($lib."classes/class.secoes.php");
require_once($lib."classes/class.usuario.php");

if(!$_SESSION["usuario"]) {
	header("Location: login.php");
}

