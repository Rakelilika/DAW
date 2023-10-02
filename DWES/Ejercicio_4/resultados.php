<?php
	session_start();	// Iniciamos la sesión o recuperamos la existente
	if (!isset($_SESSION['usuario'])) {	//Si no tenemos la sesión del usuario iniciada, redireccinamos a login
		header('Location: login.php');
		die();
	}
	if (!isset($_SESSION['nombre'])) {	//Si no tenemos la sesión con el nombre iniciada, redireccinamos a nominas
		header('Location: nominas.php');
		die();
	}
	if (isset($_POST['modificar'])) {	//Si pulsamos el botón modificar
		$_SESSION['modificar'] = true;	//Creamos variable modificar en sesión y redireccionamos a nominas
		header('Location: nominas.php');
		die();
	}
	//Función usada para calcular el salario el trabajador
	//Recibe como parámetro el valor final calculado para los extras marcados
	function calculoSalario($calculoExtras) {
		//Si existe variable en sesión de hijos y es un entero igual a 4, le asignamos el valor 50
		//En caso contrario, le asignamos el valor contenido multiplicado por 10
		$valorHijos = (intval($_SESSION['hijos']) == 4) ? 50 : intval($_SESSION['hijos']) * 10;	
		if (is_numeric($_SESSION['sueldo'])) {	//Comprobación realizada para validar que el suelo es un número
			$salario = $_SESSION['sueldo'] + $calculoExtras + $valorHijos;
		} else {	//En caso de no serlo, supondremos que es un error y no lo tenemos en cuenta (el sueldo introducido)
			$salario = $calculoExtras + $valorHijos;
		}
		return $salario;
	}
	//Función usada para buscar el departamento introducido
	function buscarDepartamento() {
		$departamento = "General";	//Por defecto marcamos el departamento como general
		$departamentos = array("fer" => "Ferretería", "inf" => "Informática", "ext" => "Exterior", "vent" => "Ventas", "man" => "Mantenimiento");
		if (array_key_exists($_SESSION['departamento'], $departamentos)) {	//Si localizamos el valor introducido entre los disponibles en el array clave-valor
			$departamento = $departamentos[$_SESSION['departamento']];		//Obtenemos su correspondiente categoría (buscamos el valor en la clave, no en los valores)
		}
		return $departamento;
	}
	$calculoExtras = 0;		//Variables genéricas usadas en página
	$acumuladoNominas = $_SESSION['acumuladoNominas'];
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
		<form name="formResultados" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<fieldset style="border-color:red;width:400px;">
				<p>Empleado: <?php echo $_SESSION['nombre']; ?></p>
				<p>El salario base es: <?php echo $_SESSION['sueldo']; ?></p>
				<p>DTO: <span style="color:red;font-weight:bold;"><?php echo buscarDepartamento(); ?></span></p>
				<p>Relación de extras:</br>
					<?php
						if (isset($_SESSION['extras'])) {	//Comprobamos si existen los extras en la sesión
							foreach ($_SESSION['extras'] as $clave => $extra) {	/// los recorremos como clave-valor
								echo '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
								echo '*'.$clave.' : '.$extra.'</br>';	//Mostramos espacios en blanco a la izquierda por cuestiones estéticas
								$calculoExtras += intval($extra);		//Aprovechamos bucle para almacenar el total obtenido calculado en la variable calculoExtras
							};
						} else {
							echo 'No se han seleccionado extras</br>';	//Mostramos mensaje si no hemos seleccionado extras previamente
						}
					?>
				</p>
				<p>Número de hijos: <?php echo $_SESSION['hijos']; ?></p>
				<p>Salario final a percibir es: <?php echo calculoSalario($calculoExtras); ?>€/m</p>
				<p>TOTAL acumulado de nóminas: <?php echo $acumuladoNominas + calculoSalario($calculoExtras); ?>€</p>	<!-- Mostramos cálculos previa asignación de los mismos -->
				<input type="submit" name="modificar" value="Modificar"/>
				<input type="submit" name="otro" value="Otro"/>
			</fieldset>
		</form>
		<?php 
			if (isset($_POST['otro'])) {	//Si pulsamos el botón otro
				$salario = calculoSalario($calculoExtras);
				$_SESSION['acumuladoNominas'] += $salario;	//Almacenamos definitivamente el total acumulado en nóminas 
				$_SESSION['datosTrabajadores'][$_SESSION['nombre']] = $salario;	//Y creamos un array clave-valor en sesión con el nombre del trabajador y su salario correspondiente
				$_SESSION['numeroEmpleado']++;		//Aumentamos el contador de trabajadores
				header('Location: nominas.php');	//Y redireccionamos a página de nóminas
				die();
			}
		?>
	</body>
</html>