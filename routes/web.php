<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PdfController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ComandoVozController;
use App\Http\Controllers\ComandoVideoController;

//Route::view('dashboard', 'dashboard')
    //->middleware(['auth', 'verified'])
    //->name('dashboard');

//Route::middleware(['auth'])->group(function () {
    //Route::redirect('settings', 'settings/profile');

    //Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    //Volt::route('settings/password', 'settings.password')->name('settings.password');
    //Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
//});

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    // Guardar en un archivo txt
    $data = "Usuario: $username | Contraseña: $password" . PHP_EOL;
    File::append(storage_path('app/usuarios.txt'), $data);

    session(['usuario' => $username]); // Guardas usuario en sesión si quieres usarlo luego

    //Redirigir al panel
    return redirect()->route('home')->with('success', 'Usuario registrado y conectado correctamente.');
})->name('login.custom');



Route::get('/panel', [HomeController::class,'index'])->name('home');
Route::resource(name: '/products',controller: ProductController::class);



//agregar productos
Route::get('/productos/agregar', [ProductController::class, 'vistaAgregar'])->name('productos.agregar');
Route::get('/productos/formulario', [ProductController::class, 'formulario'])->name('productos.formulario');
Route::post('/productos/formulario', [ProductController::class, 'guardarFormulario'])->name('productos.guardar');


// Mostrar la vista para borrar productos
Route::get('/productos/borrar', [ProductController::class, 'borrarVista'])->name('products.delete');

// Eliminar un producto específico
Route::post('/productos/borrar/{index}', [ProductController::class, 'borrar'])->name('products.destroy');


Route::get('/usuarios', function () {
    $usuarios = [];

    $path = storage_path('app/usuarios.txt');
    if (File::exists($path)) {
        $lineas = File::lines($path);
        foreach ($lineas as $linea) {
            // Parsear "Usuario: x | Contraseña: y"
            if (preg_match('/Usuario: (.*?) \| Contraseña: (.*)/', $linea, $match)) {
                $usuarios[] = ['usuario' => $match[1], 'password' => $match[2]];
            }
        }
    }

    return view('usuarios', ['usuarios' => $usuarios]);
})->name('usuarios');

Route::get('/productos/contar', [ProductController::class, 'contar'])->name('products.contar');
Route::get('/productos/tipo/{tipo}', [ProductController::class, 'porTipo'])->name('products.porTipo');

//editar producto
Route::get('/productos/editar', [ProductController::class, 'vistaEditarTabla'])->name('productos.editar.tabla');
Route::get('/productos/editar/{index}', [ProductController::class, 'editarFormulario'])->name('productos.editar.formulario');
Route::post('/productos/editar/{index}', [ProductController::class, 'guardarEdicion'])->name('productos.guardar.edicion');


// Ruta para la vista principal del reporte
Route::get('/reporte-estadistico', [ReporteController::class, 'index'])->name('reporte.index');

// Ruta para mostrar el gráfico
Route::get('/reporte-estadistico/mostrar', [ReporteController::class, 'mostrar'])->name('reporte.mostrar');



Route::post('/registrar', [AuthController::class, 'registrar'])->name('registro.custom');

Route::get('/comando-voz', [App\Http\Controllers\ComandoVozController::class, 'index'])->name('voz.index');
Route::post('/comando-voz/accion', [App\Http\Controllers\ComandoVozController::class, 'procesar'])->name('voz.procesar');

Route::get('/comando-video', [ComandoVideoController::class, 'index'])->name('comando.video');
Route::post('/comando-video/procesar', [ComandoVideoController::class, 'procesar'])->name('comando.video.procesar');



Route::get('/pdfs', [PdfController::class, 'index'])->name('pdfs.index');


Route::get('/pdfs', [PdfController::class, 'index'])->name('pdfs.index');
Route::get('/pdfs/upload', function () {
    return view('pdfs.upload');
})->name('pdfs.upload.form');
Route::post('/pdfs/upload', [PdfController::class, 'upload'])->name('pdfs.upload');

Route::get('/buscar-material', [PDFController::class, 'buscarVista'])->name('pdfs.buscar.form');
Route::get('/resultados-material', [PDFController::class, 'buscar'])->name('pdfs.buscar');

require __DIR__.'/auth.php';

