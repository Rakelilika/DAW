<?php

namespace Clases\Clases1;

include '../src/Clases1/ClasesOperacionesService.php';
//Instanciamos clase generada de forma automática (también podríamos hacer uso del Use)
$cliente = new ClasesOperacionesService();

//Obtenemos PVP de producto a partir de código
$codigo = 2;
$pvp = $cliente->getPvp($codigo);
if ($pvp == null)  {
    $resultado = "(no existe)";
} else {
    $resultado = $pvp . "€";
}
echo "El producto $codigo es: $resultado <br><br>";

//Obtenemos todas las familias en bbdd
echo "Familias: ";
$familias = $cliente->getFamilias();
foreach ($familias as $familia) {
    echo "<br> * $familia";
}

//Obtenemos productos por familia
echo "<br><br>Productos por Familias: ";
$codigoFamilia = "CAMARA";
$productos = $cliente->getProductosFamilia($codigoFamilia);
foreach ($productos as $producto) {
    echo "<br> * $producto";
}

//Obtenemos Stock a partir de ids de producto y de tienda
$tienda = 3;
$producto = 3;
$stock = $cliente->getStock($producto, $tienda);
echo "<br><br>Stock en la tienda $tienda del producto $producto: $stock";
