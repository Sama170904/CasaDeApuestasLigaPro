@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Editar Evento</h2>

    <form action="{{ route('admin.eventos.update', $evento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="equipo_local_id" class="form-label">Equipo Local</label>
            <select name="equipo_local_id" id="equipo_local_id" class="form-control">
                @foreach($equipos as $equipo)
                    <option value="{{ $equipo->id }}" {{ $evento->equipo_local_id == $equipo->id ? 'selected' : '' }}>
                        {{ $equipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="equipo_visitante_id" class="form-label">Equipo Visitante</label>
            <select name="equipo_visitante_id" id="equipo_visitante_id" class="form-control">
                @foreach($equipos as $equipo)
                    <option value="{{ $equipo->id }}" {{ $evento->equipo_visitante_id == $equipo->id ? 'selected' : '' }}>
                        {{ $equipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_evento" class="form-label">Fecha del Evento</label>
            <input type="datetime-local" name="fecha_evento" id="fecha_evento" class="form-control"
                value="{{ \Carbon\Carbon::parse($evento->fecha_evento)->format('Y-m-d\TH:i') }}">
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-control">
                <option value="pendiente" {{ $evento->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="finalizado" {{ $evento->estado === 'finalizado' ? 'selected' : '' }}>Finalizado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

