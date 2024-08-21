<?php

use App\Http\Controllers\Api\RegisterController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/login', [RegisterController::class, 'login']);

Route::post('/register', [RegisterController::class, 'store']);

Route::post('/protect', function (Request $request) {
    return response()->json(['api works']);

})->middleware('auth:api');


