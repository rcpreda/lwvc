<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SignalController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ScheduleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'user']);

    Route::post('/events', [EventController::class, 'store']);
    Route::post('/events/{event}', [EventController::class, 'store']);
    Route::get('/events/{event}', [EventController::class, 'show']);
    Route::get('/events', [EventController::class, 'index']);
    Route::delete('/events/{event}', [EventController::class, 'destroy']);

    Route::post('/schedule', [ScheduleController::class, 'store']);
});
