<?php

use App\Http\Controllers\API\APIAlertController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\APIAuthController;
use App\Http\Controllers\API\APIClientController;
use App\Http\Controllers\API\APIProjectController;
use App\Http\Controllers\API\APIRegisterController;
use App\Http\Controllers\API\APISafeLimiteController;
use App\Http\Controllers\API\APISensorController;

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

    // Rutas para los proyectos
    Route::apiResource('projects', APIProjectController::class);

    // Rutas para los SafeLimites
    Route::apiResource('safe-limites', APISafeLimiteController::class);

    // Rutas para los Sensors
    Route::apiResource('sensors', APISensorController::class);

    // Rutas para los Registers
    Route::apiResource('registers', APIRegisterController::class);

    // Rutas para las Alerts
    Route::apiResource('alerts', APIAlertController::class);
});
