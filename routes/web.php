<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;

// ==================== HOME ====================
Route::get('/', [PageController::class, 'home'])->name('home');

// ==================== AUTHENTICATION ====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== CONTACT PAGE ====================
Route::get('/contact-us', [PageController::class, 'contactus'])->name('contact-us');
Route::post('/contact-us', [ContactMessageController::class, 'store'])->name('contact-us.store');
Route::controller(ContactMessageController::class)->group(function () {
    Route::get('/contact', 'create')->name('contact.create');
    Route::post('/contact', 'store')->name('contact.store');
});


// ==================== BLOG ROUTES ====================
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

// ==================== PRODUCTS & CATEGORIES ====================
Route::get('/brand/{slug}', [PageController::class, 'show'])->name('brand.show');
Route::get('/today-deals', [CategoryController::class, 'todayDeals'])->name('today-deals');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// ==================== STATIC PAGES ====================
Route::get('/privacy-policy', [PageController::class, 'privacypolicy'])->name('privacy-policy');
Route::get('/refund-policy', [PageController::class, 'refundpolicy'])->name('refund-policy');
Route::get('/terms-of-service', [PageController::class, 'termsofservice'])->name('terms-of-service');
Route::get('/warranty-policy', [PageController::class, 'warrantypolicy'])->name('warranty-policy');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');

// ==================== USER DASHBOARD (AUTHENTICATED) ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    Route::get('/dashboard/profile', function () {
        return view('user.profile');
    })->name('user.profile');

    Route::get('/my-orders/{order}', [UserOrderController::class, 'show'])->name('user.order.view');
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('user.orders');

    Route::get('/wishlist', function () {
        return view('user.wishlist.index');
    })->name('user.wishlist');

    Route::get('/cart', function () {
        return view('user.cart.index');
    })->name('user.cart');

    Route::get('/addresses', function () {
        return view('user.addresses.index');
    })->name('user.addresses');

    Route::get('/reviews', function () {
        return view('user.reviews.index');
    })->name('user.reviews');

    Route::get('/coupons', function () {
        return view('user.coupons.index');
    })->name('user.coupons');

    Route::get('/settings', function () {
        return view('user.settings');
    })->name('user.settings');
});

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
});



Route::get('/blogs', [BlogController::class, 'index'])
    ->name('blogs.index');



Route::get('/blog/{slug}', [BlogController::class, 'show'])
    ->name('blogs.view');
