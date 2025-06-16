<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Equipo;
use Illuminate\Http\Request;


class EventoController extends Controller
{
    // Otros métodos...

    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        $equipos = Equipo::all();
        return view('eventos.edit', compact('evento', 'equipos'));
    }

public function update(Request $request, Evento $evento)
{
    // Validar
    $validated = $request->validate([
        'equipo_local_id' => 'required|exists:equipos,id',
        'equipo_visitante_id' => 'required|exists:equipos,id|different:equipo_local_id',
        'fecha_evento' => 'required|date',
        'estado' => 'required|in:pendiente,finalizado',
        'marcador_local' => 'nullable|integer|min:0',
        'marcador_visitante' => 'nullable|integer|min:0',
        'cuota' => 'required|numeric|min:1',
    ]);


    // Asignar valores explícitamente, con casting correcto para marcadores
    $evento->equipo_local_id = $validated['equipo_local_id'];
    $evento->equipo_visitante_id = $validated['equipo_visitante_id'];
    $evento->fecha_evento = $validated['fecha_evento'];
    $evento->estado = $validated['estado'];
    $evento->marcador_local = isset($validated['marcador_local']) ? (int)$validated['marcador_local'] : null;
    $evento->marcador_visitante = isset($validated['marcador_visitante']) ? (int)$validated['marcador_visitante'] : null;
    $evento->cuota = $validated['cuota'];

    // Guardar actualización (NO crear nuevo registro)
    $evento->save();

    // Si está finalizado y tiene marcadores, actualizar apuestas...
    if ($evento->estado === 'finalizado' && $evento->marcador_local !== null && $evento->marcador_visitante !== null) {
        $ganador = $evento->marcador_local > $evento->marcador_visitante
            ? 'local'
            : ($evento->marcador_local < $evento->marcador_visitante ? 'visitante' : 'empate');

        foreach ($evento->apuestas as $apuesta) {
            $correcta = false;

            switch ($apuesta->tipo_apuesta) {
                case 'ganador':
                    $correcta = $apuesta->prediccion === $ganador;
                    break;
                case 'empate':
                    $correcta = $ganador === 'empate';
                    break;
                case 'marcador_exacto':
                    $correcta = $apuesta->prediccion === "{$evento->marcador_local}-{$evento->marcador_visitante}";
                    break;
                case 'goles_totales':
                    $total = $evento->marcador_local + $evento->marcador_visitante;
                    $correcta = (int)$apuesta->prediccion === $total;
                    break;
            }

            $apuesta->es_correcta = $correcta;
            $apuesta->save();
        }
    }

    return redirect()->route('admin.dashboard')->with('success', 'Evento actualizado correctamente.');
}


    public function index()
    {
        // Por ejemplo, mostrar eventos pendientes en la página principal pública
        $eventos = Evento::where('estado', 'pendiente')->orderBy('fecha_evento')->get();
        return view('inicio', compact('eventos'));
    }


    public function destroy(Evento $evento)
    {
        $evento->delete();

        return redirect()->route('admin.eventos.index')->with('success', 'Evento eliminado correctamente.');
    }
    
    public function finalizar(Evento $evento)
    {
        $evento->estado = 'finalizado';
        $evento->save();

        // Opcional: aquí podrías agregar lógica extra, como actualizar apuestas si quieres

        return redirect()->route('admin.eventos.index')->with('success', 'Evento finalizado correctamente.');
    }

    public function create()
    {
        $equipos = Equipo::all(); // o los que necesites
        return view('eventos.create', compact('equipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipo_local_id' => 'required|exists:equipos,id',
            'equipo_visitante_id' => 'required|exists:equipos,id|different:equipo_local_id',
            'fecha_evento' => 'required|date',
            'cuota' => 'required|numeric|min:1',
        ]);

        Evento::create([
            'equipo_local_id' => $request->equipo_local_id,
            'equipo_visitante_id' => $request->equipo_visitante_id,
            'fecha_evento' => $request->fecha_evento,
            'estado' => 'pendiente',
            'cuota' => $request->cuota,
        ]);

        return redirect()->route('dashboard')->with('success', 'Evento creado correctamente.');
    }




}
