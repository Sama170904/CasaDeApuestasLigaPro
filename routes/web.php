<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ApuestaController;

// Página pública
Route::get('/', [EventoController::class, 'index'])->name('inicio');

// Panel de usuarios normales
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ApuestaController::class, 'dashboard'])->name('dashboard');

    // Apostar
    Route::get('/apostar/{evento}', [ApuestaController::class, 'apostar'])->name('apostar.form');
    Route::post('/apostar/{evento}', [ApuestaController::class, 'store'])->name('apostar.guardar');
}); 

// Panel de administración
Route::middleware(['auth', 'es_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [ApuestaController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/eventos', [EventoController::class, 'index'])->name('admin.eventos.index');

    Route::get('/eventos/create', [EventoController::class, 'create'])->name('admin.eventos.create');
    Route::post('/eventos', [EventoController::class, 'store'])->name('admin.eventos.store');
    Route::get('/eventos/{evento}/edit', [EventoController::class, 'edit'])->name('admin.eventos.edit');
    Route::put('/eventos/{evento}', [EventoController::class, 'update'])->name('admin.eventos.update');
    Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])->name('admin.eventos.destroy');
    Route::put('/eventos/{evento}/finalizar', [EventoController::class, 'finalizar'])->name('admin.eventos.finalizar');
});

require __DIR__.'/auth.php';



