@extends('layouts.app')

@section('title', 'Listado de Eventos')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Eventos</h1>

    <a href="{{ route('eventos.create') }}" class="btn btn-primary mb-3">Crear Nuevo Evento</a>

    @if(session('success'))
        <div class="alert alert-success animate__animated animate__fadeInDown">
            {{ session('success') }}
        </div>
    @endif

    @if($eventos->count())
    <div class="table-responsive animate__animated animate__fadeIn">
        <table class="table table-dark table-bordered align-middle shadow rounded">
            <thead class="table-secondary text-dark">
                <tr>
                    <th scope="col">Equipo Local</th>
                    <th scope="col">Equipo Visitante</th>
                    <th scope="col">Fecha y Hora</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
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
                            <a href="{{ route('eventos.edit', $evento->id) }}" class="btn btn-sm btn-warning me-1">Editar</a>

                            <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este evento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-muted fst-italic">No hay eventos disponibles.</p>
    @endif
</div>
@endsection
