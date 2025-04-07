<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('tic-tac-toe');
});


Route::get('/rex-runner', function () {
    return view('rex-runner');
});