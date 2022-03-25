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
    Route::delete('/events/{event}', [EventController::class, 'destroy']);
    Route::get('/checklink/{userid?}/{linkname?}', [EventController::class, 'checkLink']);

    Route::post('/schedule', [ScheduleController::class, 'store']);
    // Route::post('/schedule/slot-confirm', [ScheduleController::class, 'saveSlot']);
    Route::get('/schedule', [ScheduleController::class, 'index']);
   
    // Route::get('/schedule/{userid?}/{eventname?}', [ScheduleController::class, 'getEventDetails']);
    Route::get('/schedule/setdefault/{id?}', [ScheduleController::class, 'setDefault']);
    Route::get('/schedule/getIndividual/{id?}', [ScheduleController::class, 'getIndividualData']);
    Route::post('/schedule/update', [ScheduleController::class, 'update']);
    Route::delete('/schedule/delete/{id?}', [ScheduleController::class, 'delete']);


    Route::get('/event-schedule-list/{type?}{startdate?}/{enddate?}', [ScheduleController::class, 'getScheduledEvents']);
    Route::get('/slot/check/{eventname?}/{slot?}/{selectdate?}', [ScheduleController::class, 'checkSchedule']);

 // Route::get('/checklogin', [ScheduleController::class, 'check']);



    Route::post('/eventschedule', [EventController::class, 'storeEeventSchedule']);
    // Route::post('/eventschedule/{eventschedule}', [EventController::class, 'storeEeventSchedule']);
});

Route::get('/checklogin', [ScheduleController::class, 'check']);
Route::post('/schedule/slot-confirm', [ScheduleController::class, 'saveSlot']);
Route::get('/schedule/{userid?}/{eventname?}', [ScheduleController::class, 'getEventDetails']);
Route::resource('cal', ScheduleController::class);
Route::get('oauth', [ScheduleController::class,'oauth'])->name('oauthCallback');
