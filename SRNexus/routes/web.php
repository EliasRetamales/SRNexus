<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InfluxdbConnectionController;
use App\Http\Controllers\InfluxTestController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SafeLimitController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\UserController;
use App\Models\InfluxdbConnection;
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
    Route::resource('clients', ClientController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('safe_limits', SafeLimitController::class);
    Route::resource('sensors', SensorController::class);
    Route::resource('registers',RegisterController::class);
    Route::resource('alerts',AlertController::class);
    Route::resource('influxdb_connections',InfluxdbConnection::class);

    // Ruta para el dashboard de proyectos
    Route::get('allprojects/dashboard', [ProjectController::class, 'dashboard'])->name('projects.dashboard');

    // Ruta para el dashboard de sensores de un proyecto
    Route::get('/projects/{project}/sensors', [SensorController::class, 'dashboard'])->name('sensors.dashboard');

    Route::get('/sensors/{sensor}/chart', [SensorController::class, 'showChart'])->name('sensors.chart');

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
