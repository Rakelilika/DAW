<?php

namespace Clases;

use PDO;
use PDOException;

/**
 * Clase Familia encargada de gestionar la lógica de la tabla Familia
 */
class Familia extends Conexion {

    private $cod;
    private $nombre;

    public function __construct() {
        parent::__construct();
    }

    public function __getCod() {
        return $cod;
    }

    public function __setCod($cod) {
        $this->cod= $cod;
    }

    public function __getNombre() {
        return $nombre;
    }

    public function __setNombre($nombre) {
        $this->nombre= $nombre;
    }

    /** 
     * Funcion usada para obtener las familias almacenadas en base de datos
     * @param
     * @return array
     */
    public function getFamilias() {
        $familia = array();
        $sql = "SELECT cod FROM familias";
        try {
            $stmt = self::$conexion->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() != 0) {
                while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $familia[] = $row->cod;
                }
            }
        } catch (PDOException $ex) {
            die("Error al obtener las familias: " . $ex->getMessage());
        }
        return $familia;
    }

}    
