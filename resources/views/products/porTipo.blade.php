@extends('layout')

@section('titulo', "Productos de tipo: $tipo")

@section('contenido')
<div class="container mt-4">
    <h2 class="text-center mb-4">🎮 Juegos del tipo: <strong>{{ $tipo }}</strong></h2>
    <div class="row">
        @forelse ($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <img src="{{ asset('images/' . $producto['imagen']) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Imagen">
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto['nombre'] }}</h5>
                        <p class="card-text"><strong>Tipo:</strong> {{ $producto['tipo'] }}</p>
                        <p class="card-text"><strong>Precio:</strong> ${{ number_format($producto['precio'], 2) }}</p>
                        <p class="card-text"><strong>Descripción:</strong> {{ $producto['descripcion'] }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No hay productos de este tipo.</p>
        @endforelse
    </div>

    <div class="text-center">
        <a href="{{ route('products.contar') }}" class="btn btn-secondary mt-4">← Volver al conteo</a>
    </div>
</div>
@endsection
