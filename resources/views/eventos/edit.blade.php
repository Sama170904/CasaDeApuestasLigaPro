@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Editar Evento</h2>

    <form action="{{ route('admin.eventos.update', $evento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="equipo_local_id" class="form-label">Equipo Local</label>
                <select name="equipo_local_id" id="equipo_local_id" class="form-control" required>
                    @foreach($equipos as $equipo)
                        <option value="{{ $equipo->id }}" {{ $evento->equipo_local_id == $equipo->id ? 'selected' : '' }}>
                            {{ $equipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="equipo_visitante_id" class="form-label">Equipo Visitante</label>
                <select name="equipo_visitante_id" id="equipo_visitante_id" class="form-control" required>
                    @foreach($equipos as $equipo)
                        <option value="{{ $equipo->id }}" {{ $evento->equipo_visitante_id == $equipo->id ? 'selected' : '' }}>
                            {{ $equipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="fecha_evento" class="form-label">Fecha del Evento</label>
            <input type="datetime-local" name="fecha_evento" id="fecha_evento" class="form-control" required
                value="{{ \Carbon\Carbon::parse($evento->fecha_evento)->format('Y-m-d\TH:i') }}">
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-control" required>
                <option value="pendiente" {{ $evento->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="finalizado" {{ $evento->estado === 'finalizado' ? 'selected' : '' }}>Finalizado</option>
            </select>
        </div>

        {{-- Mostrar siempre los campos de marcador para que puedas ingresar marcador en cualquier estado --}}
        <div id="resultado-fields">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="marcador_local" class="form-label">Goles del Equipo Local</label>
                    <input type="number" min="0" name="marcador_local" id="marcador_local" class="form-control"
                        value="{{ old('marcador_local', $evento->marcador_local) }}">
                </div>
                <div class="col-md-6">
                    <label for="marcador_visitante" class="form-label">Goles del Equipo Visitante</label>
                    <input type="number" min="0" name="marcador_visitante" id="marcador_visitante" class="form-control"
                        value="{{ old('marcador_visitante', $evento->marcador_visitante) }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

{{-- Opcional: Mostrar u ocultar campos marcador si quieres con JS según estado --}}
<script>
    document.getElementById('estado').addEventListener('change', function () {
        const resultadoFields = document.getElementById('resultado-fields');
        // Aquí puedes decidir si ocultar o mostrar el marcador según el estado, o dejar siempre visible
        // Ejemplo para ocultar si estado es pendiente:
        if (this.value === 'finalizado') {
            resultadoFields.style.display = 'block';
        } else {
            resultadoFields.style.display = 'block'; // cambiar a 'none' si quieres ocultar en pendiente
        }
    });
</script>
@endsection


