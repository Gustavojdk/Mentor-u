<!-- Barra de Identificación -->
<div class="bg-blue px-4 py-3  text-white" style="background-color:rgb(60, 112, 255);">
    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <!-- Imagen a la izquierda -->
        <div>
            <img src="{{ asset('images/MentorU.jfif') }}" alt="Logo" style="height: 150px;">
        </div>

        <div>
            <span class="font-weight-bold">Usuario:</span> {{ session('usuario') ?? 'user123' }}
        </div>

        <div>
            <span class="font-weight-bold">Grupo:</span> 3
        </div>

        <div>
            <span class="font-weight-bold">Proyecto:</span> SistemasdeInfomación
        </div>

        <div>
            <span class="font-weight-bold">Material Estudio:</span> Documentos
        </div>

        <div>
            <span class="font-weight-bold">Estado:</span> Activo
        </div>

        <div>
            <span class="font-weight-bold">Fecha y Hora:</span> 
            <span id="reloj"></span>
        </div>

    </div>
</div>

<!-- Script para reloj en tiempo real -->
<script>
    function actualizarReloj() {
        const ahora = new Date();
        const fechaHora = ahora.toLocaleString();
        document.getElementById('reloj').textContent = fechaHora;
    }

    actualizarReloj();
    setInterval(actualizarReloj, 1000);
</script>

