<?php

$error = false;			//Creamos variable usada para controlar posibles errores
$host = "localhost";	//Creamos variables para conectar con la bbdd
$db = "tarea3";
$user = "gestor";
$pass = "secreto";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
	$conn = new PDO($dsn, $user, $pass);	//Creamos objeto PDO para usarlo de manera global
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
	$error = $ex->getMessage();
}