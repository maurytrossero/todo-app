<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\Api\TagController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


// Rutas protegidas por autenticación con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // CRUD completo protegido
    Route::apiResource('notes', NoteController::class)->except(['create', 'edit']); // Puedes ajustar según tus necesidades

    // Ruta para obtener el usuario autenticado
    Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth:sanctum');

});

// Ruta para obtener todas las etiquetas
Route::get('/tags', [TagController::class, 'index']);

