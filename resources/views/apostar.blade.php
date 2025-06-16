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

                <div class="mb-4">
                    <label for="tipo_apuesta" class="form-label">Tipo de Apuesta</label>
                    <select name="tipo_apuesta" id="tipo_apuesta" class="form-select bg-dark text-light border-light" required onchange="mostrarOpciones()">
                        <option value="ganador">Ganador</option>
                        <option value="marcador_exacto">Marcador Exacto</option>
                        <option value="goles">Cantidad Total de Goles</option>
                    </select>
                </div>

                <!-- Ganador -->
                <div class="mb-4 tipo-apuesta" id="opcion-ganador">
                    <label for="prediccion_ganador" class="form-label">¿Quién ganará?</label>
                    <select name="prediccion_ganador" class="form-select bg-dark text-light border-light">
                        <option value="{{ $evento->equipo_local->id }}">{{ $evento->equipo_local->nombre }}</option>
                        <option value="{{ $evento->equipo_visitante->id }}">{{ $evento->equipo_visitante->nombre }}</option>
                        <option value="empate">Empate</option>
                    </select>
                </div>

                <!-- Marcador Exacto -->
                <div class="mb-4 tipo-apuesta d-none" id="opcion-marcador">
                    <label class="form-label">Marcador Exacto (Local - Visitante)</label>
                    <div class="d-flex gap-2">
                        <input type="number" min="0" name="goles_local" class="form-control bg-dark text-light" placeholder="Local">
                        <input type="number" min="0" name="goles_visitante" class="form-control bg-dark text-light" placeholder="Visitante">
                    </div>
                </div>

                <!-- Total de Goles -->
                <div class="mb-4 tipo-apuesta d-none" id="opcion-goles">
                    <label for="total_goles" class="form-label">Cantidad Total de Goles</label>
                    <input type="number" min="0" name="total_goles" class="form-control bg-dark text-light" placeholder="Ej: 3">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-outline-info px-4 py-2">Confirmar Apuesta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function mostrarOpciones() {
    const tipo = document.getElementById('tipo_apuesta').value;

    document.querySelectorAll('.tipo-apuesta').forEach(div => div.classList.add('d-none'));
    if (tipo === 'ganador') document.getElementById('opcion-ganador').classList.remove('d-none');
    if (tipo === 'marcador_exacto') document.getElementById('opcion-marcador').classList.remove('d-none');
    if (tipo === 'goles') document.getElementById('opcion-goles').classList.remove('d-none');
}
</script>
@endsection


