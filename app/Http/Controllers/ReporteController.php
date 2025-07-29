<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function mostrar()
    {
        try {
            $archivo = storage_path('app/productos.txt');

            if (!file_exists($archivo)) {
                throw new Exception("Archivo de productos no encontrado.");
            }

            $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $tipos = [];

            foreach ($lineas as $linea) {
                $partes = array_map('trim', explode(',', $linea, 5));
                if (count($partes) >= 3) {
                    $tipo = $partes[2];
                    $tipos[$tipo] = ($tipos[$tipo] ?? 0) + 1;
                }
            }

            return view('reportes.grafico', ['datos' => $tipos]);

        } catch (Exception $e) {
            return redirect()->route('reporte.index')->with('error', $e->getMessage());
        }
    }
    
}
