@extends('layout')

@section('titulo', 'Comandos por Señas (Video)')

@section('contenido')
<h2 class="text-center mb-4">🎥 Señales Manuales para Agregar/Eliminar</h2>

<video id="video" width="320" height="240" autoplay muted style="border:1px solid #ccc"></video>
<p id="output" class="text-center my-3">Esperando gesto...</p>

<form id="videoForm" method="POST" action="{{ route('comando.video.procesar') }}">
    @csrf
    <input type="hidden" name="comando" id="comandoInput">
</form>

@if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger text-center">{{ session('error') }}</div>
@endif

<a href="{{ route('home') }}" class="btn btn-secondary">← Volver</a>

<script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js"></script>
<script>
const video = document.getElementById('video');
const output = document.getElementById('output');
const input = document.getElementById('comandoInput');

// Inicia cámara
navigator.mediaDevices.getUserMedia({ video: true })
  .then(stream => video.srcObject = stream);

// Configura MediaPipe Hands
const hands = new Hands({locateFile: (file) =>
  `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`
});

hands.setOptions({ maxNumHands: 1, minDetectionConfidence: 0.7 });
hands.onResults(onResults);

const camera = new Camera(video, {
  onFrame: async () => await hands.send({ image: video }),
  width: 320, height: 240
});
camera.start();

let lastCommand = '';
function onResults(results) {
    if (!results.multiHandLandmarks || results.multiHandLandmarks.length === 0) {
        output.innerText = 'Esperando gesto...';
        return;
    }

    const lm = results.multiHandLandmarks[0];

    const thumbUp = lm[4].y < lm[3].y;
    const indexUp = lm[8].y < lm[6].y;
    const middleUp = lm[12].y < lm[10].y;

    let comando = '';

    if (thumbUp && !indexUp && !middleUp) {
        comando = 'eliminar ejemplo';
    } else if (thumbUp && indexUp && !middleUp) {
        comando = 'agregar ejemplo con precio 1 tipo demo descripcion prueba';
    }

    if (comando && comando !== lastCommand) {
        lastCommand = comando;
        output.innerText = '✋ Gesto detectado: ' + comando;
        input.value = comando;
        setTimeout(() => document.getElementById('videoForm').submit(), 800);
    }
    let productoEjemplo = 'pacman'; // luego podrías mapear el gesto a un producto
if (thumbUp && !indexUp && !middleUp)
    comando = `eliminar ${productoEjemplo}`;
if (thumbUp && indexUp && !middleUp)
    comando = `agregar ${productoEjemplo} con precio 5 tipo clasico descripcion divertido`;

}

</script>
@endsection
