<?php

use App\Http\Controllers\InfluxdbConnectionController;
use App\Http\Controllers\InfluxTestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Ruta de inicio
Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

// Rutas protegidas por autenticación y rol 'admin'
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

// Rutas de autenticación y verificación de correo electrónico
Route::middleware('auth')->group(function () {
    // Ruta para mostrar la notificación de verificación
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // Ruta para verificar el correo electrónico
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/dashboard');
    })->middleware(['signed'])->name('verification.verify');

    // Ruta para reenviar la notificación de verificación
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Se ha enviado un nuevo enlace de verificación a tu correo electrónico.');
    })->middleware(['throttle:6,1'])->name('verification.send');

    // Rutas protegidas que requieren autenticación y verificación de correo
    Route::middleware(['verified'])->group(function () {
        // Ruta al dashboard
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // Rutas de recursos y otras rutas protegidas
        Route::resource('influxdb_connections', InfluxdbConnectionController::class);
        Route::get('/test-influx', [InfluxTestController::class, 'testConnection']);
        Route::get('/write-influx', [InfluxTestController::class, 'writeData']);
    });
});
