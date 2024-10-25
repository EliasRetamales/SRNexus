<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\APIAuthController;
use App\Http\Controllers\API\APIClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar rutas para tu API. Estas rutas son cargadas
| por el RouteServiceProvider dentro de un grupo que contiene el middleware "api".
|
*/

// Ruta de inicio de sesión
Route::post('/login', [APIAuthController::class, 'login']);

// Rutas protegidas por autenticación
Route::middleware(['auth:sanctum'])->group(function () {
    // Ruta de cierre de sesión
    Route::post('/logout', [APIAuthController::class, 'logout']);

    // Rutas para los clientes
    Route::apiResource('clients', APIClientController::class);
});
