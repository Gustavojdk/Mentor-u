@extends('layout')

@section('titulo', 'Editar Producto')

@section('contenido')
<h2 class="text-center mb-4">Editar Producto</h2>

@if(session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('productos.guardar.edicion', ['index' => old('index', $producto['index'])]) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="container w-50">
        {{-- Campo oculto para el índice y la imagen actual --}}
        <input type="hidden" name="index" value="{{ old('index', $producto['index']) }}">
        <input type="hidden" name="imagen_actual" value="{{ old('imagen_actual', $producto['imagen']) }}">

        <div class="form-group mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $producto['nombre']) }}" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Precio</label>
            <input type="number" name="precio" step="0.01" value="{{ old('precio', $producto['precio']) }}" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Tipo</label>
            <input type="text" name="tipo" value="{{ old('tipo', $producto['tipo']) }}" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required>{{ old('descripcion', $producto['descripcion']) }}</textarea>
        </div>

        <div class="form-group mb-4">
            <label>Imagen (opcional)</label><br>
            <img src="{{ asset('images/' . $producto['imagen']) }}" width="120" class="mb-2" alt="Imagen actual">
            <input type="file" name="imagen" class="form-control-file">
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Finalizar</button>
        </div>
    </div>
</form>
@endsection
