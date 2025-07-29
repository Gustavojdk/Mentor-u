<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Libraries\CodeCompiler;

class ComandoVozController extends Controller
{
    public function index()
    {
        return view('comandoVoz');
    }
    public function procesar(Request $request)
{
    $comando = strtolower($request->input('comando'));
    $archivo = storage_path('app/productos.txt');

    try {
        // Guardar comando en archivo temporal
        $fileTemp = storage_path('app/temp_command.txt');
        file_put_contents($fileTemp, $comando);

        // Crear instancia del compilador
        $compiler = new \App\Libraries\CodeCompiler($fileTemp);

        // Reglas de gramática personalizadas
        $reglas = [
        'comando -> agregar nombre con precio valor tipo tipo descripcion descripcion',
        'comando -> eliminar nombre',
        'nombre -> [a-zA-Z0-9]+',
        'valor -> [0-9]+(\\.[0-9]+)?',
        'tipo -> [a-zA-Z]+',
        'descripcion -> .+',
        ];

        foreach ($reglas as $regla) {
            $compiler->addGrammarRule($regla);
        }

        $compiler->addCodeLine($comando);

        ob_start();
        $compiler->validateCodeByGrammar();
        $salida = ob_get_clean();

        if (strpos($salida, 'INVALIDA') !== false) {
            return back()->with('error', '⚠️ Comando inválido según la gramática personalizada.');
        }

        // Si es comando válido, procesamos acción
        if (str_starts_with($comando, 'agregar')) {
            if (preg_match('/agregar (.+) con precio ([\d.]+) tipo (.+) descripción (.+)/', $comando, $partes)) {
                $nombre = trim($partes[1]);
                $precio = trim($partes[2]);
                $tipo = trim($partes[3]);
                $descripcion = trim($partes[4]);
                $imagen = 'default.png';

                $linea = "$nombre,$precio,$tipo,$descripcion,$imagen" . PHP_EOL;
                file_put_contents($archivo, $linea, FILE_APPEND);

                


                return back()->with('success', "✅ Producto agregado: $nombre");
            } else {
                return back()->with('error', '⚠️ Comando no reconocido para agregar.');
            }
        }

        if (str_starts_with($comando, 'eliminar')) {
            if (preg_match('/eliminar (.+)/', $comando, $partes)) {
                $nombreEliminar = trim($partes[1]);
                $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $lineas = array_filter($lineas, function ($linea) use ($nombreEliminar) {
                    return !str_starts_with(strtolower($linea), strtolower($nombreEliminar . ','));
                });
                file_put_contents($archivo, implode(PHP_EOL, $lineas) . PHP_EOL);

    


                return back()->with('success', "🗑️ Producto eliminado: $nombreEliminar");
            } else {
                return back()->with('error', '⚠️ Comando no reconocido para eliminar.');
            }
        }

        return back()->with('error', '⚠️ Comando no reconocido.');

    } catch (\Exception $e) {
        return back()->with('error', 'Error inesperado: ' . $e->getMessage());
    }
}

}

