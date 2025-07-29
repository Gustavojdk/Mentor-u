@extends('layout')

@section('titulo','Panel administrativo')

@section('contenido')

        <div class="row">
            <!-- Usuarios Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                 <div class="card-body">
                     <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    UsuariosConectados</div>
                             <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsuariosDB }}</div>
                            </div>
                        <div class="col-auto">
                           <i class="fas fa-users fa-2x text-gray-300"></i>
                         </div>
                    </div>
                </div>
            </div>
        </div>

                       

<hr class="mt-5">
<h3 class="text-center my-5">pdfs</h3>
<div class="row">
    @forelse($productos as $producto)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow">
                <img src="{{ asset('images/' . $producto['imagen']) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Imagen de {{ $producto['nombre'] }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $producto['nombre'] }}</h5>
                    <p class="card-text"><strong>Tipo:</strong> {{ $producto['tipo'] }}</p>
                    <p class="card-text"><strong>Precio:</strong> ${{ number_format($producto['precio'], 2) }}</p>
                    <p class="card-text"><strong>Descripción:</strong> {{ $producto['descripcion'] }}</p>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center w-100">No hay productos disponibles.</p>
    @endforelse
</div>



        </div>
@endsection
