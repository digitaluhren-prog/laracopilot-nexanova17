<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ListingController as UserListingController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminRatingController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\RatingController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listing/{id}', [HomeController::class, 'show'])->name('listing.show');

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Routes
Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
Route::get('/user/listings', [UserListingController::class, 'index'])->name('user.listings.index');
Route::get('/user/listings/create', [UserListingController::class, 'create'])->name('user.listings.create');
Route::post('/user/listings', [UserListingController::class, 'store'])->name('user.listings.store');
Route::get('/user/listings/{id}/edit', [UserListingController::class, 'edit'])->name('user.listings.edit');
Route::put('/user/listings/{id}', [UserListingController::class, 'update'])->name('user.listings.update');
Route::delete('/user/listings/{id}', [UserListingController::class, 'destroy'])->name('user.listings.destroy');

// Rating Routes
Route::post('/listing/{id}/rating', [RatingController::class, 'store'])->name('rating.store');
Route::delete('/rating/{id}', [RatingController::class, 'destroy'])->name('rating.destroy');

// Admin Authentication
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Admin Categories
Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
Route::post('/admin/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
Route::get('/admin/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/admin/categories/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

// Admin Listings
// Admin Listings
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/listings', [AdminListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/{listing}', [AdminListingController::class, 'show'])->name('listings.show');
    Route::get('/listings/{listing}/edit', [AdminListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [AdminListingController::class, 'update'])->name('listings.update');
    Route::post('/listings/{listing}/approve', [AdminListingController::class, 'approve'])->name('listings.approve');
    Route::post('/listings/{listing}/reject', [AdminListingController::class, 'reject'])->name('listings.reject');
    Route::delete('/listings/{listing}', [AdminListingController::class, 'destroy'])->name('listings.destroy');
});


// Admin Users
Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

// Admin Ratings
Route::get('/admin/ratings', [AdminRatingController::class, 'index'])->name('admin.ratings.index');
Route::post('/admin/ratings/{id}/approve', [AdminRatingController::class, 'approve'])->name('admin.ratings.approve');
Route::delete('/admin/ratings/{id}', [AdminRatingController::class, 'destroy'])->name('admin.ratings.destroy');