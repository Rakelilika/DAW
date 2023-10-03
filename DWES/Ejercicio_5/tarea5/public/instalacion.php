<?php
    require '../vendor/autoload.php';

    use Clases\Jugador;
    use Philo\Blade\Blade;

    $views = '../views';
    $cache = '../cache';

    //Creamos variables y objetos necesarios para montar la vista usando blade
    $blade = new Blade($views, $cache);
    $titulo = 'Jugadores';
    $encabezado = 'Instalación';
    $destino = 'crearDatos.php';

    echo $blade
        ->view()
        ->make('vinstalacion', compact('titulo', 'encabezado', 'destino'))
        ->render();