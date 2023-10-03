<?php
    require '../vendor/autoload.php';

    use Clases\Jugador;

    //Capturamos valores enviados por POST y validamos que no haya problemas
    $error = false;
    if ($_POST['nombre'] == "" || $_POST['apellidos'] == "") {
        $error = true;
    }
    $dorsal = (new Jugador())->comprobarDorsal($_POST['dorsal']);
    if ($dorsal != false) {
        $error = true;
    }
    
    //Si existen errores de validación en nombre, apellido o dorsal, almacenamos el error en sesión
    session_start();
    if ($error) {
        $_SESSION['mensaje']  = "Error al introducir el jugador";
        header('Location: jugadores.php');
    }

    $j = array();
    //Creamos array para enviar los datos del jugador a función encargada de su inserción
    $j['nombre'] = $_POST['nombre'];
    $j['apellidos'] = $_POST['apellidos'] ;   
    $j['dorsal'] = $_POST['dorsal'];
    $j['posicion'] = $_POST['posicion'];
    $j['barcode'] =  $_POST['barcode'];

    $resultado = (new Jugador())->insertarJugador($j);
    if ($resultado) {
        $_SESSION['mensaje'] = "Jugador creado con éxito";
    } else {
        $_SESSION['mensaje'] = "Error al introducir el jugador";
    }
    //Redirigimos a jugadores.php tras realizar (o no) la inserción del jugador en bbdd
    header('Location: jugadores.php');