<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ApuestaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web para tu aplicación.
| Estas rutas son cargadas por el RouteServiceProvider dentro del grupo "web".
|
*/

// Página principal pública que muestra eventos
Route::get('/', [EventoController::class, 'index'])->name('inicio');

// Rutas protegidas (solo para usuarios autenticados)
Route::middleware(['auth'])->group(function () {

    // Panel principal del usuario autenticado
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas para gestionar eventos (solo para administradores o usuarios con permisos)
    Route::resource('eventos', EventoController::class);

    // Mostrar formulario para apostar en un evento
    Route::get('/apostar/{evento}', [ApuestaController::class, 'apostar'])->name('apostar.form');

    // Procesar formulario de apuesta
    Route::post('/apostar/{evento}', [ApuestaController::class, 'store'])->name('apostar.guardar');
});

// Rutas de autenticación (login, register, etc.)
require __DIR__.'/auth.php';



