<?php
session_start();

include 'conectar.php';

if (!empty($_SESSION['id'])){
	header("Location: panel.php");
}

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {

	$records = $conn->prepare('SELECT idUsuario, email, password FROM usuarios WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	if ($results['email'] == "admin@server.com" && $_POST['password'] == $results['password']) {
		header("Location: admin.php");
	}

	if ($_POST['password'] == $results['password']) {
	  	$_SESSION['id'] = $results['idUsuario'];
	  	header("Location: panel.php");
    } else {
      	$message = 'Las credenciales no coinciden';
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

	<h2>iniciar sesion</h2>
	<div style="color:red;">
		<?php
			echo $message;
		?>
	</div>
	<form action="login.php" method="POST">

		<input type="text" name="email" placeholder="ingrese su email">
		<br>
		<input type="password" name="password" placeholder="ingrese una contraseña">
		<br>
		<br>
		<input type="submit" name="btn" value="iniciar sesion">
	</form>
	<br>
	No tienes cuenta? Registrate!! --> <a href="register.php">registrarse</a>

</body>
</html>