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
    <form id="crear" name="form" action="{{$destino}}" method="POST">
        <label for='nombre'>Nombre </label>
		<input type ="text" id='nombre' name='nombre' placeholder ='Nombre'><br><br>
        <label for='apellidos'>Apellidos </label>
		<input type ="text" id='apellidos' name='apellidos' placeholder ='Apellido'><br><br>
        <label for='dorsal'>Dorsal </label>
		<input type ="number" id='dorsal' name='dorsal' placeholder ='Dorsal'><br><br>
        <label for='posicion'>Posición </label>
        <!--Recorremos array de posiciones enviado desde controlador y montamos select con las opciones del mismo-->
		<select id='posicion' name='posicion'>
            @foreach($posiciones as $item)
                <option value="{{$item}}">{{$item}}</option>
            @endforeach
        </select><br><br>
        <label for='codigo'>Código de barras </label>
		<input type ="text" id='codigo' name='barcode' value='{{$barcode}}' placeholder ='Codigo de barras' readonly><br><br>
        <input id="btcrear" type="submit" name="crear" value="Crear"/>
        <input id="btlimpiar" type="reset" name="limpiar" value="Limpiar"/>
        <a href='{{$volver}}'><input id="btvolver" type='button' value='Volver'/></a>
        <a href='{{$generarBarcode}}'><input id="btgenerar" type='button' value='Generar Barcode'/></a>
    </form>
@endsection