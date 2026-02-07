<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\ListingController as UserListingController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminRatingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RatingController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listing/{id}', [HomeController::class, 'show'])->name('listing.show');

// User Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Dashboard Routes
Route::get('/user/dashboard', [UserProfileController::class, 'dashboard'])->name('user.dashboard');
Route::get('/user/profile', [UserProfileController::class, 'profile'])->name('user.profile');
Route::put('/user/profile', [UserProfileController::class, 'updateProfile'])->name('user.profile.update');

// User Listings Routes
Route::get('/user/listings', [UserListingController::class, 'index'])->name('user.listings.index');
Route::get('/user/listings/create', [UserListingController::class, 'create'])->name('user.listings.create');
Route::post('/user/listings', [UserListingController::class, 'store'])->name('user.listings.store');
Route::get('/user/listings/{id}/edit', [UserListingController::class, 'edit'])->name('user.listings.edit');
Route::put('/user/listings/{id}', [UserListingController::class, 'update'])->name('user.listings.update');
Route::delete('/user/listings/{id}', [UserListingController::class, 'destroy'])->name('user.listings.destroy');

// Rating Routes (User)
Route::post('/listing/{id}/rate', [RatingController::class, 'store'])->name('rating.store');
Route::delete('/rating/{id}', [RatingController::class, 'destroy'])->name('rating.destroy');

// Admin Authentication Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Admin Users Management
Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
Route::get('/admin/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

// Admin Listings Management
Route::get('/admin/listings', [AdminListingController::class, 'index'])->name('admin.listings.index');
Route::get('/admin/listings/pending', [AdminListingController::class, 'pending'])->name('admin.listings.pending');
Route::post('/admin/listings/{id}/approve', [AdminListingController::class, 'approve'])->name('admin.listings.approve');
Route::post('/admin/listings/{id}/reject', [AdminListingController::class, 'reject'])->name('admin.listings.reject');
Route::delete('/admin/listings/{id}', [AdminListingController::class, 'destroy'])->name('admin.listings.destroy');

// Admin Categories Management
Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
Route::post('/admin/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
Route::get('/admin/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/admin/categories/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

// Admin Ratings Management
Route::get('/admin/ratings', [AdminRatingController::class, 'index'])->name('admin.ratings.index');
Route::post('/admin/ratings/{id}/approve', [AdminRatingController::class, 'approve'])->name('admin.ratings.approve');
Route::delete('/admin/ratings/{id}', [AdminRatingController::class, 'destroy'])->name('admin.ratings.destroy');