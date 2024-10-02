<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NoteController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');


Route::get('/notes', [NoteController::class, 'index']);     // Obtener todas las notas
Route::post('/notes', [NoteController::class, 'store']);    // Crear una nueva nota
Route::get('/notes/{id}', [NoteController::class, 'show']); // Obtener una nota específica
Route::put('/notes/{id}', [NoteController::class, 'update']); // Actualizar una nota
Route::delete('/notes/{id}', [NoteController::class, 'destroy']); // Eliminar una nota