<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
    $totalUsuariosDB = User::count();
    $totalUsuariosTxt = 0;
    $productos = [];

    // Lectura de usuarios desde TXT
    $disk = Storage::disk('local');

    if ($disk->exists('usuarios.txt')) {
        $archivoUsuarios = $disk->get('usuarios.txt');

        $lineas = collect(preg_split('/\r\n|\r|\n/', $archivoUsuarios))
            ->map(fn($linea) => trim($linea));

        $usuariosFiltrados = $lineas->filter(fn($linea) => str_contains($linea, 'Usuario:'));

        $totalUsuariosTxt = $usuariosFiltrados->count();
    }

    // Lectura de productos desde TXT
   
    $archivo = storage_path('app/productos.txt');

    if (!file_exists($archivo)) {
        abort(404, 'El archivo productos.txt no existe.');
    }

    $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $productos = [];

    foreach ($lineas as $linea) {
        $partes = array_map('trim', explode(',', $linea, 5));

        if (count($partes) >= 4) {
            $productos[] = [
                'nombre' => $partes[0],
                'precio' => floatval(str_replace(['$', ' '], '', $partes[1])),
                'tipo' => $partes[2],
                'descripcion' => $partes[3],
                'imagen'=> $partes[4] ?? 'default.png',
            ];
        }
    }

    return view('home.index', compact('totalUsuariosDB', 'totalUsuariosTxt', 'productos'));
    }

}