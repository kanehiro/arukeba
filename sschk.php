<?php
//セッション変数がなければログイン・ページへ誘導
session_start();
if (!isset($_SESSION["sesUserID"])) {
	$_SESSION= array();
	session_destroy();
	session_start();
	header("Location: login.php");
	exit;
}
?>