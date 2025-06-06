<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Equipo;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    // Método para la página pública (inicio)
    public function index()
    {
        $eventos = Evento::where('estado', 'pendiente')->orderBy('fecha_evento', 'asc')->get();
        return view('inicio', compact('eventos'));
    }

    // Nuevo método para el listado en panel admin
    public function adminIndex()
    {
        $eventos = Evento::orderBy('fecha_evento', 'asc')->get();
        return view('admin.eventos.index', compact('eventos'));
    }

    public function create()
    {
        $equipos = Equipo::all();
        return view('eventos.create', compact('equipos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipo_local_id' => 'required|exists:equipos,id',
            'equipo_visitante_id' => 'required|exists:equipos,id|different:equipo_local_id',
            'fecha_evento' => 'required|date|after:now',
            'estado' => 'nullable|in:pendiente,finalizado',
        ]);

        $validated['estado'] = $validated['estado'] ?? 'pendiente';

        Evento::create($validated);

        // Cambié redirect aquí para que use la ruta admin.eventos.index
        return redirect()->route('admin.eventos.index')->with('success', 'Evento creado correctamente.');
    }

    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        $equipos = Equipo::all();
        return view('eventos.edit', compact('evento', 'equipos'));
    }

    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);

        $validated = $request->validate([
            'equipo_local_id' => 'required|exists:equipos,id',
            'equipo_visitante_id' => 'required|exists:equipos,id|different:equipo_local_id',
            'fecha_evento' => 'required|date',
            'estado' => 'required|in:pendiente,finalizado',
        ]);

        $evento->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);
        $evento->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Evento eliminado correctamente.');
    }

    public function finalizar($id)
    {
        $evento = Evento::findOrFail($id);
        $evento->estado = 'finalizado';
        $evento->save();

        return redirect()->route('admin.dashboard')->with('success', 'Evento finalizado correctamente.');
    }
}
