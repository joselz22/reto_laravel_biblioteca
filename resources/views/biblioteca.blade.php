<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Biblioteca</title>
    <link rel="stylesheet" href="{{asset('biblioteca.css')}}">
</head>
<body>
<h1>Biblioteca</h1>

@if(session('error'))
    <p class='err'>{{ session('error') }}</p>
@endif

@if(isset($mensaje))
    <p class='ok'>{{ $mensaje }}</p>
@endif

<form method='POST' action='/biblioteca'>
    @csrf
    <label>Nombre del usuario</label>
    <input type='text' name='nombre' value='{{ old('nombre') }}'>

    <label>PIN</label>
    <input type='password' name='pin'>

    <label>Nombre del libro</label>
    <input type='text' name='libro' value='{{ old('libro') }}'>

    <br><br>
    <button type='submit' name='accion' value='prestar'>Prestar</button>
    <button type='submit' name='accion' value='devolver'>Devolver</button>
</form>

@if(isset($usuario))
    <p>Libros prestados actualmente por <strong>{{ $usuario->nombre }}</strong>:
       <strong>{{ $usuario->prestados }}</strong></p>
@endif

<h2>Historial de prestamos</h2>
@if($prestamos->isEmpty())
    <p>Sin registros.</p>
@else
    <table>
        <tr><th>Usuario</th><th>Libro</th><th>Fecha</th></tr>
        @foreach($prestamos as $m)
            <tr>
                <td>{{ $m->usuario->nombre }}</td>
                <td>{{ $m->libro }}</td>
                <td>{{ $m->fecha }}</td>
            </tr>
        @endforeach
    </table>
@endif

<h2>Historial de devoluciones</h2>
@if($devoluciones->isEmpty())
    <p>Sin registros.</p>
@else
    <table>
        <tr><th>Usuario</th><th>Libro</th><th>Fecha</th></tr>
        @foreach($devoluciones as $m)
            <tr>
                <td>{{ $m->usuario->nombre }}</td>
                <td>{{ $m->libro }}</td>
                <td>{{ $m->fecha }}</td>
            </tr>
        @endforeach
    </table>
@endif

</body>
</html>