<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // Make sure HomeController is imported
use App\Http\Controllers\Admin\CategoryController; // Import Admin Controllers
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;

// Public Routes (Frontend)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{post}', [HomeController::class, 'show'])->name('post.show');
// Changed route binding from {category:slug} to {category}
Route::get('/category/{category}', [HomeController::class, 'category'])->name('category.show');

// Breeze Dashboard Route (uses AppLayout which points to admin layout)
Route::get('/dashboard', function () {
    return view('dashboard'); // Points to dashboard.blade.php
})->middleware(['auth'])->name('dashboard'); // Removed verified middleware for simplicity

// Admin Routes Group
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // CRUD Categories
    Route::resource('categories', CategoryController::class)->except(['show']); // No show view needed

    // CRUD Menus
    Route::resource('menus', MenuController::class)->except(['show']);

    // CRUD Users
    Route::resource('users', UserController::class)->except(['show']);

    // CRUD Posts
    Route::resource('posts', PostController::class)->except(['show']);
});


// Breeze Profile Routes (Keep them if you want admin profile editing)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
