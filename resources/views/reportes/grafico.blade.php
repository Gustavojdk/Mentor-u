@extends('layout')

@section('titulo', 'Gráfica Estadística')

@section('contenido')
<h2 class="text-center mb-4">📈 Estadística de Tipos de Juegos</h2>

<div class="container text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <canvas id="barChart" class="img-fluid"></canvas>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <canvas id="pieChart" class="img-fluid"></canvas>
        </div>
    </div>
</div>


<a href="{{ route('reporte.index') }}" class="btn btn-secondary mt-4">← Volver</a>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const datos = @json(array_values($datos));
    const etiquetas = @json(array_keys($datos));

     const colores = etiquetas.map((_, i) => `hsl(${i * 50 % 360}, 70%, 60%)`);

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Cantidad por Tipo',
                data: datos,
                backgroundColor: colores
            }]
        }
    });

    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: etiquetas,
            datasets: [{
                data: datos,
                backgroundColor: colores
            }]
        }
    });
</script>
@endsection