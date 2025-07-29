@extends('layout')

@section('titulo', 'Comandos de Voz')

@section('contenido')
<h2 class="text-center mb-4">🎙️ Ejecutar Comandos por Voz</h2>

@if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
@endif
@if(session('validacion'))
    <div class="alert alert-info">{{ session('validacion') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger text-center">{{ session('error') }}</div>
@endif



<div class="text-center mb-4">
    <button onclick="startRecognition()" class="btn btn-primary">🎤 Escuchar Comando</button>
</div>

<form action="{{ route('voz.procesar') }}" method="POST" id="comandoForm">
    @csrf
    <input type="hidden" name="comando" id="comandoInput">
</form>

<script>
    function startRecognition() {
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = 'es-ES';

        recognition.onresult = function(event) {
            const comando = event.results[0][0].transcript;
            document.getElementById('comandoInput').value = comando;
            document.getElementById('comandoForm').submit();
        };

        recognition.onerror = function(event) {
            alert('Error en reconocimiento de voz: ' + event.error);
        };

        recognition.start();
    }
</script>
@endsection


