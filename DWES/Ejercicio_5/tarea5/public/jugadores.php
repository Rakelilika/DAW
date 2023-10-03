<?php
    require '../vendor/autoload.php';

    use Clases\Jugador;
    use Philo\Blade\Blade;
    use Milon\Barcode\DNS1D;

    $views = '../views';
    $cache = '../cache';

    //Creamos variables y objetos necesarios para montar la vista usando blade
    $blade = new Blade($views, $cache);
    $titulo = 'Jugadores';
    $encabezado = 'Listado de Jugadores';
    $destino = 'fcrear.php';
    //Creamos objeto para mostrar código de barras asociado a jugadores
    $dns = new DNS1D();
    $dns->setStorPath($cache);
    //Obtenemos todos los jugadores almacenados en bbdd
    $jugadores = (new Jugador())->recuperarJugadores();

    //Variable usada para mostrar o no mensajes adicionales en vista
    $mensaje = false;
    session_start();
    if (isset($_SESSION['mensaje'])) {
        //Si existe un mensaje adicional a mostrar, lo capturamos de la sesión y lo eliminamos
        $mensaje = $_SESSION['mensaje']; 
        session_destroy();
    }

    echo $blade
        ->view()
        ->make('vjugadores', compact('titulo', 'encabezado', 'destino', 'jugadores', 'dns', 'mensaje'))
        ->render();