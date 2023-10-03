<?php
    require '../vendor/autoload.php';
    
    use Clases\Jugador;
    use Philo\Blade\Blade;

    //Obtenemos el total de jugadores en nuestra bbdd para redirigir a una sección u otra
    $jugadores = (new Jugador())->getTotal();
    if ($jugadores->totalJugadores == 0) {  //totalJugadores es un campo creado en la consulta a la bbdd
        header('Location: instalacion.php');	
    } else {
        header('Location: jugadores.php');
    }

