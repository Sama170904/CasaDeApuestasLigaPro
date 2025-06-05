<?php

namespace App\Http\Controllers;

use App\Models\Apuesta;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApuestaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Cargar las apuestas del usuario con info del evento y equipos
        $apuestas = $user->apuestas()->with(['evento.equipo_local', 'evento.equipo_visitante'])->get();

        return view('dashboard', compact('apuestas'));
    }

    // Mostrar formulario para apostar en un evento específico
    public function apostar($id)
    {
        $evento = Evento::with(['equipo_local', 'equipo_visitante'])->findOrFail($id);
        return view('apostar', compact('evento'));
    }

    // Guardar una nueva apuesta
    public function store(Request $request)
    {
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'tipo_apuesta' => 'required|in:ganador',
            'prediccion' => 'required|string',
        ]);

        $prediccion = $request->prediccion === 'empate' ? 'empate' : intval($request->prediccion);

        Apuesta::create([
            'user_id' => Auth::id(),
            'evento_id' => $request->evento_id,
            'tipo_apuesta' => $request->tipo_apuesta,
            'prediccion' => $prediccion,
            'es_correcta' => null,
        ]);

        return redirect()->route('inicio')->with('success', '¡Apuesta registrada con éxito!');
    }

    // Otros métodos que puedes usar después (por ahora puedes comentarlos si no los necesitas)
    /*
    public function index() {}
    public function create() {}
    public function show(Apuesta $apuesta) {}
    public function edit(Apuesta $apuesta) {}
    public function update(Request $request, Apuesta $apuesta) {}
    public function destroy(Apuesta $apuesta) {}
    */
}
