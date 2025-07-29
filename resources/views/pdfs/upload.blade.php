@extends('layout')

@section('titulo', 'Subir PDF')

@section('contenido')
<div class="container mt-4">
    <h2 class="mb-4">Subir nuevo PDF</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('pdfs.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Materia:</label>
            <input type="text" name="materia" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Archivo PDF:</label>
            <input type="file" name="archivo" class="form-control-file" accept="application/pdf" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Subir</button>
    </form>
</div>
@endsection