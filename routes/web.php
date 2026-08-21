<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

Route::get('/brand/{slug}', [PageController::class, 'show'])->name('brand.show');

Route::get('/today-deals', [CategoryController::class, 'todayDeals'])->name('today-deals');

Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/privacy-policy', [PageController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('/refund-policy', [PageController::class, 'refundpolicy'])->name('refund-policy');
Route::get('/terms-of-service', [PageController::class, 'termsofservice'])->name('terms-of-service');
Route::get('/warranty-policy', [PageController::class, 'warrantypolicy'])->name('warranty-policy');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');


Route::get('/contact-us', [PageController::class, 'contactus'])->name('contact-us');
Route::post('/contact-us', [ContactMessageController::class, 'store'])->name('contact-us.store');
Route::controller(ContactMessageController::class)->group(function () {
    Route::get('/contact', 'create')->name('contact.create');
    Route::post('/contact', 'store')->name('contact.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/orders/track/{order}', [OrderController::class, 'track'])->name('orders.track');
    Route::get('/orders/review/{order}', [OrderController::class, 'review'])->name('orders.review');
});


Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
});
