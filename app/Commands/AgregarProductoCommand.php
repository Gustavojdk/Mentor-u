<?php
namespace App\Commands;

use App\Repositories\ProductoRepository;
use Exception;

class AgregarProductoCommand
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new ProductoRepository();
    }

    public function ejecutar(array $datos)
    {
        if (empty($datos['nombre']) || empty($datos['precio']) || empty($datos['tipo']) || empty($datos['descripcion'])) {
            throw new Exception("Todos los campos menos la imagen son obligatorios.");
        }

        $this->repository->guardar($datos);
    }
}
