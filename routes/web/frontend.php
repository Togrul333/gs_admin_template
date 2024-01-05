<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return view('errors.404');
});

Route::middleware(['guest:web'])->group(function () {
    Route::post('/loginForm', [AuthController::class, 'login'])->name('login');
    Route::get('/registerForm', [AuthController::class, 'registerForm'])->name('register.form');
    Route::post('/registerForm', [AuthController::class, 'register'])->name('register');
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// index
Route::get('/', [IndexController::class, 'index'])->name('dashboard');


//contact
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::post('/contact-save/request', [ContactController::class, 'contactSendRequest'])->name('contactSendRequest');

//about
Route::get('/about', [AboutController::class, 'about'])->name('about');

//search
Route::get('/search-page', [SearchController::class, 'search'])->name('searchPage');

//auth
Route::middleware(['auth:web'])->group(function () {
    //checkout
    Route::post('checkout/package', [CheckoutController::class, 'package'])->name('checkout.package');
    Route::match(['post', 'get'], 'checkout/approved', [CheckoutController::class, 'approved'])->name('checkout.approved');
    Route::match(['post', 'get'], 'checkout/canceled', [CheckoutController::class, 'canceled'])->name('checkout.canceled');
    Route::match(['post', 'get'], 'checkout/declined', [CheckoutController::class, 'declined'])->name('checkout.declined');

    //profile
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'profileUpdate'])->name('profileUpdate');
});

//lang
Route::get('lang/{lang}', [LanguageController::class, 'changeLanguage'])->name('lang.switch');

