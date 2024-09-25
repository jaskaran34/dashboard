<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;


Route::get('/', [mainController::class, 'show_dashboard']);

Route::get('/fetch_data',[mainController::class, 'fetch_data']);
