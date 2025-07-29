@extends('layout')

@section('titulo', 'Contador de Productos')

@section('contenido')
    <div class="container text-center mt-5">
        <h2>📦 Total de Productos Registrados</h2>
        <p style="font-size: 24px; font-weight: bold;">{{ $cantidad }}</p>

        @if (count($porTipo) > 0)
            <h4 class="mt-4">Distribución por tipo:</h4>
            <table class="table table-bordered w-50 mx-auto mt-3">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($porTipo as $tipo => $conteo)
                        <tr>
                            <td><a href="{{ route('products.porTipo', $tipo) }}" class="btn btn-outline-primary">
                                {{ $tipo }}</a></td>
                            <td>{{ $conteo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay productos registrados con tipo.</p>
        @endif

        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-4">← Volver a la Lista</a>
    </div>
@endsection
