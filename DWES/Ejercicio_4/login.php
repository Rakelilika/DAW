<?php
	include_once("consultas_preparadas.php");	//Importamos fichero con conexión PDO y consultas preparadas
	$error = false;	//Inicializamos variable para controlar errores 
	if (isset($_POST['enviar'])) {	//Si pulsamos botón enviar de formulario
		$user = $_POST['usuario'];
		$pass = $_POST['contrasena'];
		if ($user != "" && $pass != "") {	//Validamos que usuario y contraseña estén rellenos
			$datos = Array();
			$datos["usuario"] = $user;
			$datos["pass"] = $pass;
			if (mdlConsultaUsuario($datos) == "ok") {	//Si existe el usuario en nuestra bbdd
				session_start();	// Iniciamos sesión para almacenar datos en la misma
				$_SESSION['usuario'] = $user;	//Inicializamos valores en variable global de sesión para usarlas posteriormente
				$_SESSION['numeroEmpleado'] = 1;
				$_SESSION['acumuladoNominas'] = 0;
				$_SESSION['datosTrabajadores'] = Array();
				header('Location: nominas.php');	//Redireccionamos a página de nominas
				die();								//Cortamos ejecución de página actual tras redirección
			} else {
				$error = "<p style='color:red;'>Los datos son incorrectos</p>";
			}
		} else {
			$error = "<p style='color:red;'>Debes rellenar ambos campos</p>";
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Ejercicio Tema 4</title>
	</head>
	<body>
		<form name="formLogin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<h1>Formulario</h1>
			<p>
				<label for="usuario">Usuario:</label>
				<input type="text" id="usuario" name="usuario"/>
			</p>
			<p>
				<label for="contrasena">Contraseña:</label>
				<input type="password" id="contrasena" name="contrasena"/>
			</p>
			<input type="submit" name="enviar" value="Enviar"/>
		</form>
		<?php echo $error; ?>	<!-- Mostramos mensaje de error si existe -->
	</body>
</html>