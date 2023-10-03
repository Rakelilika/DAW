<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>@yield('titulo')</title>
</head>
<body>
    <div>
        <h3>@yield('encabezado')</h3>
        @yield('contenido')
    </div>
</body>
</html>
