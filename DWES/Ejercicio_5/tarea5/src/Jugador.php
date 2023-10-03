<?php

namespace Clases;

use PDO;
use PDOException;

//Clase Jugador encargada de gestionar la lógica para el uso y mantenimiento de nuestros jugadores
class Jugador extends Conexion {
    private $id;
    private $nombre;
    private $apellidos;
    private $dorsal;
    private $posicion;
    private $barcode;

    //El constructor instancia y crea una nueva conexión por defecto
    public function __construct() {
        parent::__construct();
    }

    //Método usado para recuperar los jugadores ordenados por nombre y apellido
    function recuperarJugadores() {
        $consulta = "SELECT * FROM jugadores ORDER BY nombre, apellidos";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al recuperar jugadores: " . $ex->getMessage());
        }
        $this->conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //Método usado para obtener el contador total de jugadores almacenados en bbdd
    function getTotal() {
        $consulta = "SELECT COUNT(*) AS totalJugadores FROM jugadores";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al recuperar jugadores: " . $ex->getMessage());
        }
        $this->conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    //Método usado para insertar un nuevo jugador en bbdd, devolviendo true o false en función del resultado
    function insertarJugador($datos) {
        $consulta = "INSERT INTO jugadores (nombre, apellidos, dorsal, posicion, barcode) VALUES (:n, :a, :d, :p, :b)";
        $stmt = $this->conexion->prepare($consulta);
		$sw = true;
        try {
            $stmt->execute([':n' 	=> $datos['nombre'],
                            ':a' 	=> $datos['apellidos'],
                            ':d' 	=> $datos['dorsal'],
                            ':p' 	=> $datos['posicion'],
                            ':b' 	=> $datos['barcode']]);
        } catch (PDOException $ex) {
            $sw = false;
        }
        $this->conexion = null;
        return $sw;
    }

    //Método usado para comprobar si el barcode generado existe en nuestra bbdd
    function comprobarBarcode($barcode) {
        $consulta = "SELECT barcode FROM jugadores WHERE barcode = :b";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute([':b' 	=> $barcode]);
        } catch (PDOException $ex) {
            die("Error al recuperar barcode: " . $ex->getMessage());
        }
        $this->conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    //Método usado para comprobar si el dorsal existe en nuestra bbdd
    function comprobarDorsal($dorsal) {
        $consulta = "SELECT dorsal FROM jugadores WHERE dorsal = :d";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute([':d' => $dorsal]);
        } catch (PDOException $ex) {
            die("Error al recuperar el dorsal: " . $ex->getMessage());
        }
        $this->conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

}
