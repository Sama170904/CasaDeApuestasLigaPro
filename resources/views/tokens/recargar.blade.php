@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center text-light animate__animated animate__fadeInDown">Recargar Tokens</h2>

    <div class="card bg-dark text-light shadow-lg animate__animated animate__fadeIn">
        <div class="card-body">
            <form action="{{ route('tokens.recargar.guardar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad de tokens a recargar</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-outline-info px-4 py-2">Recargar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
