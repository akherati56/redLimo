<?php

use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Web\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Auth::login(User::find(1));

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/post/upload', [PostController::class, 'store'])->name('post.upload');
    Route::get('/post', [PostController::class, 'show'])->name('post.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/post/{id}', [PostController::class, 'delete'])->name('post.delete');
});


Route::middleware('auth')->group(function () {
    Route::get('/user/posts', [UserController::class, 'show'])->name('user.post.show');
});


require __DIR__ . '/auth.php';
