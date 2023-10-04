<?php

namespace Clases;

require '../vendor/autoload.php';

use Clases\Producto;
use Clases\Familia;
use Clases\Stock;

/**
 * Clase intermediaria utilizada para interactuar con los distintos métodos de cada una de las clases stock/producto/familia
 */
class Operaciones  {
    
    /**
     * Obtener el precio del producto que tenga el código que le pasemos
     * @soap
     * @param int $cod
     * @return float
     */
    public function getPvp($cod) {
        $producto = new Producto();
        $producto->__setId($cod);
        return $producto->getPrecio();
    }

    /**
     * Obtener los codigos de las familias de la base de datos
     * @soap
     * @param 
     * @return string[]
     */
    public function getFamilias() {
        $familia = new Familia();
        return $familia->getFamilias();
    }

    /**
     * Obtener los codigos de los productos a partir del codigo de la familia
     * @soap
     * @param string $codigo
     * @return string[]
     */
    public function getProductosFamilia($codigo) {
        $producto = new Producto();
        return $producto->getProductosFamilia($codigo);
    }

    /**
     * Obtener el stock de un producto y una tienda contretos
     * @soap
     * @param int $codigo
     * @param int $tienda
     * @return int
     */
    public function getStock($codigo, $tienda) {
        $stock = new Stock();
        $stock->__setProducto($codigo);
        $stock->__setTienda($tienda);
        return $stock->getStock($codigo, $tienda);
    }
}