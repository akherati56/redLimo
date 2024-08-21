<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [RegisterController::class, 'login']);
Route::post('/register', [RegisterController::class, 'store']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user/posts', [UserController::class, 'show'])->name('user.post.show');
});

Route::post('/protect', function (Request $request) {
    return response()->json(['api works']);
})->middleware('auth:api');

Route::middleware('auth:api')->group(function () {
    Route::resource('/profile', ProfileController::class);
});

Route::middleware('auth:api')->group(function () {
    Route::resource('/post', PostController::class);
});

Route::middleware('auth:api')->group(function () {
    Route::resource('/comment', CommentController::class);
});