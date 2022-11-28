<?php
	session_start();
	include 'conectar.php';
	if (empty($_SESSION["id"])){
		header("Location: login.php");
	}

	$message="";

	if(isset($_POST["btn"])){
		if(!empty($_POST["dominio"])){
			
			$dominio = $_SESSION['id'].$_POST["dominio"];

			$records = $conn->prepare('SELECT * FROM webs WHERE dominio = :dominio');
			$records->bindParam(':dominio', $dominio);
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);

			if(empty($results['dominio'])){
				$date=date("Y-m-d");

				$sql = "INSERT INTO webs (idUsuario,dominio,fechaCreacion) VALUES (:id, :dominio, :fecha)";
		      	$stmt = $conn->prepare($sql);
		      	$stmt->bindParam(':id', $_SESSION["id"]);
		      	$stmt->bindParam(':dominio', $dominio);
		      	$stmt->bindParam(':fecha', $date);

		      	if ($stmt->execute()) {
			      	$message="Nuevo dominio creado correctamente";
      				shell_exec('../wix.sh ../'.$dominio.' '.$dominio);
			    } else {
			      	$message="Error: ".$sql."<br>".mysqli_error($stmt);
			    }
			}else{
				$message="Este dominio ya existe";
			}

		}else{
			$message="Complete este campo";
		}
	}

	$sql = 'SELECT * FROM webs';

	$lista="<table>";
	foreach ($conn->query($sql) as $row) {
        if ($row['idUsuario'] == $_SESSION["id"]){

			$lista.='
			<tr>
				<td>
					<a href="../'.$row["dominio"].'">
						'.$row["dominio"].'
					</a>
				</td>
				
				<td>
					<a href="zipper.php?zip='.$row["dominio"].'">
						Descargar web
					</a>
				</td>
				
				<td>
					<a href="delete.php?dominio='.$row["dominio"].'">
						Eliminar web
					</a>
				</td>
			</tr>';
		}
	}
	$lista.="</table>"
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>webgenerator oliverio garcia rodriguez</title>
</head>
<body>
	<h3> Generar Web de: </h3>
		<form action="panel.php" method="POST">
			<input type="text" name="dominio" placeholder="Nombre de la web">
			</input>
			<br><br>
			<input type="submit" name="btn" value="Crear Web">
			<br><br>
		</form>
	<div>
		<?php echo $message;?>
	</div>
		<?php echo $lista;?>
	<br>
	<a href="logout.php">Cerrar sesión de <?php echo $_SESSION['id'];?></a>

</body>