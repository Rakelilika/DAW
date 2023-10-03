
<?php
    require '../vendor/autoload.php';

    use Philo\Blade\Blade;

    $views = '../views';
    $cache = '../cache';

    //Creamos variables y objetos necesarios para montar la vista usando blade
    $blade = new Blade($views, $cache);
    $titulo = 'Jugadores';
    $encabezado = 'Crear Jugador';
    $destino = 'crearJugador.php';
    $volver = 'jugadores.php';
    $generarBarcode = 'generarCode.php';
    //Creamos array con las posiciones a mostrar en el select de la vista
    $posiciones = ['Portero','Defensa','Lateral Izquierdo','Lateral Derecho','Central','Delantero'];

    $barcode = false;
    session_start();
    //Comprobamos si existe un barcode generado a petición del usuario y lo mandamos a la vista
    if (isset($_SESSION['barcode'])) {
        $barcode = $_SESSION['barcode'];
        session_destroy();
    }

    echo $blade
        ->view()
        ->make('vcrear', compact('titulo', 'encabezado', 'destino', 'volver', 'posiciones', 'generarBarcode', 'barcode'))
        ->render();