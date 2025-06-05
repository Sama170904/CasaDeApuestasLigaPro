@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Realizar Apuesta</h2>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title text-center">
                {{ $evento->equipo_local->nombre }} vs {{ $evento->equipo_visitante->nombre }}
            </h4>
            <p class="text-center">
                Fecha del evento: <strong>{{ \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y H:i') }}</strong>
            </p>

            <!-- CORREGIDO: nombre correcto de la ruta -->
            <form action="{{ route('apostar.guardar', $evento->id) }}" method="POST">
                @csrf
                <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                <input type="hidden" name="tipo_apuesta" value="ganador">

                <div class="form-group">
                    <label>¿Quién ganará?</label>
                    <select name="prediccion" class="form-control" required>
                        <option value="{{ $evento->equipo_local->id }}">{{ $evento->equipo_local->nombre }}</option>
                        <option value="{{ $evento->equipo_visitante->id }}">{{ $evento->equipo_visitante->nombre }}</option>
                        <option value="empate">Empate</option>
                    </select>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success">Confirmar Apuesta</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
