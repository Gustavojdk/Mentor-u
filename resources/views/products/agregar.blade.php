@extends('layout')
@section('titulo','Agregar Producto')

@section('contenido')
<h2>Productos actuales</h2>
<table class="table">
    <thead>
        <tr><th>Nombre</th><th>Precio</th><th>Tipo</th><th>Descripción</th><th>Imagen</th></tr>
    </thead>
    <tbody>
        @foreach($productos as $p)
        <tr>
            <td>{{ $p['nombre'] }}</td>
            <td>${{ number_format($p['precio'], 2) }}</td>
            <td>{{ $p['tipo'] }}</td>
            <td>{{ $p['descripcion'] }}</td>
            <td><img src="{{ asset('images/' . $p['imagen']) }}" width="60"></td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('productos.formulario') }}" class="btn btn-success">Agregar</a>
 <center>
        <a href="{{ url('/panel') }}" class="btn btn-primary" style="margin: 20px;">
            <i class="fas fa-home"></i> Volver al Inicio
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">← Volver</a>
 </center>
@endsection
