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
    Route::get('/dashboard', [ApuestaController::class, 'dashboard'])
        ->middleware(['auth'])
        ->name('dashboard');


    // Rutas para gestionar eventos (solo para administradores o usuarios con permisos)
    Route::resource('eventos', EventoController::class);

    // Mostrar formulario para apostar en un evento
    Route::get('/apostar/{evento}', [ApuestaController::class, 'apostar'])->name('apostar.form');

    // Procesar formulario de apuesta
    Route::post('/apostar/{evento}', [ApuestaController::class, 'store'])->name('apostar.guardar');
});

Route::middleware(['auth', 'es_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/eventos/create', [EventoController::class, 'create'])->name('admin.eventos.create');
    Route::post('/eventos', [EventoController::class, 'store'])->name('admin.eventos.store');
    Route::get('/eventos/{id}/edit', [EventoController::class, 'edit'])->name('admin.eventos.edit');
    Route::put('/eventos/{id}', [EventoController::class, 'update'])->name('admin.eventos.update');
    Route::delete('/eventos/{id}', [EventoController::class, 'destroy'])->name('admin.eventos.destroy');
    Route::put('/eventos/{id}/finalizar', [EventoController::class, 'finalizar'])->name('admin.eventos.finalizar');
});


// Rutas de autenticación (login, register, etc.)
require __DIR__.'/auth.php';



