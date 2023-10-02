<?php
	session_start();	// Iniciamos la sesión o recuperamos la existente
	if (!isset($_SESSION['usuario'])) {	//Si no tenemos la sesión del usuario iniciada, redireccinamos a login
		header('Location: login.php');
		die();
	}
	$volver = false;
	$mensaje = false;
	if (isset($_POST['cerrar'])) {	//Si pulsamos botón cerrar
		$mensaje = "";
		if (count($_SESSION['datosTrabajadores']) > 0) {	//Si tenemos datos de trabajadores almacenados en sesión
			$mensaje .= "<h1>Listado de trabajadores: </h1>";
			foreach ($_SESSION['datosTrabajadores'] as $clave => $extra) {	//Los recorremos leyendo su clave-valor
				$mensaje .= 'Trabajador: '.$clave.' - Sueldo: '.$extra.' €</br>';
			}
			$mensaje .= '</br>Total acumulado de nóminas: '.$_SESSION['acumuladoNominas'].' €</br>';
		} else {
			$mensaje .= "No hay datos de trabajadores guardados</br>";	//Si no hay datos de trabajadores mostramos mensaje
		}
		$mensaje .= "</br>Cerrando sesión...";
		$volver = true;	
		session_destroy();	//Destruímos y borramos la actual sesión
	}
	if (isset($_POST['calcular'])) {
		if ($_POST['nombre'] != "" && $_POST['sueldo'] != "" && $_POST['departamento'] != "") {
			$_SESSION['nombre'] = $_POST['nombre'];	//Comprobamos si se han rellenado los datos de nombre, sueldo y departamento
			$_SESSION['sueldo'] = $_POST['sueldo'];
			$_SESSION['departamento'] = $_POST['departamento'];
			$_SESSION['hijos'] = $_POST['hijos'];
			$_SESSION['extras'] = $_POST['extras'];	//Y los almacenamos en sesión para su posterior uso
			header('Location: resultados.php');		//Redireccionamos a página resultados
			die();
		} else{	//Si no rellenamos los datos de nombre, sueldo y departamento, mostramos mensaje
			$mensaje = "<p style='color:red;'>Debes rellenar Nombre, Sueldo y Departamento</p>";
		}	//Lo correcto sería validar tanto en cliente como en servidor que todos los datos tienen el formato correcto
	}		//Pero no queríamos prolongar demasiado el ejercicio
	//Función utilizada para cargar dinámicamente un checkbox utilizando un array clave-valor
	//La función recibe como parámetro los valores previos seleccionados (si existiesen) para marcarlos dado el caso
	function cargarCheckbox($extrasMarcados) {
		$extras = array("noche" => 100, "festivo" => 60, "hora" => 35, "peligro" => 120, "otros" => 70);
		echo "Extra: ";
		foreach ($extras as $clave => $extra) {
			$seleccionado = "";
			if (!is_null($extrasMarcados)) {	//Comprobamos que los extras marcados previamente existen, y en tal caso los buscamos para seleccionarlos
				$seleccionado = (array_key_exists($clave, $extrasMarcados)) ? "checked" : "";
			}
			echo '<input type="checkbox" id="'.$clave.'" name="extras['.$clave.']" value="'.$extra.'" '.$seleccionado.'>';
			echo '<label for="'.$clave.'">'.$clave.'</label>';
		}	
	}
	//Función usada para cargar dinámicamente un bloque de radio buttons
	//La función recibe como parámetro el valor previo seleccionado (si existiese) para marcarlo dado el caso 
	function cargarRadios($hijos) {
		echo "</br>Hijos: ";
		for ($i = 0; $i < 5; $i++) {	//Usamos bucle simple para iterar en el mismo y usar el índice como elemento del mismo
			$seleccionado = (intval($hijos) == $i) ? "checked" : "";	//Marcamos como chekeado el elemento previamente seleccionado (si existiese)
			echo '<input type="radio" id="radios'.$i.'" name="hijos" value="'.$i.'"'.$seleccionado.'/>';
			echo '<label for="radios'.$i.'">'.$i.'</label>';
		}
	}
	$valorNombre = "";	//Creamos variables para cargar los valores del formulario
	$valorSueldo = "";
	$valorDepartamento = "";
	$valorExtras = Array();
	$valorHijos = false;
	if (isset($_SESSION['modificar'])) {	//Si volvemos de la página resultados y existe la variable modificar en la sesión
		unset($_SESSION['modificar']);		//La eliminamos y recargamos los valores almacenados previamente en sesión
		$valorNombre = $_SESSION['nombre'];
		$valorSueldo = $_SESSION['sueldo'];
		$valorDepartamento = $_SESSION['departamento'];
		$valorExtras = $_SESSION['extras'];
		$valorHijos = $_SESSION['hijos'];
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
		<form name="formNominas" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<fieldset style="border-color:red;width:400px;">
				<h1>Datos del empleado nº <?php echo $_SESSION['numeroEmpleado']; ?></h1>
				<p>
					<label for="nombre">Nombre de empleado:</label>
					<input type="text" id="nombre" name="nombre" value="<?php echo $valorNombre; ?>"/>
				</p>
				<p>
					<label for="sueldo">Sueldo Base:</label>
					<input type="text" id="sueldo" name="sueldo" value="<?php echo $valorSueldo; ?>"/>
				</p>
				<p>
					<label for="departamento">DTO:</label>
					<input type="text" id="departamento" name="departamento" value="<?php echo $valorDepartamento; ?>"/>
				</p>
				<p>
					<?php 
						cargarCheckbox($valorExtras);	//Cargamos dinámicamente los checkboxs
						cargarRadios($valorHijos);		//Cargamos dinámicamente los radios
					?>
				</p>
				<input type="submit" name="cerrar" value="Cerrar"/>
				<input type="submit" name="calcular" value="Calcular"/>
			</fieldset>
		</form>
		<?php 
		if ($mensaje) {	//Si existe la variable mensaje y es diferente de false, mostramos su contenido
			echo $mensaje;
		}
		if ($volver) {	//Si la variable volver es true
			header("Refresh:3; url=login.php");	//Redirigimos a página de login tras 3 segundos	
			die();
		}
		?>
	</body>
</html>