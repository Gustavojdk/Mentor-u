@extends('layout') {{-- O usa layout de SB Admin 2 que estés usando --}}

@section('titulo','VisualizarMaterial')
@section('contenido')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Lista de PDFs</h1>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Materia</th>
                <th>Nombre del PDF</th>
                <th>Ver</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pdfs as $pdf)
            <tr>
                <td>{{ $pdf['nombre'] }}</td>
                <td>{{ $pdf['materia'] }}</td>
                <td>{{ $pdf['archivo'] }}</td>
                <td>
                    <a href="{{ asset('storage/pdfs/' . $pdf['archivo']) }}" target="_blank" class="btn btn-sm btn-primary">Abrir</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
