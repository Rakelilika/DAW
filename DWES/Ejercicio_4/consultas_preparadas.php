<?php
//Función utilizada para crear la conexión a nuestra bbdd
function crearConexion() {
	$host = "localhost";	//Creamos variables para conectar con la bbdd
	$db = "proyecto";
	$user = "gestor";
	$pass = "secreto";
	$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
	$conn = false;
	try {	//Creamos objeto PDO para usarlo posteriormente
		$conn = new PDO($dsn, $user, $pass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $ex) {
		//$error = $ex->getMessage();
		$conn = false;
	}
	return $conn;
}
//Función usada para consultar un usuario en nuestra bbdd
//La función recibe como parámetro un array con los datos a consultar (user y pass)
function mdlConsultaUsuario($datos) {
	$ret = "error";
	$conn = crearConexion();
	$sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND pass = :password";
	$stmt = $conn->prepare($sql);
	$password = hash('sha256', $datos['pass']);	//Creamos variable password con la clave recibida encriptada en sha256
	$stmt->execute( [':usuario' => $datos['usuario'],	//Bindeamos parámetros para ejecutar la consulta
					 ':password' => $password]);
	//$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
	//$stmt->bindParam(":password", $password, PDO::PARAM_STR);
	//$stmt->execute();
	if ($stmt->rowCount() > 0) {	//Si existe el usuario devolvemos ok, en caso contrario error
		$ret = "ok";
	}
	$stmt = $conn = null;	//Limpiamos conexiones
	return $ret;
}