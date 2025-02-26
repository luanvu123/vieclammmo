<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


Route::get('/', [SiteController::class, 'index'])->name('/');
Route::get('/ho-tro', [SiteController::class, 'support'])->name('support.site');
Route::get('/danh-muc', [SiteController::class, 'category'])->name('category.site');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Đăng ký và Đăng nhập

// Hiển thị form đăng nhập
Route::get('/customer/login', function () {
    return view('customer.login');
})->name('login.customer');

// Xử lý đăng nhập
Route::post('/customer/login', [CustomerAuthController::class, 'login'])->name('login.customer');

// Xử lý đăng ký
Route::post('/customer/register', [CustomerAuthController::class, 'register'])->name('register.customer');

// Đăng xuất
Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('logout.customer');
// Google Login
Route::get('/auth/google', [CustomerAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [CustomerAuthController::class, 'handleGoogleCallback']);




Route::middleware('auth:customer')->group(function () {
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile.site');
    Route::get('/profile/edit', [CustomerController::class, 'profileEdit'])->name('profile.edit.site');
    Route::post('/profile/update', [CustomerController::class, 'profileUpdate'])->name('profile.update.site');
});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubCategoryController::class);
});
