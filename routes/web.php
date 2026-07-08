<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ---------- Public ----------
Route::get('/', [HomeController::class, 'Index'])->name('home');

// ---------- Auth scaffolding ----------
require __DIR__ . '/auth.php';

Route::get('/verify', [AdminController::class, 'ShowVerification'])->name('custom.verification.form');
Route::post('/verify', [AdminController::class, 'VerificationVerify'])->name('custom.verification.verify');

Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
Route::post('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

// ---------- Authenticated ----------
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/profile/store', [AdminController::class, 'ProfileStore'])->name('profile.store');
    Route::post('/admin/password/update', [AdminController::class, 'PasswordUpdate'])->name('admin.password.update');

    // Reviews
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/all/review', 'AllReview')->name('all.review');
        Route::get('/add/review', 'AddReview')->name('add.review');
        Route::post('/store/review', 'StoreReview')->name('store.review');
        Route::get('/edit/review/{id}', 'EditReview')->name('edit.review');
        Route::post('/update/review', 'UpdateReview')->name('update.review');
        Route::post('/delete/review/{id}', 'DeleteReview')->name('delete.review');
    });

    // Slider
    Route::controller(SliderController::class)->group(function () {
        Route::get('/get/slider', 'GetSlider')->name('get.slider');
        Route::post('/update/slider', 'UpdateSlider')->name('update.slider');
        Route::post('/edit/slider', 'EditSlider')->name('edit.slider');
        Route::post('/edit/title', 'EditTitle')->name('edit.title');
    });
});
