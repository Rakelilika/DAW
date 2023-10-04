<?php

namespace Clases;

use PDO;
use PDOException;

/**
 * Clase Stock encargada de gestionar la lógica de la tabla Stock
 */
class Stock extends Conexion {

    private $producto;
    private $tienda;
    private $unidades;

    public function __construct() {
        parent::__construct();
    }

    public function __getProducto() {
        return $producto;
    }

    public function __setProducto($producto) {
        $this->producto = $producto;
    }

    public function __getTienda() {
        return $tienda;
    }

    public function __setTienda($tienda)  {
        $this->tienda = $tienda;
    }

    public function __getUnidades() {
        return $unidades;
    }

    public function __setUnidades($unidades) {
        $this->unidades = $unidades;
    }

    /**
     * Funcion usada para obtener las unidades del producto instanciado en la tienda concretada
     * @param
     * @return array
     */
    public function getStock() {
        $stock = 0;
        $sql = "SELECT unidades FROM stocks WHERE producto = :prod AND tienda = :tienda";
        try {
            $stmt = self::$conexion->prepare($sql);
            $stmt->execute([':prod' => $this->producto, ':tienda' => $this->tienda]);
            if ($stmt->rowCount() != 0) {
                $stock = ($stmt->fetch(PDO::FETCH_OBJ))->unidades;
            }
        } catch (PDOException $ex) {
            die("Error al obtener el stock: " . $ex->getMessage());
        }
        return $stock;
    }

}
