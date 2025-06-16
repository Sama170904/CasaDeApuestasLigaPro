@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center text-light animate__animated animate__fadeInDown">Realizar Apuesta</h2>

    <div class="card bg-dark text-light shadow-lg animate__animated animate__fadeIn">
        <div class="card-body">
            <h4 class="card-title text-center mb-3 text-info">
                {{ $evento->equipo_local->nombre }} vs {{ $evento->equipo_visitante->nombre }}
            </h4>

            <!-- Fecha del evento -->
            <p class="text-center mb-2">
                Fecha del evento: <strong>{{ \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y H:i') }}</strong>
            </p>

            <!-- Cuota -->
            <p class="text-center mb-4">
                Cuota actual del evento: <strong class="text-warning">{{ $evento->cuota }}</strong>
            </p>

            <form action="{{ route('apostar.guardar', $evento->id) }}" method="POST" id="form-apostar">
                @csrf
                <input type="hidden" name="evento_id" value="{{ $evento->id }}">

                <!-- Tipo de Apuesta -->
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

                <!-- Tokens a Apostar -->
                <div class="mb-4">
                    <label for="cantidad" class="form-label">Cantidad de tokens a apostar</label>
                    <input type="number" min="1" max="{{ auth()->user()->tokens ?? 0 }}" id="cantidad" name="cantidad" class="form-control bg-dark text-light border-light" required>
                    <small class="text-muted">Tokens disponibles: {{ auth()->user()->tokens ?? 0 }}</small>
                </div>

                <!-- Posible Ganancia -->
                <div class="mb-3">
                    <label class="form-label">Posible ganancia:</label>
                    <p id="ganancia" class="text-info">0 tokens</p>
                </div>

                <!-- Botón -->
                <div class="text-center">
                    <button type="submit" class="btn btn-outline-info px-4 py-2" id="btn-submit">Confirmar Apuesta</button>
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

    document.addEventListener('DOMContentLoaded', function () {
        const cantidadInput = document.getElementById('cantidad');
        const gananciaText = document.getElementById('ganancia');
        const cuota = {{ $evento->cuota ?? 1.5 }};

        function actualizarGanancia() {
            const cantidad = Number(cantidadInput.value);
            if (cantidad > 0) {
                const ganancia = (cantidad * cuota).toFixed(2);
                gananciaText.textContent = ganancia + ' tokens';
            } else {
                gananciaText.textContent = '0 tokens';
            }
        }

        cantidadInput.addEventListener('input', function () {
            const maxTokens = {{ auth()->user()->tokens ?? 0 }};
            if (Number(cantidadInput.value) > maxTokens) {
                cantidadInput.value = maxTokens;
            }
            actualizarGanancia();
        });

        mostrarOpciones();
        actualizarGanancia();
    });
</script>
@endsection



