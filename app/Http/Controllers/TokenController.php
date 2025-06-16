<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    // Mostrar formulario para recargar tokens
    public function mostrarFormulario()
    {
        return view('tokens.recargar');
    }

    // Procesar la recarga de tokens
    public function recargar(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        // Sumar tokens nuevos al saldo actual
        $user->tokens = $user->tokens + $request->cantidad;

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Tokens recargados correctamente.');
    }
}
