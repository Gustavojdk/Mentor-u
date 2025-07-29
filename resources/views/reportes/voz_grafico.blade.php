@extends('layout')

@section('titulo', 'Uso de Comando de Voz')

@section('contenido')
<h2 class="text-center mb-4">📢 Estadística de Uso de Comando de Voz</h2>

<div class="container text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <canvas id="vozChart" class="img-fluid"></canvas>
        </div>
    </div>
</div>

<a href="{{ route('reporte.index') }}" class="btn btn-secondary mt-4">← Volver</a>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const etiquetas = @json(array_keys($datos));
    const valores = @json(array_values($datos));
    const colores = etiquetas.map((_, i) => `hsl(${i * 40}, 70%, 60%)`);

    new Chart(document.getElementById('vozChart'), {
        type: 'bar',
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Comandos de Voz Usados por Día',
                data: valores,
                backgroundColor: colores
            }]
        }
    });
</script>
@endsection
