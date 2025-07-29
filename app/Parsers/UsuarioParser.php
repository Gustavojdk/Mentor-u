<?php
namespace App\Parsers;

class UsuarioParser
{
    public static function parseLine($line)
    {
        // Ej: Usuario: alvaro | Contraseña: 1234
        if (preg_match('/Usuario:\s*(.+?)\s*\|\s*Contraseña:\s*(.+)/', $line, $matches)) {
            return [
                'username' => trim($matches[1]),
                'password' => trim($matches[2]),
            ];
        }

        return null;
    }

    public static function formatLine($username, $password)
    {
        return "Usuario: {$username} | Contraseña: {$password}";
    }
}
