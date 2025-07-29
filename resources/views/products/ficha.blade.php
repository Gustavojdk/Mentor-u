@extends('layout')
@section('titulo','Ficha del Producto')

@section('contenido')
<div class="card mt-5 mx-auto" style="width: 25rem;">
    <img src="{{ asset('images/' . $producto['imagen']) }}" class="card-img-top" alt="{{ $producto['nombre'] }}">
    <div class="card-body">
        <h5 class="card-title">{{ $producto['nombre'] }}</h5>
        <p class="card-text"><strong>Tipo:</strong> {{ $producto['tipo'] }}</p>
        <p class="card-text"><strong>Precio:</strong> ${{ number_format($producto['precio'], 2) }}</p>
        <p class="card-text">{{ $producto['descripcion'] }}</p>
    </div>
</div>
<center>
        <a href="{{ url('/panel') }}" class="btn btn-primary" style="margin: 20px;">
            <i class="fas fa-home"></i> Volver al Inicio
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">← Volver</a>
 </center>
@endsection
