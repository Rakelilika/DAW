<?php

namespace Clases;

use PDO;
use PDOException;

//Clase Conexion encargada de gestionar las conexiones a nuestra bbdd
class Conexion {
    private $host;
    private $db;
    private $user;
    private $pass;
    private $dsn;
    protected $conexion;

    //Nuestro constructor por defecto crea una conexión para poder ser usada al momento de instanciarse
    public function __construct() {
        $this->host = "localhost";
        $this->db = "practicaUnidad5";
        $this->user = "gestor";
        $this->pass = "secreto";
        $this->dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
        $this->crearConexion();
    }

    public function crearConexion() {
        try {
            $this->conexion = new PDO($this->dsn, $this->user, $this->pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            die("Error en la conexión: mensaje: " . $ex->getMessage());
        }
        return $this->conexion;
    }
}
