<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth.api')->group(function () {
    Route::get('/settings', [ApiController::class, 'getSettings'])->name('settings');
    Route::post('/sensor-data', [ApiController::class, 'addSensorData'])->name('add.sensor.data');
});
