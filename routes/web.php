<?php

// use App\Http\Controllers\API\GameController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('welcome');
});


Route::get('/greeting', function () {
    return view('greeting');
});
