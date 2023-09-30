<?php
	//Importamos fichero con conexión PDO
	include_once("conexion.php");
	//Función usada para cargar logs obtenidos por bbdd
	function cargarLog(&$conn) {
		try {
			$sql = "SELECT * FROM log ORDER BY f_cambio, numero ASC";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {	//Cargamos registros de logs si existen
				echo "<table style='margin-left:auto;margin-right:auto;'>";
				echo "<tr>";
				echo "<th style='width:40px;'>Nº</th>";
				echo "<th>Producto</th>";
				echo "<th style='width:160px;'>Fecha Modificación</th>";
				echo "</tr>";
				while ($log = $stmt->fetch(PDO::FETCH_OBJ)) {
					echo "<tr>";	//Recorremos registros obtenidos y los mostramos en formato tabla
					echo "<td style='text-align:center;'>$log->numero</td>";
					echo "<td style='text-align:center;'>$log->id_producto</td>";
					echo "<td style='text-align:center;'>" . date_format(date_create($log->f_cambio), "d-m-Y") . "</td>";
					echo "</tr>";					//Formateamos fecha recibida de bbdd para mostrarla como dd-mm-aaaa
				}
				echo "</table>";
			} else {	//Si no hay registro de logs, mostramos mensaje avisando de ello
				echo "<p style='text-align:center;color:red;'>No hay registros cargados en la tabla de logs</p>";
			}
			$conn = $stmt = null;		//Cerramos registros para liberar recursos
		} catch (PDOException $ex) {
			echo "<p style='text-align:center;color:red;'>" . $ex->getMessage() . "</p>";
			$conn = $stmt = null;		//Cerramos registros para liberar recursos
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
		<h3 style='text-align:center;'>Listado de Modificaciones</h3>
<?php
		cargarLog($conn);	//Cargamos logs enviando la conexión previamente establecida
?>
		<p style="text-align:center;"><a href='tienda.php'>Volver a Inicio</a></p>
	</body>
</html>