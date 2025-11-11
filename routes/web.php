<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\User\BlogController as UserBlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Blogger\BlogController as BloggerBlogController;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here you can register web routes for your application.
|
*/

// Public pages
// Public pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');
Route::get('/blogs', [BlogController::class, 'publicIndex'])->name('blogs'); // ✅ Use publicIndex()
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::view('/contact', 'contact')->name('contact');

// Dashboard (requires authentication)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (authenticated users only)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/blogs/{blog}/comments', [CommentController::class, 'store'])->name('comments.store');
});

// Admin Dashboard + Management Routes
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manage Blogs (CRUD)
        Route::resource('/blogs', \App\Http\Controllers\Admin\BlogController::class);

        // Manage Users (CRUD + assign admin)
        Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);

        // Settings Page
        Route::resource('/settings', \App\Http\Controllers\Admin\SettingController::class);
    });

// User Dashboard + Blog viewing
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])
            ->name('dashboard');

        // Users can only view blogs, not create
        Route::get('/blogs', [\App\Http\Controllers\User\BlogController::class, 'index'])->name('blogs.index');
        Route::get('/blogs/{slug}', [\App\Http\Controllers\User\BlogController::class, 'show'])->name('blogs.show');
    });

    // ✅ Blogger Dashboard + Blog Management
Route::middleware(['auth', 'role:blogger'])
    ->prefix('blogger')
    ->name('blogger.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('blogger.dashboard');
        })->name('dashboard');
       //Blogger's CRUD
        Route::resource('blogs', \App\Http\Controllers\Blogger\BlogController::class);
    });

// Auth routes (from Breeze)
require __DIR__ . '/auth.php';
