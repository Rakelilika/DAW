<?php

require '../vendor/autoload.php';
//servicio soap utilizado para manejar diversas funciones en el servidor(con wsdl)
try {
    $server = new SoapServer("http://localhost/DWES/tarea6/servidorSoap/servicio.wsdl");
	$server->setClass('Clases\Operaciones');
	$server->handle();
} catch (SoapFault $er) {
    die("Error: " . $er->getMessage());
}
