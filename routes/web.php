<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;


Route::get('/', [mainController::class, 'show_dashboard']);

Route::get('/fetch_data',[mainController::class, 'fetch_data']);

Route::post('/get_data',[mainController::class, 'get_data'])->name('get_data');
