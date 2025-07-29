<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>LoginMentorU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <style>
        body {
            background-color:rgb(212, 197, 112); /* Color azulado claro */
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100 ">
    <div class="card p-4 shadow text-center" style="width: 400px;">
    <img src="{{ asset('images/MentorU.jfif') }}" alt="Logo" style="height: 300px;" class="mb-3 mx-auto">
    <h3 class="mb-3">Iniciar Sesión a MentorU</h3>

    {{-- Mensajes --}}
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    {{-- FORM LOGIN --}}
    <form method="POST" action="{{ route('login.custom') }}">
        @csrf
        <div class="mb-3 text-start">
            <label for="username" class="form-label">Nombre</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3 text-start">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>

    {{-- Botón hacia formulario de registro --}}
    <form method="POST" action="{{ route('registro.custom') }}" class="mt-3">
        @csrf
        <input type="hidden" name="username" value="{{ old('username') }}">
        <input type="hidden" name="password" value="{{ old('password') }}">
        <button type="submit" class="btn btn-secondary w-100">Registrarse</button>
    </form>
</div>
</body>
</html>
