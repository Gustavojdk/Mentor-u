<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\Storage;

class ProductoRepository
{
    public function obtenerTodos(): array
    {
        $archivo = storage_path('app/productos.txt');
        $productos = [];

        try {
            if (!file_exists($archivo)) return [];

            $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lineas as $linea) {
                $campos = array_map('trim', explode(',', $linea, 5));
                if (count($campos) >= 4) {
                    $productos[] = [
                        'nombre' => $campos[0],
                        'precio' => floatval($campos[1]),
                        'tipo' => $campos[2],
                        'descripcion' => $campos[3],
                        'imagen' => $campos[4] ?? 'default.png',
                    ];
                }
            }
        } catch (Exception $e) {
            report($e);
        }

        return $productos;
    }

    public function guardar(array $producto)
    {
        $archivo = storage_path('app/productos.txt');

        $linea = implode(',', [
            $producto['nombre'],
            $producto['precio'],
            $producto['tipo'],
            $producto['descripcion'],
            $producto['imagen'] ?? 'default.png',
        ]);

        try {
            file_put_contents($archivo, PHP_EOL . $linea, FILE_APPEND);

        } catch (Exception $e) {
            throw new Exception("No se pudo guardar el producto: " . $e->getMessage());
        }
    }
}
