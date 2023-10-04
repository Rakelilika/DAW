<?php

namespace Clases;

use PDO;
use PDOException;

/**
 * Clase Conexion encargada de gestionar las conexiones a nuestra bbdd
 */
class Conexion {

    private static $host;
    private static $db;
    private static $user;
    private static $pass;
    private static $dsn;
    protected static $conexion;

    /**
     * Constructor que por defecto que crea una conexión para poder ser usada al momento de instanciarse
     */
    public function __construct() {
        self::$host = "localhost";
        self::$db = "tarea6";
        self::$user = "gestor";
        self::$pass = "secreto";
        self::$dsn = "mysql:host=".self::$host.";dbname=".self::$db.";charset=utf8mb4";
        self::crearConexion();
    }

    /**
     * Función estática usada para crear conexiones al instanciarse de forma automática
     */
    public static function crearConexion() {
        try {
            self::$conexion = new PDO(self::$dsn, self::$user, self::$pass);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            die("Error en conexion: " . $ex->getMessage());
        }
        return self::$conexion;
    }
}
