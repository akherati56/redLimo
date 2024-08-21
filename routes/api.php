<?php

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth:api')->group(function () {
    Route::post('/post/upload', [PostController::class, 'store'])->name('post.upload');
    Route::get('/post', [PostController::class, 'show'])->name('post.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/post/{id}', [PostController::class, 'delete'])->name('post.delete');
});