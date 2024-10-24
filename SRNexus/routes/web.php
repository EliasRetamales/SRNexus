<?php

use App\Http\Controllers\InfluxdbConnectionController;
use App\Http\Controllers\InfluxTestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// routes/web.php

Route::resource('influxdb_connections', InfluxdbConnectionController::class);
Route::get('/test-influx', [InfluxTestController::class, 'testConnection']);
Route::get('/write-influx', [InfluxTestController::class, 'writeData']);

Route::get('/', function () {
    return view('welcome');
});
