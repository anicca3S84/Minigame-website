<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
Route::get('/', function () {
    return view('tic-tac-toe');
});


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

Route::get('/{gameSlug}/{levelSlug}', [GameController::class, 'show'])->name('game.show');