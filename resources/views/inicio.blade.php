@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">Eventos para apostar</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($eventos as $evento)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center">
                            {{ $evento->equipo_local->nombre }} 
                            <span class="mx-2">vs</span> 
                            {{ $evento->equipo_visitante->nombre }}
                        </h5>
                        <p class="card-text text-center text-muted">
                            Fecha: {{ \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y H:i') }}
                        </p>

                        <div class="text-center">
                            @auth
                                <a href="{{ route('apostar.form', $evento->id) }}" class="btn btn-primary">
                                    Apostar en este evento
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                    Inicia sesión para apostar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No hay eventos disponibles para apostar por ahora.</p>
        @endforelse
    </div>
</div>
@endsection


