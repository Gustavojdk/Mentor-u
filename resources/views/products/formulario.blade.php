@extends('layout')
@section('titulo','Nuevo Producto')

@section('contenido')
<h2>Agregar Producto</h2>
<form action="{{ route('productos.guardar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3"><label>Nombre:</label><input type="text" name="nombre" class="form-control" required></div>
    <div class="mb-3"><label>Precio:</label><input type="number" name="precio" step="0.01" class="form-control" required></div>
    <div class="mb-3"><label>Tipo:</label><input type="text" name="tipo" class="form-control" required></div>
    <div class="mb-3"><label>Descripción:</label><textarea name="descripcion" class="form-control" required></textarea></div>
    <div class="mb-3"><label>Imagen (opcional):</label><input type="file" name="imagen" class="form-control"></div>
    <button type="submit" class="btn btn-primary">Finalizar</button>
</form>
<center>
        <a href="{{ url('/panel') }}" class="btn btn-primary" style="margin: 20px;">
            <i class="fas fa-home"></i> Volver al Inicio
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">← Volver</a>
 </center>
@endsection
