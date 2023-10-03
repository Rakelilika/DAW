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
    <!--<a href='crearDatos.php'><input type='button' value='Instalar Datos de Ejemplo'/></a>-->
    <!--Hemos optado por realizar la llamada a la página destino usando el action de un formulario,
        en otras vistas hemos realizado dicha redirección usando un botón como enlace-->
    <form id="instalacion" name="form" action="{{$destino}}" method="POST">
        <input class="boton" type="submit" name="cambiar" value="Instalar Datos de Ejemplo"/>
    </form>
@endsection