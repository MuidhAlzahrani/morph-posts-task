<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::get('adminLogin', function(){
    return redirect('/admin/login');
})->name('adminLogin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('dashboard', [PostController::class, 'store'])->name('posts.store');
    Route::get('dashboard/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::patch('dashboard/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('dashboard/{post}', [PostController::class,'destroy'])->name('posts.destroy');

    Route::post('dashboard/{post}', [CommentsController::class ,'store'])->name('comments.store');
});

require __DIR__.'/auth.php';
