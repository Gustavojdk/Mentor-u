<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    public function index()
    {
        $pdfs = [];

        if (Storage::exists('public/pdfs.txt')) {
            $contenido = Storage::get('public/pdfs.txt');
            $lineas = explode("\n", trim($contenido));

            foreach ($lineas as $linea) {
                $datos = explode('|', trim($linea));
                if (count($datos) === 3) {
                    $pdfs[] = [
                        'nombre' => $datos[0],
                        'materia' => $datos[1],
                        'archivo' => $datos[2],
                    ];
                }
            }
        }

        return view('pdfs.index', compact('pdfs'));
    }
    public function upload(Request $request)
    {
    $request->validate([
        'nombre' => 'required|string',
        'materia' => 'required|string',
        'archivo' => 'required|file|mimes:pdf|max:20480',
    ]);

    // Guardar el PDF
    $archivo = $request->file('archivo');
    $nombreArchivo = time() . '-' . $archivo->getClientOriginalName();
    $archivo->storeAs('storage/app/public/pdfs', $nombreArchivo);

    // Registrar en el archivo .txt
    $linea = $request->nombre . '|' . $request->materia . '|' . $nombreArchivo . "\n";
    \Storage::append('public/pdfs.txt', $linea);

    return redirect()->route('pdfs.upload.form')->with('success', 'PDF subido exitosamente.');
    }

    public function buscarVista()
{
    return view('pdfs.buscar_material');
}

public function buscar(Request $request)
{
    $termino = strtolower($request->input('buscar'));
    $resultados = [];

    if (\Storage::exists('public/pdfs.txt')) {
        $lineas = \Storage::get('public/pdfs.txt');
        $lineas = explode("\n", $lineas);

        foreach ($lineas as $linea) {
            if (trim($linea) === '') continue;

            list($nombre, $materia, $archivo) = explode('|', $linea);
            if (str_contains(strtolower($nombre), $termino) ||
                str_contains(strtolower($materia), $termino) ||
                str_contains(strtolower($archivo), $termino)) {
                $resultados[] = [
                    'nombre' => $nombre,
                    'materia' => $materia,
                    'archivo' => $archivo,
                ];
            }
        }
    }

    return view('pdfs.buscar_material', compact('resultados', 'termino'));
}

}
