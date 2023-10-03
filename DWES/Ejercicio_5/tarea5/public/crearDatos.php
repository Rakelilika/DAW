<?php
    require '../vendor/autoload.php';

    use Clases\Jugador;

    //Instanciamos objeto Faker para crear (10) datos ficticios de prueba
    $faker = Faker\Factory::create('es_ES');
    for ($i = 0 ; $i < 10; $i++) {
        $j = array();    
        $j['nombre'] = $faker->firstName;
        $j['apellidos'] = $faker->lastName . " " . $faker->lastName;   
        $j['dorsal'] = $faker->unique()->numberBetween(1, 50);
        $j['posicion'] = $faker->numberBetween(1, 6);
        $j['barcode'] = $faker->unique()->ean13;
        //Instanciamos un nuevo Jugador y lo insertamos 1 a 1 en el sistema
        //Dada la naturaleza didáctica del ejercicio, no se han validado estas inserciones debido
        //a que se realizan de forma automática siempre que no haya registros previos en el sistema
        $jugador = new Jugador();
        $jugador->insertarJugador($j);
    }
    //Redirigimos a index.php tras realizar las inserciones de los jugadores en bbdd
    header('Location: index.php');