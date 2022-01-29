<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SignalController;


Route::middleware(['auth'])->group(function () {

    Route::view('/{any}', 'app')->where('any', '.*')->name('app');

    Route::get('/chat', function () {
        return view('chat');
    })->name('chat');

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/signals', [SignalController::class, 'store']);
    Route::get('/signals/{signal}', [SignalController::class, 'show']);
});


Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::get('/signup', [AuthController::class, 'signupForm'])->name('signup');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::view('/{any}', '404')->where('any', '.*');