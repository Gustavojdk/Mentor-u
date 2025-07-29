@extends('layout')

@section('titulo', 'Usuarios Registrados')

@section('contenido')
    <h2 class="text-center mb-4">👥 Usuarios Registrados</h2>

    @if (count($usuarios) > 0)
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $index => $usuario)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $usuario['usuario'] }}</td>
                        <td>{{ $usuario['password'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center">No hay usuarios registrados aún.</p>
    @endif

    <div class="text-center mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">← Volver</a>
        <a href="{{ url('/panel') }}" class="btn btn-primary">🏠 Inicio</a>
    </div>
@endsection
