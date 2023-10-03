<!--Llamamos a plantilla genérica-->
@extends('plantillas.plantilla1')
@section('titulo')
    {{$titulo}}
@endsection
<!--Llamamos a plantilla con encabezado-->
@section('encabezado')
    {{$encabezado}}
@endsection
<!--Creamos plantilla para en contenido de la propia página-->
@section('contenido')
<div id="listado">
    <!--Si existe la variable mensaje y tiene contenido, la mostramos en su propio párrafo-->
    @if($mensaje)
        <p>{{$mensaje}}</p>
    @endif
    <a href='{{$destino}}'><input class="boton" type='button' value='Nuevo Jugador'/></a><br><br>
    <table id="table">
        <thead>
            <tr>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Posición</th>
                <th scope="col">Dorsal</th>
                <th scope="col">Codigo de Barras</th>
            </tr>
        </thead>
        <tbody>
        <!--Recorremos colección de jugadores recibida desde el controlador-->
        @foreach($jugadores as $item)
            <tr>
                <td>{{$item->nombre}} {{$item->apellidos}}</td>
                <td>{{$item->posicion}}</td>
                <td>
                    <!--Si el dorsal está vacío mostramos el texto 'Sin asignar', esta lógica no se va a realizar nunca
                        puesto que dicho campo está capado a nivel de bbdd y no puede estar vacío, aunque el ejercicio
                        requería realizar tal comprobación por lo que se ha tenido en cuenta-->
                    @if(empty($item->dorsal))
                        Sin asignar
                    @else
                        {{$item->dorsal}}
                    @endif
                </td>
                <!--Representamos código de barras usando php y el objeto dns recibido desde el controlador-->
                <td id="barras"><?php echo $dns->getBarcodeHTML($item->barcode, 'EAN13', 2, 33, 'white'); ?></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection