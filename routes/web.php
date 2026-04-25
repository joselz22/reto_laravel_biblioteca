<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BibliotecaController;

Route::get('/biblioteca', [BibliotecaController::class, 'index']);
Route::post('/biblioteca', [BibliotecaController::class, 'procesar']);
