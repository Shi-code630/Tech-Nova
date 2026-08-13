<?php

use App\Http\Controllers\BrandController; // agar BrandController hai
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
   // return view('welcome');
//});

Route::get('/', [PageController::class, 'home'])->name('home');



Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

Route::get('/brand/{slug}', [PageController::class, 'show'])->name('brand.show');

  Route::get('/today-deals', [CategoryController::class, 'todayDeals'])
    ->name('today-deals');

Route::get('/category/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');

Route::get('/product/{slug}', [ProductController::class, 'show'])
    ->name('product.show');




Route::get('/privacy-policy', [PageController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('/refund-policy', [PageController::class, 'refundpolicy'])->name('refund-policy');
Route::get('/terms-of-service', [PageController::class, 'termsofservice'])->name('terms-of-service');
Route::get('/contact-us', [PageController::class, 'contactus'])->name('contact-us');
Route::get('/warranty-policy', [PageController::class, 'warrantypolicy'])->name('warranty-policy');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');



