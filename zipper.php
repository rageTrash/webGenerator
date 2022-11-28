<?php
	session_start();
	if (!empty($_SESSION['id'])){
		header("Location: login.php");
	}
	$dominio = $_GET["zip"];
	
	if(isset($dominio)){
		shell_exec('zip ../'.$dominio.'.zip ../'.$dominio);
		header("Location: ../".$dominio.'.zip');
	}
?>