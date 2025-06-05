<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Equipo;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::where('estado', 'pendiente')->orderBy('fecha_evento', 'asc')->get();
        return view('inicio', compact('eventos'));
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

        return redirect()->route('eventos.index')->with('success', 'Evento creado correctamente.');
    }

    public function edit(Evento $evento)
    {
        return view('eventos.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'equipo_local_id' => 'required|exists:equipos,id',
            'equipo_visitante_id' => 'required|exists:equipos,id|different:equipo_local_id',
            'fecha_evento' => 'required|date',
            'estado' => 'required|in:pendiente,finalizado',
        ]);

        $evento->update($validated);

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();

        return redirect()->route('eventos.index')->with('success', 'Evento eliminado correctamente.');
    }
}
