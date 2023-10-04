<?php

namespace Clases;

use PDO;
use PDOException;

/**
 * Clase Producto encargada de gestionar la lógica de la tabla Producto
 */
class Producto extends Conexion {

    private $id;
    private $nombre;
    private $nombre_corto;
    private $descripcion;
    private $pvp;
    private $familia;

    public function __construct() {
        parent::__construct();
    }

    public function __getId() {
        return $this->$id;
    }

    public function __setId($id) {
        $this->id = $id;
    }

    public function __getNombre() {
        return $this->$nombre;
    }

    public function __setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function __getNombre_corto() {
        return $this->$nombre_corto;
    }

    public function __setNombre_corto($nombre) {
        $this->nombre_corto = $nombre;
    }

    public function __getDescripcion() {
        return $this->$descripcion;
    }

    public function __setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    public function __getPvp() {
        return $this->$pvp;
    }

    public function __setPvp($pvp) {
        $this->pvp = $pvp;
    }

    public function __getFamilia() {
        return $this->$familia;
    }

    public function __setFamilia($familia) {
        $this->familia = $familia;
    }

    /**
     * Funcion usada para obtener el precio de un producto usando su id instanciado
     * @param
     * @return float|null
     */
    public function getPrecio() {
        $precio = null;
        $sql = "SELECT pvp FROM productos WHERE id = :id";
        try {
            $stmt = self::$conexion->prepare($sql);
            $stmt->execute([':id' => $this->id]);
            if ($stmt->rowCount() != 0) {
                $precio = ($stmt->fetch(PDO::FETCH_OBJ))->pvp;
            }
        } catch (PDOException $ex) {
            die("Error al obtener el precio: " . $ex->getMessage());
        }
        return $precio;
    }

    /**
     * Funcion usada para pbtener los nombres de los productos a partir de su familia
     * @param string $codigo
     * @return array
     */
    public function getProductosFamilia($codigo) {
        $codigos = array();
        $sql = "SELECT nombre FROM productos WHERE familia = :familia";
        try {
            $stmt = self::$conexion->prepare($sql);
            $stmt->execute([':familia' => $codigo]);
            if ($stmt->rowCount() != 0) {
                while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $codigos[] = $row->nombre; //$codigos[] = $row->id;    //Aunque el pide el código, hemos devuelto el nombre, como en el pantallazo del foro
                }
            }
        } catch (PDOException $ex) {
            die("Error al obtener las productos de las familias: " . $ex->getMessage());
        }
        return $codigos;
    }
}
