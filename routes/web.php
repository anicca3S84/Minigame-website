<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\DashboardController;

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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [DashboardController::class, 'index']);

//spelling-word
// Route::get('/{gameSlug}', [GameController::class, 'showGame'])->name('game.showGame');
Route::get('/game/{gameSlug}/topic/{topicSlug}/questions', [GameController::class, 'getQuestions'])->name('game.getQuestions');

