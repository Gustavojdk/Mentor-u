<?php

namespace App\Services;

use App\Mappers\ProductoMapper;
use Exception;

class ProductoService
{
    protected $mapper;

    public function __construct()
    {
        $this->mapper = new ProductoMapper();
    }

    public function obtenerTodos()
    {
        return $this->mapper->leerProductos();
    }

    public function obtenerPorIndice($index)
    {
        $productos = $this->mapper->leerProductos();

        if (!isset($productos[$index])) {
            throw new Exception("Producto no encontrado");
        }

        return ['index' => $index] + $productos[$index];
    }

    public function actualizar($index, $data)
{
    $productos = $this->mapper->leerProductos();

    // Validar: nombre único (excepto para el que se está editando)
    foreach ($productos as $i => $producto) {
        if ($i !== $index && preg_match("/^{$data['nombre']}$/i", $producto['nombre'])) {
            throw new \Exception("El nombre del producto ya existe.");
        }
    }

    // Validar tipo con ER-parser
    $tiposValidos = ['Battle Royale', 'Acción', 'Aventura', 'Deporte', 'Pelea', 'Sci-fi', 'Creatividad'];
    $regexTipos = implode('|', array_map('preg_quote', $tiposValidos));

    if (!preg_match("/^($regexTipos)$/i", $data['tipo'])) {
        throw new \Exception("Tipo inválido. Solo se permiten: " . implode(', ', $tiposValidos));
    }

    // Actualizar producto
    if (!isset($productos[$index])) {
        throw new \Exception("Índice de producto no válido.");
    }

    $productos[$index] = $data;
    $this->mapper->guardarProductos($productos);
}

}
