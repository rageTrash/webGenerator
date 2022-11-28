<?php
	session_start();
	include 'conectar.php';

	if (!empty($_SESSION["id"])){
		header("Location: login.php");
	}

	if (isset($_GET["dominio"])) {
		shell_exec('rm -r '.$_GET["dominio"]);

		$records = $conn->prepare('DELETE FROM webs WHERE dominio = :dominio');
		$records->bindParam(':dominio', $_GET["dominio"]);
		$records->execute();
		$results = $records->fetch(PDO::FETCH_ASSOC);
		
		header('Location: panel.php');
	}
?>