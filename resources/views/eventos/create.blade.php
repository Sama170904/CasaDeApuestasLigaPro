@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
<div class="container mt-4">
    <h1>Crear Nuevo Evento</h1>

    <form action="{{ route('eventos.store') }}" method="POST" novalidate>
        @csrf

        <div class="mb-3">
            <label for="equipo_local" class="form-label">Equipo Local</label>
            <input type="text" name="equipo_local" id="equipo_local" class="form-control @error('equipo_local') is-invalid @enderror" value="{{ old('equipo_local') }}">
            @error('equipo_local')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="equipo_visitante" class="form-label">Equipo Visitante</label>
            <input type="text" name="equipo_visitante" id="equipo_visitante" class="form-control @error('equipo_visitante') is-invalid @enderror" value="{{ old('equipo_visitante') }}">
            @error('equipo_visitante')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha y Hora</label>
            <input type="datetime-local" name="fecha" id="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}">
            @error('fecha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Crear Evento</button>
        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
