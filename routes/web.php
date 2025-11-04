<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // Make sure this is imported
use App\Http\Controllers\Admin; // Import Admin namespace
use App\Http\Controllers\Admin\DirectorMessageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{post}', [HomeController::class, 'show'])->name('post.show');
Route::get('/category/{category}', [HomeController::class, 'category'])->name('category.show');
// --- Add Route for All Posts Page ---
Route::get('/posts', [HomeController::class, 'allPosts'])->name('posts.index');
// --- End ---


// Authenticated User Routes (Dashboard, Profile)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard'); // Assuming dashboard is for general users

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin Routes
// Prefix '/admin', Name Prefix 'admin.', Middleware 'auth' (and potentially 'admin' role middleware)
Route::middleware(['auth', /* 'admin' */])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard (Example)
    Route::get('/', function () {
        return view('admin.dashboard'); // Create this view if needed
    })->name('dashboard');

    // Resource Controllers for Admin
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('posts', Admin\PostController::class);
    Route::resource('menus', Admin\MenuController::class);
    Route::resource('users', Admin\UserController::class); // Assuming you have this

    // --- Add Routes for DataTables and Bulk Delete ---
    Route::get('posts-data', [Admin\PostController::class, 'getPostsData'])->name('posts.data');
    Route::delete('posts/bulk-destroy', [Admin\PostController::class, 'bulkDestroy'])->name('posts.bulkDestroy');

    Route::get('/director/edit', [DirectorMessageController::class, 'edit'])->name('director.edit');
    Route::put('/director/update', [DirectorMessageController::class, 'update'])->name('director.update');

});


require __DIR__ . '/auth.php';
