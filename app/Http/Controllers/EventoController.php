<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{

    public function index()
    {
        $eventos = Evento::where('estado', 'pendiente')->orderBy('fecha_evento', 'asc')->get();
        return view('inicio', compact('eventos'));
    }



    // Mostrar formulario para crear evento
    public function create()
    {
        return view('eventos.create');
    }

    // Guardar nuevo evento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipo_local' => 'required|string|max:255',
            'equipo_visitante' => 'required|string|max:255',
            'fecha' => 'required|date|after:now',
            'estado' => 'nullable|in:pendiente,finalizado',
        ]);

        // Por defecto estado pendiente si no viene
        if (!isset($validated['estado'])) {
            $validated['estado'] = 'pendiente';
        }

        Evento::create($validated);

        return redirect()->route('eventos.index')->with('success', 'Evento creado correctamente.');
    }

    // Mostrar formulario para editar evento
    public function edit(Evento $evento)
    {
        return view('eventos.edit', compact('evento'));
    }

    // Actualizar evento
    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'equipo_local' => 'required|string|max:255',
            'equipo_visitante' => 'required|string|max:255',
            'fecha' => 'required|date',
            'estado' => 'required|in:pendiente,finalizado',
        ]);

        $evento->update($validated);

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
    }

    // Eliminar evento
    public function destroy(Evento $evento)
    {
        $evento->delete();

        return redirect()->route('eventos.index')->with('success', 'Evento eliminado correctamente.');
    }
}
