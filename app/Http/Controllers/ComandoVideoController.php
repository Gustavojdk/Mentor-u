<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComandoVideoController extends Controller
{
     public function index()
    {
        return view('comandoVideo');
    }

    public function procesar(Request $request)
    {
        $comando = strtolower($request->input('comando'));
        $archivo = storage_path('app/productos.txt');

        if (preg_match('/agregar (.+) con precio ([\d.]+) tipo (.+) descripcion (.+)/', $comando, $p)) {
            [$full, $nombre, $precio, $tipo, $desc] = $p;
            $linea = "$nombre,$precio,$tipo,$desc,default.png\n";
            file_put_contents($archivo, $linea, FILE_APPEND);
            return redirect()->route('comando.video')->with('success', "✅ Agregado: $nombre");
        }

        if (preg_match('/eliminar (.+)/', $comando, $p)) {
            $nombre = trim($p[1]);
            $lines = file($archivo, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
            $filtered = array_filter($lines, fn($l) => !str_starts_with(strtolower($l), strtolower("$nombre,")));
            file_put_contents($archivo, implode("\n", $filtered)."\n");
            return redirect()->route('comando.video')->with('success', "🗑️ Eliminado: $nombre");
        }

        return redirect()->route('comando.video')->with('error', '⚠️ Comando no válido.');
    }
}
