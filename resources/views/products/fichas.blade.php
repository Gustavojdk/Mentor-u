@extends('layout')

@section('titulo', 'Ficha del Producto')

@section('contenido')
<h2 class="text-center mb-4">Producto Actualizado</h2>

<div class="d-flex justify-content-center">
    <div class="card shadow p-3" style="width: 22rem;">
        <img src="{{ asset('images/' . $producto['imagen']) }}" class="card-img-top" alt="Imagen del producto">
        <div class="card-body text-center">
            <h5 class="card-title">{{ $producto['nombre'] }}</h5>
            <p class="card-text"><strong>Precio:</strong> ${{ number_format($producto['precio'], 2) }}</p>
            <p class="card-text"><strong>Tipo:</strong> {{ $producto['tipo'] }}</p>
            <p class="card-text"><strong>Descripción:</strong> {{ $producto['descripcion'] }}</p>
            <a href="{{ route('productos.editar.tabla') }}" class="btn btn-primary mt-3">← Volver a Productos</a>
        </div>
    </div>
</div>
@endsection
