@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center text-light animate__animated animate__fadeInDown">Realizar Apuesta</h2>

    <div class="card bg-dark text-light shadow-lg animate__animated animate__fadeIn">
        <div class="card-body">
            <h4 class="card-title text-center mb-3 text-info">
                {{ $evento->equipo_local->nombre }} vs {{ $evento->equipo_visitante->nombre }}
            </h4>
            <p class="text-center mb-4">
                Fecha del evento: <strong>{{ \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y H:i') }}</strong>
            </p>

            <form action="{{ route('apostar.guardar', $evento->id) }}" method="POST">
                @csrf
                <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                <input type="hidden" name="tipo_apuesta" value="ganador">

                <div class="mb-4">
                    <label for="prediccion" class="form-label">¿Quién ganará?</label>
                    <select name="prediccion" id="prediccion" class="form-select bg-dark text-light border-light" required>
                        <option value="{{ $evento->equipo_local->id }}">{{ $evento->equipo_local->nombre }}</option>
                        <option value="{{ $evento->equipo_visitante->id }}">{{ $evento->equipo_visitante->nombre }}</option>
                        <option value="empate">Empate</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-outline-info px-4 py-2">Confirmar Apuesta</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

