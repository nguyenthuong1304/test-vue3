<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::view('/{any}', 'dashboard')
    ->middleware('auth')
    ->where('any', '.*');
