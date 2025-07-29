<?php

namespace App\Http\Controllers;
use App\Services\UsuarioStorage;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registrar(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string|min:4',
    ]);

    try {
        $usuarios = UsuarioStorage::getInstancia();
        $usuarios->agregarUsuario($request->username, $request->password);

        return back()->with('success', 'Usuario registrado exitosamente.');

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}
public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        try {
            $storage = UsuarioStorage::getInstancia();

            if ($storage->autenticar($request->username, $request->password)) {
                // Aquí puedes usar session()->put('usuario', $request->username);
                return redirect('/panel')->with('success', 'Sesión iniciada correctamente');
            } else {
                return back()->with('error', 'Usuario o contraseña incorrectos');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Error de autenticación: ' . $e->getMessage());
        }
    }
}
