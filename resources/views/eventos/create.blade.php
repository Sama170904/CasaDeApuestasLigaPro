@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
<div class="container mt-4">
    <h1>Crear Nuevo Evento</h1>

    <form action="{{ route('admin.eventos.store') }}" method="POST">
        @csrf

        <!-- Selección Equipo Local -->
        <div class="mb-3">
            <label for="equipo_local_id" class="form-label">Equipo Local</label>
            <select name="equipo_local_id" id="equipo_local_id" class="form-select @error('equipo_local_id') is-invalid @enderror" required>
                <option value="">-- Selecciona equipo local --</option>
                @foreach($equipos as $equipo)
                    <option value="{{ $equipo->id }}" {{ old('equipo_local_id') == $equipo->id ? 'selected' : '' }}>
                        {{ $equipo->nombre }}
                    </option>
                @endforeach
            </select>
            @error('equipo_local_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!-- Selección Equipo Visitante -->
        <div class="mb-3">
            <label for="equipo_visitante_id" class="form-label">Equipo Visitante</label>
            <select name="equipo_visitante_id" id="equipo_visitante_id" class="form-select @error('equipo_visitante_id') is-invalid @enderror" required>
                <option value="">-- Selecciona equipo visitante --</option>
                @foreach($equipos as $equipo)
                    <option value="{{ $equipo->id }}" {{ old('equipo_visitante_id') == $equipo->id ? 'selected' : '' }}>
                        {{ $equipo->nombre }}
                    </option>
                @endforeach
            </select>
            @error('equipo_visitante_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!-- Fecha y Hora -->
        <div class="mb-3">
            <label for="fecha_evento" class="form-label">Fecha y Hora</label>
            <input type="datetime-local" name="fecha_evento" id="fecha_evento" class="form-control @error('fecha_evento') is-invalid @enderror" value="{{ old('fecha_evento') }}" required>
            @error('fecha_evento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!-- Aquí puedes agregar más opciones para apostar si quieres -->

        <button type="submit" class="btn btn-success">Crear Evento</button>
        <a href="{{ route('admin.eventos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

