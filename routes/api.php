<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Comment\CommentController;
use App\Http\Controllers\Api\Post\PostController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/user/posts/{post}', [PostController::class, 'comments']);


Route::middleware('auth:api')->group(function () {
    Route::get('/user/posts', [UserController::class, 'index'])->name('user.post.show');
});

Route::middleware('auth:api')->group(function () {
    Route::resource('/profile', ProfileController::class);
});

Route::middleware('auth:api')->group(function () {
    Route::resource('/post', PostController::class);
});

Route::middleware('auth:api')->group(function () {
    Route::resource('/comment', CommentController::class);
});

