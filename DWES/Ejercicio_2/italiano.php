<?php

//Declaramos variables utilizadas
$anos = 6;
$intereses = 7;
$capital = 580000;
$capitalAux = $capital;
$capitalAmortizado = 0;
$cuotaAnual = "";
$interesesAux = "";
$cuotaAmortizacion = "";

//Creamos cabecera de documento html y tabla
echo "<html>";
echo "<body>";
echo "<table border='1' align='center'>";
echo "<tr>";
echo "<th align='center' width='100px'>Año</th>";
echo "<th align='center' width='100px'>Cuota anual</th>";
echo "<th align='center' width='100px'>Intereses</th>";
echo "<th align='center' width='100px'>Cuota de amortización</th>";
echo "<th align='center' width='100px'>Capital por amortizar</th>";
echo "<th align='center' width='100px'>Capital amortizado</th>";
echo "</tr>";

//Iteramos por el numero de anios almacenados
for ($i = 0; $i <= $anos; $i++) {
    //Realizamos calculos a partir de la segunda iteracion
    if ($i != 0) {
        $interesesAux = $capitalAux / 100 * $intereses;
        $cuotaAmortizacion = $capital / $anos;
        $capitalAux -= $cuotaAmortizacion;
        $capitalAmortizado += $cuotaAmortizacion;
        $cuotaAnual = $interesesAux + $cuotaAmortizacion;
    } 
	echo "<tr>";
	echo "<td align='center'>",$i,"</td>";
    //Formateamos texto convirtiendo valor a real y mostrando 2 decimales
    echo "<td align='center'>",number_format((float)$cuotaAnual, 2),"</td>";
    echo "<td align='center'>",number_format((float)$interesesAux, 2),"</td>";
    echo "<td align='center'>",number_format((float)$cuotaAmortizacion, 2),"</td>";
    echo "<td align='center'>",number_format((float)$capitalAux, 2),"</td>";
    echo "<td align='center'>",number_format((float)$capitalAmortizado, 2),"</td>";
	echo "</tr>";
}
echo "</table>";
echo "</body>";
echo "</html>";

?>
