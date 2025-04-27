<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\DashboardController;


Route::get('/tic-tac-toe/1', function () {
    return view('tic-tac-toe');
})->name('tic-tac-toe');


Route::get('/rex-runner', function () {
    return view('rex-runner');
});
Route::get('/login', function() {
    return view('login');
});
Route::get('/register', function() {
    return view('register');
});
Route::get('/test', function() {
    return view('test');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/{gameSlug}/{levelSlug}', [GameController::class, 'show'])->name('game.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/dashboard', [DashboardController::class, 'index']);


