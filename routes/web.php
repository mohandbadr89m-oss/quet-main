
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LegacyController;


// =========================================
// Main Pages
// =========================================

Route::get('/', [HomeController::class, 'landing'])
    ->name('home');

Route::get('/library', [HomeController::class, 'index'])
    ->name('library');

Route::get('/museum', [HomeController::class, 'museum'])
    ->name('museum');


// =========================================
// Eternal Legacy Hall
// =========================================

// Public page: everyone can view
Route::get('/legacy', [LegacyController::class, 'index'])
    ->name('legacy');

// Admin and Owner management
Route::middleware(['auth', 'role:admin'])
    ->prefix('legacy')
    ->name('legacy.')
    ->group(function () {

        Route::post('/', [LegacyController::class, 'store'])
            ->name('store');

        Route::patch('/{legacyQuote}', [LegacyController::class, 'update'])
            ->name('update');

        Route::delete('/{legacyQuote}', [LegacyController::class, 'destroy'])
            ->name('destroy');

    });


// =========================================
// Authentication
// =========================================

Route::get('/signup', [AuthController::class, 'showSignup'])
    ->middleware('guest')
    ->name('signup');

Route::post('/signup', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('signup.store');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// =========================================
// Profiles
// =========================================

Route::get('/profile', [ProfileController::class, 'index'])
    ->middleware('auth')
    ->name('profile');

Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])
    ->middleware('auth')
    ->name('profile.avatar');

Route::get('/authors/{user}', [ProfileController::class, 'show'])
    ->name('authors.show');


// =========================================
// Quote Interactions
// =========================================

Route::post('/quotes/{quote}/like', [LikeController::class, 'toggle'])
    ->middleware('auth')
    ->name('quotes.like');

Route::post('/quotes/{quote}/favorite', [FavoriteController::class, 'toggle'])
    ->middleware('auth')
    ->name('quotes.favorite');


// =========================================
// Quote Management
// =========================================

Route::post('/quotes', [QuoteController::class, 'store'])
    ->middleware('auth')
    ->name('quotes.store');

Route::patch('/quotes/{quote}', [QuoteController::class, 'update'])
    ->middleware('auth')
    ->name('quotes.update');

Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])
    ->middleware('auth')
    ->name('quotes.destroy');


// =========================================
// Admin Dashboard
// =========================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'index'])
            ->name('dashboard');

    });


// =========================================
// Owner Only
// =========================================

Route::middleware(['auth', 'role:owner'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::post('/admins', [AdminController::class, 'storeAdmin'])
            ->name('admins.store');

        Route::patch('/admins/{user}/revoke', [AdminController::class, 'revokeAdmin'])
            ->name('admins.revoke');

    });
