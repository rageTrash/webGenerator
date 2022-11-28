<?php
	session_start();
	if (!empty($_SESSION['id'])){
		header("Location: panel.php");
	}
	include 'conectar.php';
	$message="";

if(isset($_POST['btn'])){
	$records = $conn->prepare('SELECT email FROM usuarios WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	if (empty($results['email'])) {
		if (!empty($_POST['email']) && !empty($_POST['password']))  {
		    if ($_POST['password'] == $_POST['password_ver']){

		      	$sql = "INSERT INTO usuarios (email, password) VALUES (:email, :password)";
		      	$stmt = $conn->prepare($sql);
		      	$stmt->bindParam(':email', $_POST['email']);
		      	$stmt->bindParam(':password', $_POST['password']);

			    if ($stmt->execute()) {
			      	header("Location: login.php");
			    } else {
			      	$message = 'Lo sentimos, debe haber habido un problema al crear su cuenta';
			    }
		    } else {
		      $message = 'Las contraseñas no son iguales';
		    }
		    
		} else {
		   $message = 'Hay campos vacios';
		}
	}else {
	   $message = 'cuenta ya existe';
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>webgenerator oliverio garcia rodriguez</title>
</head>
<body>

	<h2>Registrarse es Simple</h2>
	<div style="color:red;">
		<?php
			echo $message;
		?>
	</div>
	<form action="register.php" method="POST">
		<input type="email" name="email" placeholder="ingrese su email">
		<br>
		<input type="password" required name="password" placeholder="ingrese su contraseña">
		<br>
		<input type="password" required name="password_ver" placeholder="repetirta su contraseña">
		<br>
		<br>
		<input type="submit" name="btn" value="Registrar">
	</form>


</body>
</html>