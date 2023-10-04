<?php

require '../vendor/autoload.php';
//servicio soap utilizado para manejar diversas funciones en el servidor
try {
    $server = new SoapServer(null, array('uri' => "http://localhost/DWES/tarea6/servidorSoap"));
    $server->setClass('Clases\Operaciones');
    $server->handle();
} catch (SoapFault $er) {
    die("Error: " . $er->getMessage());
}
