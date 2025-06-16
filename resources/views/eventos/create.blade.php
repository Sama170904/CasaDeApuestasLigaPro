@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Crear Nuevo Evento</h1>

    <form action="{{ route('admin.eventos.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <!-- Selección Equipo Local -->
        <div class="mb-4">
            <label for="equipo_local_id" class="form-label">Equipo Local</label>
            <select name="equipo_local_id" id="equipo_local_id"
                class="form-select @error('equipo_local_id') is-invalid @enderror" required>
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
        <div class="mb-4">
            <label for="equipo_visitante_id" class="form-label">Equipo Visitante</label>
            <select name="equipo_visitante_id" id="equipo_visitante_id"
                class="form-select @error('equipo_visitante_id') is-invalid @enderror" required>
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
        <div class="mb-4">
            <label for="fecha_evento" class="form-label">Fecha y Hora</label>
            <input type="datetime-local" name="fecha_evento" id="fecha_evento"
                class="form-control @error('fecha_evento') is-invalid @enderror"
                value="{{ old('fecha_evento') }}" required>
            @error('fecha_evento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-primary px-4 py-2">Crear Evento</button>
            <a href="{{ route('admin.eventos.index') }}" class="btn btn-secondary px-4 py-2">Cancelar</a>
        </div>
    </form>
</div>
@endsection

