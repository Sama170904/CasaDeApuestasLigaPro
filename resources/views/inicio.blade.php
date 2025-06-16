@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-5 text-center text-white animate__animated animate__fadeInDown">Eventos para Apostar</h1>

    @if(session('success'))
        <div class="alert alert-success text-center animate__animated animate__fadeIn">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($eventos as $evento)
            <div class="col-md-6 mb-4 animate__animated animate__fadeInUp">
                <div class="card shadow-lg bg-dark text-light border-secondary h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title text-center text-info">
                            {{ $evento->equipo_local->nombre }}
                            <span class="mx-2 text-white">vs</span>
                            {{ $evento->equipo_visitante->nombre }}
                        </h5>
                        <p class="card-text text-center text-muted">
                            Fecha: {{ \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y H:i') }}
                        </p>

                        <div class="text-center mt-3">
                            @auth
                                <a href="{{ route('apostar.form', $evento->id) }}" class="btn btn-success">
                                    Apostar en este evento
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-light">
                                    Inicia sesión para apostar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted animate__animated animate__fadeIn">
                <p>No hay eventos disponibles para apostar por ahora.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection



