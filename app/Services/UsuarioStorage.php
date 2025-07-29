<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Parsers\UsuarioParser;

class UsuarioStorage
{
    private static $instancia = null;
    private $usuarios = [];

    private function __construct()
    {
        $this->cargarUsuarios();
    }

    public static function getInstancia()
    {
        if (!self::$instancia) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    private function cargarUsuarios()
    {
        $archivo = storage_path('app/usuarios.txt');
        if (!file_exists($archivo)) return;

        $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lineas as $linea) {
            $user = UsuarioParser::parseLine($linea);
            if ($user) $this->usuarios[] = $user;
        }
    }

    public function autenticar($username, $password)
    {
        foreach ($this->usuarios as $user) {
            if (
                strtolower($user['username']) === strtolower($username) &&
                $user['password'] === $password
            ) {
                return true;
            }
        }
        return false;
    }
}
