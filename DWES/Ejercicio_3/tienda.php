<?php
	//Importamos fichero con conexión PDO
	include_once("conexion.php");
	//Función usada para cargar select de tiendas disponibles
	function cargarSelect(&$conn, &$error) {
		if (!$error) {
			try {	//Usamos bloque try-catch para capturar posibles errores en la ejecución
				$tiendaIdAux = "";
				if (isset($_POST['tiendaId'])) {
					$tiendaIdAux = $_POST['tiendaId'];	//Capturamos seleción previa de tienda
				}
				$sql = "SELECT id, nombre FROM tiendas ORDER BY nombre";
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				echo "<label for='tienda'>Tienda: </label>";
				echo "<select id='tienda' name='tiendaId'>";
				while ($tienda = $stmt->fetch(PDO::FETCH_OBJ)) {
					$selected = ($tiendaIdAux == $tienda->id) ? "selected" : "";				//Seleccionamos tienda previamente elegida
					echo "<option value='{$tienda->id}' $selected>$tienda->nombre</option>";	//Cargamos options de select usando registros de bbdd
				}
				echo "</select> ";
				$stmt = null;	//Cerramos registros para liberar recursos
			} catch (PDOException $ex) {
				$error = $ex->getMessage();
				$conn = null;	//Cerramos registros para liberar recursos
			}
		}
	}
	//Función usada para cargar productos de tiendas disponibles
	function cargarProductos(&$conn, &$error) {
		if (isset($_POST['mostrar']) & !$error) { //Si hemos enviado el formulario para consultar los productos
			try {
				$sql = "SELECT s.producto, s.tienda, s.unidades, p.nombre_corto, p.pvp, p.familia, p.id
						FROM tiendas t
						JOIN stocks s ON t.id = s.tienda
						JOIN productos p ON s.producto = p.id
						WHERE t.id = :tiendaId";
				$stmt = $conn->prepare($sql);	//Obtenemos productos asociados a tienda seleccionada
				$stmt->execute([':tiendaId' => $_POST['tiendaId']]);
				if ($stmt->rowCount() > 0) {	//Cargamos los productos si existen registros devueltos
					echo "<form id='formProductos' name='formProductos' method='POST'>";
					while ($producto = $stmt->fetch(PDO::FETCH_OBJ)) {
						echo "<p>Producto $producto->nombre_corto: $producto->pvp €, $producto->unidades ud. ***$producto->familia*** ";
						echo "<a href='cambios.php?idProducto=$producto->id'><input type='button' value='Editar'/></a></p>";
					}			//Usamos botón como URL y mandamos por GET el id del producto a editar
					echo "</form>";
				} else {		//Si no hay productos, mostramos un mensaje
					echo "<p style='color:red;'>No hay productos cargados en esta tienda</p>";
				}
				$stmt = null;	//Cerramos registros para liberar recursos
			} catch (PDOException $ex) {
				$error = $ex->getMessage();
				$conn = null;	//Cerramos registros para liberar recursos
			}
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
		<h3>Tarea: Listado de productos de una tienda</h3>
		<form id="formTiendas" name="formTiendas" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<?php
		cargarSelect($conn, $error);			//Cargamos select dinámicamente
		$disabled = ($error) ? "disabled" : "";	//Si existen errores desactivamos el botón mostrar
		echo " <input type='submit' for='formTiendas' value='Mostrar Productos' name='mostrar' $disabled>";
?>
		</form>
<?php
		cargarProductos($conn, $error);			//Cargamos productos si existen registros para esa tienda
		if ($error) {
			echo "<p style='color:red;'>$error</p>";
		}
?>
	</body>
</html>