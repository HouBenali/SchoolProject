<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--
    <link rel="stylesheet" href="{{ secure_asset("css/app.css") }}"> --}}
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
    <title>Módulo admin</title>
</head>

<body>
    <div id="app">
        <header-component></header-component>
        <div class="container" >
            @yield('content')
        </div>
    </div>
    
    {{-- 
    <script src="{{ secure_asset("js/app.js") }}"></script> --}}
    <script src="{{ asset("js/app.js") }}"></script>
</body>

</html>