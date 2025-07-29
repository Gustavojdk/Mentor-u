<?php

namespace App\Http\Controllers;

use App\Repositories\ProductoRepository;
use App\Commands\AgregarProductoCommand;
use App\Services\ProductoService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
     // Ordenar productos según prioridad del tipo
    $prioridades = ['Battle Royale', 'Acción', 'Aventura'];

    usort($productos, function ($a, $b) use ($prioridades) {
        $prioridadA = array_search($a['tipo'], $prioridades);
        $prioridadB = array_search($b['tipo'], $prioridades);

        $prioridadA = $prioridadA === false ? PHP_INT_MAX : $prioridadA;
        $prioridadB = $prioridadB === false ? PHP_INT_MAX : $prioridadB;

        return $prioridadA <=> $prioridadB;
    });

        return view('products.index', compact('productos'));
    }

public function vistaAgregar()
{
    $productos = (new ProductoRepository())->obtenerTodos();
    return view('products.agregar', compact('productos'));
}

public function formulario()
{
    return view('products.formulario');
}

public function guardarFormulario(Request $request)
{
    
    try {
        $request->validate([
            'nombre' => 'required|string',
            'precio' => 'required|numeric',
            'tipo' => 'required|string',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $nombreImagen = 'default.png';

        if ($request->hasFile('imagen')) {
            $nombreImagen = time() . '.' . $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(public_path('images'), $nombreImagen);
        }

        $producto = [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'imagen' => $nombreImagen
        ];

        (new AgregarProductoCommand())->ejecutar($producto);

        return view('products.ficha', compact('producto'));

    } catch (Exception $e) {
        return back()->withErrors($e->getMessage())->withInput();
    }
}    



    public function borrarVista()
{
    $archivo = storage_path('app/productos.txt');

    $productos = [];

    if (file_exists($archivo)) {
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lineas as $linea) {
            $partes = array_map('trim', explode(',', $linea, 5));

            if (count($partes) >= 4) {
                $productos[] = [
                    'nombre' => $partes[0],
                    'precio' => $partes[1],
                    'tipo' => $partes[2],
                    'descripcion' => $partes[3],
                    'imagen' => $partes[4] ?? 'default.png'
                ];
            }
        }
    }

    return view('products.delete', compact('productos'));
}

public function borrar($index)
{
    $archivo = storage_path('app/productos.txt');

    if (!file_exists($archivo)) {
        return redirect()->back()->with('error', 'No hay productos para eliminar.');
    }

    $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (!isset($lineas[$index])) {
        return redirect()->back()->with('error', 'Producto no encontrado.');
    }

    unset($lineas[$index]);
    file_put_contents($archivo, implode(PHP_EOL, $lineas) . PHP_EOL);

    return redirect()->back()->with('success', 'Producto eliminado con éxito.');
}


public function contar()
{
    $archivo = storage_path('app/productos.txt');

    $cantidad = 0;
    $porTipo = [];

    if (file_exists($archivo)) {
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lineas as $linea) {
            $partes = array_map('trim', explode(',', $linea, 4));
            if (count($partes) >= 3) {
                $cantidad++;

                $tipo = $partes[2]; // Tercer campo
                if (!isset($porTipo[$tipo])) {
                    $porTipo[$tipo] = 0;
                }
                $porTipo[$tipo]++;
            }
        }
    }
    // Prioridad definida manualmente
    $prioridades = ['Battle Royale', 'Acción', 'Aventura'];

    // Creamos una nueva cola de prioridad manual
    $porTipoOrdenado = [];

    // Primero agregamos los tipos prioritarios
    foreach ($prioridades as $tipoPrioritario) {
        if (isset($porTipo[$tipoPrioritario])) {
            $porTipoOrdenado[$tipoPrioritario] = $porTipo[$tipoPrioritario];
            unset($porTipo[$tipoPrioritario]); // Evitamos duplicados
        }
    }

    // Luego agregamos el resto sin prioridad
    foreach ($porTipo as $tipo => $conteo) {
        $porTipoOrdenado[$tipo] = $conteo;
    }

    return view('products.count', [
        'cantidad' => $cantidad,
        'porTipo' => $porTipoOrdenado
    ]);

}

public function porTipo($tipo)
{
    $archivo = storage_path('app/productos.txt');
    $productos = [];

    if (file_exists($archivo)) {
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lineas as $linea) {
            $partes = array_map('trim', explode(',', $linea, 5));
            if (count($partes) >= 4 && strtolower($partes[2]) === strtolower($tipo)) {
                $productos[] = [
                    'nombre' => $partes[0],
                    'precio' => floatval($partes[1]),
                    'tipo' => $partes[2],
                    'descripcion' => $partes[3],
                    'imagen' => $partes[4] ?? 'default.png',
                ];
            }
        }
    }

    return view('products.porTipo', compact('productos', 'tipo'));
}


public function vistaEditarTabla()
{
    $productos = (new ProductoService())->obtenerTodos();
    return view('products.editar-tabla', compact('productos'));
}

public function editarFormulario($index)
{
    $producto = (new ProductoService())->obtenerPorIndice($index);
    return view('products.formulario-editar', compact('producto'));
}

public function guardarEdicion(Request $request, $index)
{
    try {
        $request->validate([
            'nombre' => 'required|string',
            'precio' => 'required|numeric',
            'tipo' => 'required|string',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $imagenActual = $request->input('imagen_actual'); // campo oculto con imagen vieja
        $nombreImagen = $imagenActual;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $nombreImagen = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $nombreImagen);
        }

        $data = [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'imagen' => $nombreImagen
        ];

        (new ProductoService())->actualizar($index, $data);

        return view('products.ficha', ['producto' => $data]);

    } catch (Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', $e->getMessage());

    }
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
