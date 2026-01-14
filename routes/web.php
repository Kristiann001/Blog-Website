<?php

use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\User\BlogController as UserBlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Blogger\BlogController as BloggerBlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContactReplyController;
use App\Http\Controllers\SubscriptionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --------------------
// Public Pages (Guests)
// --------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
// Route::view('/services', 'services')->name('services');
Route::get('/services', [ServicesController::class, 'index'])->name('services');

Route::get('/blogs', [PublicBlogController::class, 'index'])->name('publicblog.index'); // List all blogs
Route::get('/blogs/{slug}', [PublicBlogController::class, 'show'])->name('publicblog.show'); // Single blog

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Route::post('/checkout/mpesa', [PaymentController::class, 'stkPush'])->name('checkout.mpesa');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('services', ServiceController::class);
});
// --------------------
// Authenticated Users
// --------------------
// Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Comment submission
    Route::post('/blogs/{blog}/comments', [CommentController::class, 'store'])->name('comments.store');
});

// Payments (Customers only)
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    // Stripe subscription routes
    Route::post('/services/{service}/subscribe', [SubscriptionController::class, 'checkout'])
        ->name('services.subscribe');
    Route::get('/services/subscription/success', [SubscriptionController::class, 'success'])
        ->name('services.subscription.success');

    // Mpesa
    Route::post('/checkout/mpesa', [PaymentController::class, 'stkPush'])->name('checkout.mpesa');
});

// --------------------
// Admin Routes
// --------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Blog management
        Route::resource('/blogs', AdminBlogController::class);

        // Users management
        Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);

        // Settings
        Route::resource('/settings', \App\Http\Controllers\Admin\SettingController::class);

        // Messages
        Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}', [\App\Http\Controllers\Admin\MessageController::class, 'show'])->name('messages.show');

        Route::post('/messages/{contact}/reply', [ContactReplyController::class, 'store'])
    ->name('admin.messages.reply');

    Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])
        ->name('messages.reply');

        Route::post('/admin/messages/{id}/reply', [ContactReplyController::class, 'store'])
    ->name('admin.messages.reply')
    ->middleware(['auth', 'role:admin']);

        Route::delete('/messages/{message}', [\App\Http\Controllers\Admin\MessageController::class, 'destroy'])->name('messages.destroy');

        // Contacts
        Route::resource('/contacts', \App\Http\Controllers\Admin\ContactController::class)->only(['index', 'show', 'destroy']);
    });

// --------------------
// User Routes
// --------------------
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])
            ->name('dashboard');

        // Blogs for authenticated users
        Route::get('/blogs', [UserBlogController::class, 'index'])->name('blogs.index');
        Route::get('/blogs/{slug}', [UserBlogController::class, 'show'])->name('blogs.show');
    });

// --------------------
// Blogger Routes
// --------------------
Route::middleware(['auth', 'role:blogger'])
    ->prefix('blogger')
    ->name('blogger.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('blogger.dashboard');
        })->name('dashboard');

        // Blogger blog CRUD
        Route::resource('blogs', BloggerBlogController::class);
    });

// --------------------
// Auth routes (Breeze/Jetstream)
// --------------------
require __DIR__ . '/auth.php';
