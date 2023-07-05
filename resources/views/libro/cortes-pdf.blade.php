<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     
     <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>   
    
<style>
    .mi-tabla {
    width: 100%;
    border-collapse: collapse;
}
tr {
    background-color: #f5f5f5;
}
th {
    padding: 3px;
    border: 1px solid #5f5e5e52;
}
td {
    padding: 3px;
    border: 1px solid #5f5e5e52;
}

</style>
    
    <title>Document</title>
</head>
<body>
    <table class="mi-tabla">
        <thead>
            <tr >
                <th>Nombre</th>
                <th>Zona</th>
                <th>Corte</th>
                <th>Dirección</th>
                <!-- Agrega más encabezados de columna si es necesario -->
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as  $contac)
            <tr>
                <td>{{ $contac->first_name }}{{"   "}}{{$contac->last_name }}</td>
                <td>{{ $contac->zona }}</td>
                
                <td>{{ $contac->direccion }}</td>
                <td>CORTE</td>
                <!-- Agrega más celdas si es necesario para mostrar otros atributos de la deuda -->
            </tr>
            @endforeach
        </tbody>
    </table>
 
    
</body>
</html>