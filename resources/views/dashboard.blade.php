@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- DASHBOARD DE ADMIN --}}
    @if(auth()->user()->rol === 'admin')
        <h2 class="text-center mb-4 text-light animate__animated animate__fadeInDown">Panel de Administración</h2>

        <!-- Información personal -->
        <div class="card bg-dark text-light mb-4 shadow-lg animate__animated animate__fadeIn">
            <div class="card-header bg-secondary text-white">Información Personal</div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Correo:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Miembro desde:</strong> {{ auth()->user()->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Botón para crear eventos -->
        <div class="mb-4 text-center animate__animated animate__fadeInUp">
            <a href="{{ route('admin.eventos.create') }}" class="btn btn-outline-info btn-lg">+ Crear Nuevo Evento</a>
        </div>

        <!-- Tabla de eventos pendientes -->
        <div class="card bg-dark text-light shadow-lg animate__animated animate__fadeIn">
            <div class="card-header bg-secondary text-white">Eventos Pendientes</div>
            <div class="card-body table-responsive">
                @if($eventos_pendientes->count())
                    <table class="table table-dark table-hover table-bordered border-light">
                        <thead class="table-dark">
                            <tr>
                                <th>Equipos</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventos_pendientes as $evento)
                                <tr>
                                    <td>{{ $evento->equipo_local->nombre }} vs {{ $evento->equipo_visitante->nombre }}</td>
                                    <td>{{ \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.eventos.edit', $evento->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                        <form action="{{ route('admin.eventos.destroy', $evento->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este evento?')">Eliminar</button>
                                        </form>
                                        <form action="{{ route('admin.eventos.finalizar', $evento->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <button class="btn btn-sm btn-outline-success">Finalizar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No hay eventos pendientes.</p>
                @endif
            </div>
        </div>

    {{-- DASHBOARD DE USUARIO --}}
    @else
        <h2 class="text-center mb-4 text-light animate__animated animate__fadeInDown">Dashboard de Usuario</h2>

        <!-- Información personal -->
        <div class="card bg-dark text-light mb-4 shadow-lg animate__animated animate__fadeIn">
            <div class="card-header bg-secondary text-white">Información Personal</div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Correo:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Miembro desde:</strong> {{ auth()->user()->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Tokens disponibles -->
        <div class="card bg-dark text-light mb-4 shadow-lg animate__animated animate__fadeIn">
            <div class="card-header bg-secondary text-white">Tokens Disponibles</div>
            <div class="card-body text-center">
                <h1 class="display-4 text-info">{{ $tokens }}</h1>
            </div>
        </div>

        <!-- Botón para recargar tokens -->
        <div class="mb-4 text-center">
            <a href="{{ route('tokens.recargar') }}" class="btn btn-success btn-lg">
                Recargar Tokens
            </a>
        </div>

        <!-- Apuestas pendientes -->
        <div class="card bg-dark text-light mb-4 shadow-lg animate__animated animate__fadeIn">
            <div class="card-header bg-secondary text-white">Apuestas Pendientes</div>
            <div class="card-body">
                @forelse($apuestas_pendientes as $apuesta)
                    <div class="border-bottom border-secondary pb-2 mb-3">
                        <strong>Evento:</strong> {{ $apuesta->evento->equipo_local->nombre }} vs {{ $apuesta->evento->equipo_visitante->nombre }}<br>
                        <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($apuesta->evento->fecha_evento)->format('d/m/Y H:i') }}<br>
                        <strong>Predicción:</strong>
                        @if($apuesta->prediccion === 'empate')
                            Empate
                        @else
                            {{ $apuesta->prediccion == $apuesta->evento->equipo_local->id ? $apuesta->evento->equipo_local->nombre : $apuesta->evento->equipo_visitante->nombre }}
                        @endif
                    </div>
                @empty
                    <p class="text-muted">No tienes apuestas pendientes.</p>
                @endforelse
            </div>
        </div>

        <!-- Apuestas realizadas -->
        <div class="card bg-dark text-light mb-4 shadow-lg animate__animated animate__fadeIn">
            <div class="card-header bg-secondary text-white">Apuestas Realizadas</div>
            <div class="card-body">
                @forelse($apuestas_realizadas as $apuesta)
                    <div class="border-bottom border-secondary pb-2 mb-3">
                        <strong>Evento:</strong> {{ $apuesta->evento->equipo_local->nombre }} vs {{ $apuesta->evento->equipo_visitante->nombre }}<br>
                        <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($apuesta->evento->fecha_evento)->format('d/m/Y H:i') }}<br>
                        <strong>Predicción:</strong>
                        @if($apuesta->prediccion === 'empate')
                            Empate
                        @elseif($apuesta->prediccion === 'local')
                            {{ $apuesta->evento->equipo_local->nombre }}
                        @elseif($apuesta->prediccion === 'visitante')
                            {{ $apuesta->evento->equipo_visitante->nombre }}
                        @else
                            {{ $apuesta->prediccion }} {{-- Por si acaso --}}
                        @endif
                    </div>
                @empty
                    <p class="text-muted">Aún no tienes apuestas finalizadas.</p>
                @endforelse
            </div>
        </div>
    @endif
</div>
@endsection



