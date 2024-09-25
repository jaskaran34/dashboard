<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/get_data', function (Request $request) {

    if($request->query('val')=='1'){

    
    $arr = [1, 139, 13, 35, 12, 3];
        return json_encode($arr);

    }
    else{
        $arr = [11, 13, 3, 5, 42, 63];
        return json_encode($arr);
    }

})->name('get_data');
