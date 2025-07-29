@extends('layout')

@section('titulo','Productos')

@section('contenido')
    <h2 style="text-align:center;">Lista de Productos</h2>
    <style>
        body {
            background-image: url('{{ asset('images/fondo.jpg') }}');
            background-size: cover;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        table {
            margin: auto;
            border-collapse: collapse;
            width: 50%;
            background: rgba(255, 255, 255, 0.8);
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
        }
    </style>
    <table style="border-collapse: collapse; width: 50%; margin: 20px auto;">
       <thead>
        <tr>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Tipo</th>
        <th>Descripción</th>
        </tr>
       </thead>
        <tbody>
            @foreach ($productos as $producto)
            <tr>
              <td> <div class="d-flex align-items-center">
                    <img src="{{ asset('images/' . $producto['imagen']) }}" alt="img" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                        {{ $producto['nombre'] }}
                   </div>
              </td>
             <td>${{ number_format($producto['precio'], 2) }}</td>
              <td>{{ $producto['tipo'] }}</td>
             <td>{{ $producto['descripcion'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <center>
        <a href="{{ url('/panel') }}" class="btn btn-primary" style="margin: 20px;">
            <i class="fas fa-home"></i> Volver al Inicio
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">← Volver</a>
        <a href="{{ route('products.contar') }}" class="btn btn-info" style="margin: 10px;">
        Contar Productos
        </a>
    </center>
    
@endsection
