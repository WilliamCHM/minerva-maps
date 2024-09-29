<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MinervaController;
use App\Http\Controllers\MinervaLaController;
use App\Http\Controllers\MinervaOverlayController;

// Ruta principal
Route::get('/', [MinervaController::class, 'index'])->name('minerva.home');

// Ruta para la página principal
Route::get('/minerva', [MinervaController::class, 'index'])->name('minerva');

// Ruta para mostrar aulas
Route::get('/minerva-la/aula/{id}', [MinervaLaController::class, 'showAula'])->name('minerva-la.aula');

// Ruta para mostrar referencias
Route::get('/minerva-la/referencia/{id}', [MinervaLaController::class, 'showReferencia'])->name('minerva-la.referencia');

// Ruta para otro overlay (por si tienes alguna funcionalidad adicional)
Route::get('/minerva-overley', [MinervaOverlayController::class, 'index'])->name('minerva-overley');
