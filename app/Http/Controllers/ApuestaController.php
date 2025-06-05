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
        $user = auth()->user();

        if ($user->rol === 'admin') {
            // Traer eventos pendientes (por ejemplo, los que no están finalizados)
            $eventos_pendientes = Evento::with(['equipo_local', 'equipo_visitante'])
                ->where('estado', 'pendiente') // o la condición que tengas para eventos pendientes
                ->get();

            return view('dashboard', compact('eventos_pendientes'));
        } else {
            // Lógica para usuarios normales (tokens, apuestas, etc)
            $apuestas_pendientes = $user->apuestas()
                ->with(['evento.equipo_local', 'evento.equipo_visitante'])
                ->whereHas('evento', function ($query) {
                    $query->where('fecha_evento', '>', now());
                })->get();

            $apuestas_realizadas = $user->apuestas()
                ->with(['evento.equipo_local', 'evento.equipo_visitante'])
                ->whereHas('evento', function ($query) {
                    $query->where('fecha_evento', '<=', now());
                })->get();

            $tokens = $user->tokens ?? 0;

            return view('dashboard', compact('apuestas_pendientes', 'apuestas_realizadas', 'tokens'));
        }
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
