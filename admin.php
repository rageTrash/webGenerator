<?php
	include 'conectar.php';

	if (empty($_SESSION["id"]) or $_SESSION["id"] != 1){
		header("Location: login.php");
	}

	$records = $conn->prepare('SELECT * FROM webs');
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$sql = 'SELECT * FROM webs';

	$lista="<table>";
	foreach ($conn->query($sql) as $row) {
		$lista.='<tr><td><a href="../'.$row["dominio"].'">'.$row["dominio"].'</a></td></tr>';
		
	}
	$lista.="</table>"
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<title>Panel Administrador</title>
</head>
<body>

	<h1>Bienvenido administrador</h1><br>
	<a href="logout.php">Cerrar sesión</a><br><br>
	<?php echo $lista;?>

</body>
</html>