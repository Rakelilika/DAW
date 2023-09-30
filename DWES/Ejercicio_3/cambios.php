<?php
	//Función usada para redirigir navegador a página principal
	function redirigir() {
		header('Location: tienda.php');
		die();
	}
	if (!isset($_GET['idProducto']) && !isset($_POST['idProducto'])) {
		redirigir();	//Redirigimos a página principal si no tenemos el parámetro idProducto
	}
	//Importamos fichero con conexión PDO
	include_once("conexion.php");
	$mensaje = false;	//Variable usada para mostrar respuesta de transacción y/o posibles errores
	//Si pulsamos botón actualizar
	if (isset($_POST['actualizar'])) {
		try {	//Usamos bloque try-catch para capturar posibles errores en la ejecución
			$conn->beginTransaction();	//Iniciamos transacción
			$sql = "UPDATE productos SET nombre_corto = :nombreCorto, nombre = :nombre, descripcion = :descripcion, pvp = :pvp WHERE id = :idProducto";
			$stmt = $conn->prepare($sql);	//Usamos UPDATE en lugar de REPLACE para mantener la integridad de los registros antíguos
			$stmt->execute([':nombreCorto' 	=> $_POST['nombreCorto'],
							':nombre' 		=> $_POST['nombre'],
							':descripcion' 	=> $_POST['descripcion'],
							':pvp' 			=> $_POST['precio'],
							':idProducto' 	=> $_POST['idProducto']]);
			$sql = "INSERT INTO log (id_producto, f_cambio) VALUES (:idProducto, :fCambio)";
			$stmt2 = $conn->prepare($sql);
			$stmt2->execute([':idProducto' 	=> $_POST['idProducto'],
							':fCambio' 		=> date("Y-m-d")]);	//Creamos objeto fecha con formato aaaa-mm-dd 
			//Si alguna de las operaciones no tiene resultado positivo, revertimos proceso
			if ($stmt->rowCount() == 0 || $stmt2->rowCount() == 0 ) {
				$conn->rollback();
				$mensaje = "<p style='color:red;'>No se ha podido realizar la actualización.</p>";
			} else {
				$conn->commit();	//En caso contrario realizamos cambios en bloque
				$mensaje = "<p style='color:green;'>CORRECTO. Se han actualizado los datos de: <span style='font-weight:bold;'>". $_POST['nombreCorto'] . "</span></p>";
			}
			$nombre = $_POST['nombre'];		//Asignamos valor a los registros usados para rellenar los inputs tras recarga de página
			$nombreCorto = $_POST['nombreCorto'];
			$descripcion = $_POST['descripcion'];
			$precio = $_POST['precio'];
			$stmt = null;
		} catch (PDOException $ex) {
			$conn->rollback();		//Si existen problemas revertimos proceso
			$mensaje = "<p style='color:red;'>No se ha podido realizar la actualización.</p>";
			$stmt = $conn = null;	//Cerramos registros para liberar recursos
		}
	} else {	//Si cargamos la página normalmente 
		try {	
			$sql = "SELECT * FROM productos WHERE id = :idProducto";
			$stmt = $conn->prepare($sql);	//Cargamos idProducto con _GET o _POST según proceda
			$idProducto = (isset($_GET['idProducto'])) ? $_GET['idProducto'] : $_POST['idProducto'];
			$stmt->execute([':idProducto' => $idProducto]);
			$producto = $stmt->fetch(PDO::FETCH_OBJ); //solo nos devuelve una fila es innecesario el while
			if (!$producto) {	//Redirigimos a página principal si no existe registro del idProducto
				redirigir();
			} else {			//En caso contrario cargamos los datos del producto en cuestión
				$nombre = $producto->nombre;
				$nombreCorto = $producto->nombre_corto;
				$descripcion = $producto->descripcion;
				$precio = $producto->pvp;
				$stmt = null;	//Cerramos registros para liberar recursos
			}
		} catch (PDOException $ex) {
			$stmt = $conn = null;	//Cerramos registros para liberar recursos
			redirigir();			//Redirigimos a página principal si se generan errores
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Ejercicio Tema 3</title>
	</head>
	<body>
		<h3>Tarea: Edición del Producto</h3>
		<form name="formEdicion" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<p>
				<span style="font-weight:bold;">Producto:</span> <?php echo $nombreCorto; ?>
			</p>
			<p>
				<label for="nombreCorto">Nombre Corto:</label>
				<input type="text" id="nombreCorto" name="nombreCorto" size="38" value="<?php echo $nombreCorto; ?>"/>
			</p>
			<p>
				<label for="nombre">Nombre:</label></br>
				<textarea id="nombre" name="nombre" rows="3" cols="50"><?php echo $nombre; ?></textarea>
			</p>
			<p>
				<label for="descripcion">Descripción:</label></br>
				<textarea id="descripcion" name="descripcion" rows="6" cols="50"><?php echo $descripcion; ?></textarea>
			</p>
			<p>
				<label for="precio">Precio:</label>
				<input type="text" id="precio" name="precio" size="8" value="<?php echo $precio; ?>">
			</p>
			<p>
				<input type='submit' value='Actualizar' name='actualizar'/>
				<input type='submit' value='Cancelar' name='cancelar'/>
			</p>
			<!--Cargamos id en un input oculto para no perderlo y poder reutilizarlo tras la recarga de la página-->
			<input type='hidden' name='idProducto' value="<?php echo $idProducto; ?>"/>
<?php
			if (isset($_POST['cancelar'])) {			//Si pulsamos botón cancelar
				echo "<p>Cancelando...</p>";
				header("Refresh:2; url=tienda.php");	//Redirigimos a página principal tras 2 segundos
			}
			if ($mensaje) {								//Si se ha definido un mensaje de error y/o de transacción
				echo $mensaje;							//Mostramos mensaje 
				header("Refresh:2; url=listado.php");	//Redirigimos a página listado tras 2 segundos
			}
?>
		</form>
	</body>
</html>