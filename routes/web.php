<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserOrderController;



use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

// ==================== HOME ====================
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/search', [PageController::class, 'search'])->name('search');

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
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blogs.view');

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

// ==================== AUTHENTICATED ROUTES ====================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/profile', function () {
        return view('user.profile');
    })->name('user.profile');

    // User Orders (My Orders)
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('user.orders');
    Route::get('/my-orders/{order}', [UserOrderController::class, 'show'])->name('user.order.view');
    Route::get('/my-orders/{order}/track', [UserOrderController::class, 'track'])->name('user.order.track');

    // Cart Routes
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('user.cart');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::patch('/cart/update/{cart}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/checkout/address/create', [CheckoutController::class, 'createAddress'])->name('checkout.address.create');
    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])->name('checkout.address.store');
    Route::post('/checkout/continue', [CheckoutController::class, 'continueCheckout'])->name('checkout.continue');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');

    // ✅ Order Routes (User)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('orders.track');
    Route::get('/orders/{order}/review', [OrderController::class, 'review'])->name('orders.review');
    Route::post('/orders/{order}/review', [OrderController::class, 'submitReview'])->name('orders.review.submit');

    // Wishlist
    Route::get('/wishlist', function () {
        return view('user.wishlist.index');
    })->name('user.wishlist');

<<<<<<< HEAD
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');

    Route::get('/cart', [CartController::class, 'index'])->name('user.cart');

    Route::delete('/cart/remove/{cart}', [CartController::class, 'removeFromCart'])->name('cart.remove');

   Route::patch('/cart/update/{cart}', [CartController::class, 'updateQuantity'])->name('cart.update');



    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout');

    Route::get('/checkout/address/create', [CheckoutController::class, 'createAddress'])
        ->name('checkout.address.create');

    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])
        ->name('checkout.address.store');

    Route::post('/checkout/continue', [CheckoutController::class, 'continueCheckout'])
        ->name('checkout.continue');

    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])
        ->name('checkout.place-order');




        Route::get('/wishlist', function () {
            return view('user.wishlist.index');
        })->name('user.wishlist');



        Route::get('/addresses', function () {
=======
    // Addresses
    Route::get('/addresses', function () {
>>>>>>> dd79b8318b514c5a7f6698fe2558f3f2792f407f
        return view('user.addresses.index');
    })->name('user.addresses');

    // Reviews
    Route::get('/reviews', function () {
        return view('user.reviews.index');
    })->name('user.reviews');

    // Coupons
    Route::get('/coupons', function () {
        return view('user.coupons.index');
    })->name('user.coupons');

    // Settings
    Route::get('/settings', function () {
        return view('user.settings');
    })->name('user.settings');
});



