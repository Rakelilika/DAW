<?php
    require '../vendor/autoload.php';

    use Clases\Jugador;
   
    $faker = Faker\Factory::create('es_ES');
    do {
        $barcode = $faker->unique()->ean13;
        $existeB = (new Jugador())->comprobarBarcode($barcode);
        //Generemos y validamos que el barcode creado no exista en bbdb, en cuyo caso repetimos el proceso
    } while ($existeB != false);

    session_start();
    $_SESSION['barcode'] = $barcode;
    //Almacenamos barcode generado en sesión para su posterior uso y redirigimos a página fcrear.php
    header('Location: fcrear.php');