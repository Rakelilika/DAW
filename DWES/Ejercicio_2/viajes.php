				
<?php

//Valor del precio del billete
$precioBillete = 10;
//Numero maximo de billetes a seleccionar
$maxBilletes = 6;
//Array de descuentos aplicables
$descuentos = array("Estudiante" => 5,
                    "Jubilado" => 15,   
                    "F. Numerosa" => 20,
                    "Empleado" => 10
                    );
//Numero maximo de asientos a seleccionar
$maxAsientos = 15;
//Variable usada para mostrar mensajes de error en rojo
$mensajeError = "";
//Variable usada para mostrar mensajes de info en verde
$mensajeOk = "";

//Funcion usada para cargar dinamicamente el numero de billetes a mostrar en un select
function cargarBilletes($maxBilletes) {
	for ($i = 1; $i <= $maxBilletes; $i++) {
		echo "<option value='$i'>$i</option>";
    }
}
//Funcion usada para cargar dinamicamente los descuentos a mostrar en un radios
function cargarDescuentos($descuentos) {
    //Recorremos corredescuentosos iterando por su clave -> valor
    foreach ($descuentos as $categoria => $descuento) {
        echo "<input type='radio' id=",$categoria," name='descuentos' value=",$descuento,">";
        echo "<label for=",$categoria,">",$categoria," (",$descuento,"%)</label>";
    }
}
//Funcion usada para cargar dinamicamente los asientos a mostrar en checkboxs
function cargarAsientos($maxAsientos) {
	for ($i = 1; $i <= $maxAsientos; $i++) {
        //echo "<input type='checkbox' id='asiento_",$i,"' name='asiento_",$i,"' value=",$i,">";
        echo "<input type='checkbox' id='asiento_",$i,"' name='asientos[]' value=",$i,">";
        echo "<label for='asiento_",$i,"'>",$i,"</label>";
    }
}
//Funcion usada para validar los errores detectados de los campos del formulario y mostrar info del billete
function validarBillete(&$mensajeError, &$mensajeOk, $descuentos, $precioBillete) {
    //Variable usada para comprobar si existen errores
    $existeError = false;
    //Si esta vacio el campo origen
    if (empty($_POST['origen'])) {
        $mensajeError .= "ERROR: No se ha rellenado el campo origen</br>";
        $existeError = true;
    }
    //Si esta vacio el campo destino
    if (empty($_POST['destino'])) {
        $mensajeError .= "ERROR: No se ha rellenado el campo destino</br>";
        $existeError = true;
    }
    //Si esta vacio el campo fecha
    if (empty($_POST['fecha'])) {
        $mensajeError .= "ERROR: No se ha rellenado el campo fecha</br>";
        $existeError = true;
    }
    //Si esta vacio el campo descuentos
    if (empty($_POST['descuentos'])) {
        $mensajeError .= "ERROR: No se ha rellenado el campo descuentos</br>";
        $existeError = true;
    }
    //Si esta vacio el campo asientos
    if (empty($_POST['asientos'])) {
        $mensajeError .= "ERROR: No se ha rellenado el campo asientos</br>";
        $existeError = true;
    //Si el numero de billetes no es igual al numero de asientos seleccionados
    } else if ((int)$_POST['billetes'] != count($_POST['asientos'])) {
        $mensajeError .= "ERROR: Los Billetes y asientos seleccionados no coinciden</br>";
        $existeError = true;
    }
    //Si no existen errores
    if (!$existeError) {
        $mensajeOk .= "Origen seleccionado: " . $_POST['origen'] . "</br>";
        $mensajeOk .= "Destino seleccionado: " . $_POST['destino'] . "</br>";
        $mensajeOk .= "Fecha seleccionada: " . $_POST['fecha'] . "</br>";
        $mensajeOk .= "Nº Billetes seleccionados: " . $_POST['billetes'] . "</br>";
        $mensajeOk .= "Descuento seleccionado: " . array_search($_POST['descuentos'], $descuentos) . " (". $_POST['descuentos'] . "%) aplicado</br>";
        $mensajeOk .= "Asientos seleccionados: ";
        //Recorremos array de asientos para mostrarlos en formato de cadena
        foreach ($_POST['asientos'] as $asiento) {
            $mensajeOk .= $asiento.", ";
        }
        $mensajeOk .= "</br></br>";
        $mensajeOk .= "Precio base de billete: " . number_format((float)$precioBillete, 2) . " €</br></br>";
        //Calculamos el descuento final y el precio del billete con los datos obtenidos previamente
        $descuentoCalculado = ($precioBillete * (int)$_POST['billetes']) / 100 * (float)$_POST['descuentos'];
        $precioFinal = (float)$precioBillete * (int)$_POST['billetes'] - (float)$descuentoCalculado;
        $mensajeOk .= "Precio final del billete es de: " . number_format($precioFinal, 2) . " €";
    }
}

//Si pulsamos el boton btConfirmar validamos el formulario del billete
if (isset($_POST["btConfirmar"])) {
    validarBillete($mensajeError, $mensajeOk, $descuentos, $precioBillete);
}

?>

<html>
    <body>
        <form style='width:800px;' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <fieldset>
                <div>
                    <h2 style='text-align:center'>Servicio de compra de billetes on-line</h2>
                </div>
                <div>
                    <label for="origen">Origen:</label>
                    <input type="text" name="origen" required/>
                    <label for="destino">Destino:</label>
                    <input type="text" name="destino" required/>
                    <label for="fecha">Fecha:</label>
                    <input type="date" name="fecha" required/>
                </div>
                </br>
                <div>
                    <label for="billetes">Nº Billetes:</label>
                    <select style='width:40px;' name="billetes">
                    <?php 
                        //Llamamos a funcion cargarBilletes
                        cargarBilletes($maxBilletes);						
                    ?>	
                    </select>
                </div>
                </br>
                <div>
                    <label>Descuentos:</label></br>
                    <?php 
                        //Llamamos a funcion cargarDescuentos
                        cargarDescuentos($descuentos);						
                    ?>	
                </div>
                </br>
                <div>
                    <label>Elige los asientos:</label></br>
                    <?php 
                        //Llamamos a funcion cargarAsientos
                        cargarAsientos($maxAsientos);						
                    ?>	
                </div>
                </br>
                <div class="button">
                    <button type="submit" name="btConfirmar">Confirmar</button>
                </div>
            </fieldset>
        </form>
        <div>
            <span style='color:red;'><?php echo $mensajeError; ?></span>
            <span style='color:green;'><?php echo $mensajeOk; ?></span>
        </div>
    </body>
</html>
