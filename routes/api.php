<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\FetchData;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/filter_data', [FetchData::class, 'get_data']);

Route::get('/get_data_topic', function (Request $request) {

    $default_list=$request->listval;
    $label=$request->label;

});
Route::get('/get_data', [FetchData::class, 'get_data']);
//$request->listval