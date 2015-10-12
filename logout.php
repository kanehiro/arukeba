<?php
	require_once("definitions/definitions.php");
	require_once(DIR_FUNCTIONS ."general_func.php");
	require_once(DIR_CLASSES ."app_class.php");
	require_once("sschk.php");
	$_SESSION = array();	//配列の初期化
	session_destroy();
	header("Location: login.php");
?>