<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('api')->group(function () {
    //User
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/play', [GameController::class, 'play']);
    Route::get('/top-players', [GameController::class, 'fetchTop10Players']);
});

