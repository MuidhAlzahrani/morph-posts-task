<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
            'posts' => Post::with(['user:id,name', 'comments.user'])->latest()->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/dashboard', [PostController::class, 'store'])->name('posts.store');
    Route::post('/dashboard/{post}/comments', [CommentsController::class ,'store'])->name('comments.store');
    Route::patch('/dashboard/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/dashboard/{post}', [PostController::class,'destroy'])->name('posts.destroy');
});

require __DIR__.'/auth.php';
