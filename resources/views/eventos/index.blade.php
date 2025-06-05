@extends('layouts.app')

@section('title', 'Listado de Eventos')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Eventos</h1>

    <a href="{{ route('eventos.create') }}" class="btn btn-primary mb-3">Crear Nuevo Evento</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($eventos->count())
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Equipo Local</th>
                <th>Equipo Visitante</th>
                <th>Fecha y Hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventos as $evento)
                <tr>
                    <td>{{ $evento->equipo_local }}</td>
                    <td>{{ $evento->equipo_visitante }}</td>
                    <td>{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($evento->estado === 'pendiente')
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @else
                            <span class="badge bg-success">Finalizado</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este evento?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p>No hay eventos disponibles.</p>
    @endif
</div>
@endsection
