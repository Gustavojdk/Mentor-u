@extends('layout') {{-- O usa layout de SB Admin 2 que estés usando --}}

@section('titulo', 'Buscar Material')

@section('contenido')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Buscar Material</h1>

    <form action="{{ route('pdfs.buscar') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre, materia o PDF..." value="{{ old('buscar', $termino ?? '') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">🔍 Buscar</button>
            </div>
        </div>
    </form>

    @isset($resultados)
        @if(count($resultados) > 0)
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Materia</th>
                        <th>PDF</th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resultados as $pdf)
                    <tr>
                        <td>{{ $pdf['nombre'] }}</td>
                        <td>{{ $pdf['materia'] }}</td>
                        <td>{{ $pdf['archivo'] }}</td>
                        <td>
                            <a href="{{ asset('storage/pdfs/' . $pdf['archivo']) }}" target="_blank" class="btn btn-sm btn-success">📄 Ver</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning">
                No se encontraron resultados para: <strong>{{ $termino }}</strong>
            </div>
        @endif
    @endisset
</div>
@endsection
