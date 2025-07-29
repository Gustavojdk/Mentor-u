<?php

namespace App\Mappers;

use Exception;

class ProductoMapper
{
    protected $archivo;

    public function __construct()
    {
        $this->archivo = storage_path('app/productos.txt');
    }

    public function leerProductos()
    {
        if (!file_exists($this->archivo)) return [];

        $lineas = file($this->archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $productos = [];

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

        return $productos;
    }

    public function guardarProductos(array $productos)
    {
        $lineas = array_map(function ($p) {
            return implode(',', [
                $p['nombre'],
                $p['precio'],
                $p['tipo'],
                $p['descripcion'],
                $p['imagen'] ?? 'default.png',
            ]);
        }, $productos);

        try {
            file_put_contents($this->archivo, implode(PHP_EOL, $lineas) . PHP_EOL);
        } catch (Exception $e) {
            throw new Exception("No se pudo guardar el archivo: " . $e->getMessage());
        }
    }
}
