@extends('layout')

@section('titulo', 'Reporte Estadístico')

@section('contenido')
<h2 class="text-center mb-4">📊 Reporte Estadístico</h2>

@if(session('error'))
    <div class="alert alert-danger text-center">{{ session('error') }}</div>
@endif

<table class="table table-bordered w-50 mx-auto text-center">
    <thead class="thead-dark">
        <tr>
            <th>Nombre del Reporte</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Reporte de Tipos de Juegos</td>
            <td>
                <a href="{{ route('reporte.mostrar') }}" class="btn btn-info">Mostrar Estadística</a>
            </td>
        </tr>
        
        </tr>
    </tbody>
</table>
@endsection
