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
                    $query->where('estado', 'pendiente');
                })->get();

            $apuestas_realizadas = $user->apuestas()
                ->with(['evento.equipo_local', 'evento.equipo_visitante'])
                ->whereHas('evento', function ($query) {
                    $query->where('estado', 'finalizado');
                })->get();


            $tokens = $user->tokens ?? 0;

            return view('dashboard', compact('apuestas_pendientes', 'apuestas_realizadas', 'tokens'));
        }
    }




    // Mostrar formulario para apostar en un evento específico
    public function apostar(Evento $evento)
    {
        $evento->load(['equipo_local', 'equipo_visitante']);
        return view('apostar', compact('evento'));
    }


    // Guardar una nueva apuesta
    public function store(Request $request, Evento $evento)
    {
        $user = Auth::user();

        $request->validate([
            'tipo_apuesta' => 'required|string',
            'cantidad' => 'required|integer|min:1',
        ]);

        $cantidad = $request->input('cantidad');

        // Verificar si el usuario tiene suficientes tokens
        if (($user->tokens ?? 0) < $cantidad) {
            return back()->withErrors(['cantidad' => 'No tienes suficientes tokens para apostar esa cantidad.'])->withInput();
        }

        $tipo = $request->input('tipo_apuesta');
        $prediccion = '';

        if ($tipo === 'ganador') {
            $prediccion = $request->input('prediccion_ganador');
        } elseif ($tipo === 'marcador_exacto') {
            $prediccion = $request->input('goles_local') . '-' . $request->input('goles_visitante');
        } elseif ($tipo === 'goles') {
            $prediccion = $request->input('total_goles');
        }

        // Crear apuesta
        Apuesta::create([
            'user_id' => $user->id,
            'evento_id' => $evento->id,
            'tipo_apuesta' => $tipo,
            'prediccion' => $prediccion,
            'cantidad' => $cantidad, // Asumiendo que tienes esta columna (de lo contrario, agregarla en migración)
        ]);

        // Restar tokens apostados al usuario
        $user->tokens -= $cantidad;
        $user->save();

        return redirect()->route('dashboard')->with('success', '¡Apuesta registrada exitosamente!');
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
