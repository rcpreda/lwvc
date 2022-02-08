<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SignalController;


Route::view('/{any}', 'app')->where('any', '.*')->name('app');
Route::middleware(['auth'])->group(function () {



    Route::get('/chat', function () {
        return view('chat');
    })->name('chat');

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/signals', [SignalController::class, 'store']);
    Route::get('/signals/{signal}', [SignalController::class, 'show']);
});
