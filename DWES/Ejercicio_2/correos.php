				
<?php

//Declaramos array de correos inicializado
$correos = array("Juan" => "juan@yahoo.es",
                 "Pablo" => "pablo@yahoo.es",   
                 "Elena" => "elena@yahoo.es",
                 "Pedro" => "pedro@yahoo.es",
                 "Andres" => "andres@yahoo.es",
                 "Laura" => "laura@yahoo.es"
                );
//Variable usada para mostrar mensajes de error en rojo
$mensajeError = "";
//Variable usada para mostrar mensajes de info en verde
$mensajeOk = "";

//Funcion usada para recorrer array de correos y mostrarlos en formato tabla
function cargarTabla($correos) {
    //Cargamos cabecera de tabla
    echo '<table aling="center" border="1" cellpadding="2" cellspacing="2">';
    echo '<tbody style="background-color: grey; text-align: center; font-weight: bold">';
    echo '<td width="100px">Nombre</td>';
    echo '<td width="100px">Correo</td>';
    echo '</tbody>';
    $sw = true;
    //Recorremos correos iterando por su clave -> valor
    foreach ($correos as $nombre => $correo) {
        //Usamos ternario para cambiar los colores de las celdas alternandolos
    	$color = ($sw) ? "yellow" : "pink";
        echo "<tr>";
	    echo "<td style='background-color:",$color,"'>",$nombre,"</td>";
        echo "<td style='background-color:",$color,"'>",$correo,"</td>";
	    echo "</tr>";
        //Invertimos booleano para ir cambiando el color
        $sw = !$sw;
    }
    echo "</table>";
}

//Funcion usada para agregar nuevos elementos al array de correos por referencia (con un ambito global) o capturar mensaje de error
function anadirDato(&$correos, &$mensajeError) {
    //Si existe el nombre dentro del array de correos
    if (array_key_exists($_POST['nombre'], $correos)) {
        $mensajeError = "ERROR: ya existe el Nombre de " . $_POST['nombre'] . " almacenado";
    //Si los valores del nombre y correo no estan vacios
    } else if (!empty($_POST['nombre']) && !empty($_POST['correo'])) {
        $correos[$_POST['nombre']] = $_POST['correo'];
    //En caso contrario
    } else {
        $mensajeError = "ERROR: No se han rellenado los campos Nombre y Correo";
    } 
}

//Funcion usada para consultar los correos del array o capturar mensaje de error
function consultarCorreo($correos, &$mensajeError, &$mensajeOk) {
    //Si esta vacio el campo nombre
    if (empty($_POST['nombre'])) {
        $mensajeError = "ERROR: No se han rellenado el campo Nombre";
    //Si existe el nombre dentro del array de correos
    } else if (array_key_exists($_POST['nombre'], $correos)) {
        $mensajeOk = "El Correo de " . $_POST['nombre'] . " es: " . $correos[$_POST['nombre']];
    //En caso contrario
    } else {
        $mensajeError = "ERROR: El Nombre de " . $_POST['nombre'] . " no está almacenado";
    } 
}

//Si se realizan consecutivas cargas de la pagina, recuperamos los datos  del array correos para no perder elementos
if (isset($_POST["correos"])) {
    $correos = unserialize($_POST["correos"]);
} 
//Si pulsamos btAnadir en formulario
if (isset($_POST['btAnadir'])) {
    anadirDato($correos, $mensajeError);
}
//Si pulsamos btCorreo en formulario
if (isset($_POST["btCorreo"])) {
    consultarCorreo($correos, $mensajeError, $mensajeOk);
}

//Llamamos a funcion cargarTabla mandando el array de correos declarado previamente
cargarTabla($correos);

?>

<html>
    <body>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <!-- Creamos variable oculta (hidden) para poder recuperar los datos de los correosen futuras recargas de la pagina -->
            <input type="hidden" name="correos" value='<?php echo serialize($correos); ?>'>
            <div>
                <h3>Agenda: Nombres y Correos</h3>
            </div>
            <div>
                <label for="nombre">Introduce un nombre:</label>
                <input type="text" name="nombre" />
            </div>
            <div>
                <label for="correo">Introduce un correo:</label>
                <input type="text" name="correo" />
            </div>
            </br>
            <div class="button">
                <button type="submit" name="btCorreo">Ver el Correo</button>
                <button type="submit" name="btAnadir">Añadir</button>
            </div>
        </form>
        <div>
            <span style='color:red;'><?php echo $mensajeError; ?></span>
            <span style='color:green;'><?php echo $mensajeOk; ?></span>
        </div>
    </body>
</html>
