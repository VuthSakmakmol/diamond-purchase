<?php

use App\Http\Controllers\DiamondController;

Route::get('/', [DiamondController::class, 'index']);
Route::post('/choose', [DiamondController::class, 'store'])->name('choose');
